<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicantDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudyProgram;
use App\Models\ApplicationAttachment;
use App\Rules\BirthNumber;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function programsIndex()
    {
        $programs = StudyProgram::where('is_active', true)->get();
        return view('programs.index', compact('programs'));
    }

    public function create($program_id)
    {
        $program = StudyProgram::findOrFail($program_id);

        $existingApp = Application::where('user_id', Auth::id())
            ->where('study_program_id', $program_id)
            ->where('status', 'draft')
            ->first();

        if ($existingApp) {
            return redirect()->route('application.step1', $existingApp->id);
        }

        $app = Application::create([
            'user_id' => Auth::id(),
            'study_program_id' => $program->id,
            'status' => 'draft',
        ]);

        ApplicantDetail::create(['application_id' => $app->id]);

        return redirect()->route('application.step1', $app->id);
    }

    public function step1($id)
    {
        $application = Application::with('details')->where('user_id', Auth::id())->findOrFail($id);

        return view('application.personal', compact('application'));
    }

    public function storeStep1(Request $request, $id)
    {
        $application = Application::where('user_id', Auth::id())->findOrFail($id);
        $isExit = $request->has('save_and_exit');

        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|in:Muž,Žena',
            'birth_number' => ['required', 'string', new BirthNumber],
            'birth_date' => 'required|date|before:-18 years',
            'birth_city' => 'required|string|max:255',
            'citizenship' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => ['required', 'regex:/^(\+420)?\s?[1-9][0-9]{2}\s?[0-9]{3}\s?[0-9]{3}$/'],
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => ['required', 'regex:/^\d{3}\s?\d{2}$/'],
        ];

        if ($isExit) {
            $rules = array_map(fn($rule) => is_string($rule) ? str_replace('required', 'nullable', $rule) : $rule, $rules);
        }

        $data = $request->validate($rules, [
            'birth_date.before' => 'Uchazeč musí být starší 18 let.',
            'phone.regex' => 'Telefonní číslo nemá správný formát.',
            'zip.regex' => 'PSČ nemá správný formát.',
        ]);

        $application->details()->update($data);

        if ($isExit) return redirect()->route('dashboard');
        return redirect()->route('application.step2', $application->id);
    }

    public function step2($id)
    {
        $application = Application::with('details')->where('user_id', Auth::id())->findOrFail($id);

        return view('application.education', compact('application'));
    }

    public function storeStep2(Request $request, $id)
    {
        $application = Application::where('user_id', Auth::id())->findOrFail($id);
        $isExit = $request->has('save_and_exit');
        $isBack = $request->has('go_back');

        $gradYear = $request->input('graduation_year');
        $gradeAvg = $request->input('grade_average');

        $hasGradData = !empty($gradYear) || !empty($gradeAvg) || $request->hasFile('maturita_file');

        $rules = [
            'previous_school' => 'required|string|max:255',
            'izo' => 'required|string|max:50',
            'school_type' => 'required|string|max:50',
            'previous_study_field' => 'required|string|max:255',
            'previous_study_field_code' => 'required|string|max:50',

            'graduation_year' => $hasGradData ? 'required|numeric|digits:4' : 'nullable',
            'grade_average' => $hasGradData ? 'required|numeric|between:1.00,5.00' : 'nullable',
            'maturita_file' => ($hasGradData && !$application->attachments()->where('type', 'maturita')->exists()) ? 'required|file|mimes:pdf,jpg,png|max:10240' : 'nullable|file',
        ];

        if ($isExit || $isBack) {
            $rules = array_map(fn($r) => is_string($r) ? str_replace('required', 'nullable', $r) : $r, $rules);
            $rules['graduation_year'] = 'nullable|numeric|digits:4';
            $rules['grade_average'] = 'nullable|numeric';
            $rules['maturita_file'] = 'nullable';
        }

        $data = $request->validate($rules);

        if ($request->hasFile('maturita_file')) {
            $old = $application->attachments()->where('type', 'maturita')->first();
            if ($old) {
                Storage::disk('public')->delete($old->disk_path);
                $old->delete();
            }

            $file = $request->file('maturita_file');
            $path = $file->store('applications/' . $application->id, 'public');

            $application->attachments()->create([
                'type' => 'maturita',
                'filename' => $file->getClientOriginalName(),
                'disk_path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);
        }
        unset($data['maturita_file']);

        $application->details()->update($data);

        if ($isExit) return redirect()->route('dashboard');
        if ($isBack) return redirect()->route('application.step1', $application->id);

        return redirect()->route('application.step3', $application->id);
    }

    public function step3($id)
    {
        $application = Application::with('details')->where('user_id', Auth::id())->findOrFail($id);
        return view('application.additional', compact('application'));
    }

    public function storeStep3(Request $request, $id)
    {
        $application = Application::where('user_id', Auth::id())->findOrFail($id);
        $isExit = $request->has('save_and_exit');
        $isBack = $request->has('go_back');

        $data = $request->validate([
            'specific_needs' => 'nullable|string',
            'note' => 'nullable|string',
            'other_files.*' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
        ]);

        if ($request->hasFile('other_files')) {
            foreach ($request->file('other_files') as $file) {
                $path = $file->store('applications/' . $application->id, 'public');
                $application->attachments()->create([
                    'type' => 'other',
                    'filename' => $file->getClientOriginalName(),
                    'disk_path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
            }
        }
        unset($data['other_files']);

        $application->details()->update($data);

        if ($isExit) return redirect()->route('dashboard');
        if ($isBack) return redirect()->route('application.step2', $application->id);

        return redirect()->route('application.step4', $application->id);
    }

    public function deleteAttachment($id, $attachmentId)
    {
        $attachment = ApplicationAttachment::where('application_id', $id)->findOrFail($attachmentId);

        if ($attachment->application->user_id !== Auth::id()) {
            abort(403);
        }

        Storage::disk('public')->delete($attachment->disk_path);
        $attachment->delete();

        return redirect()->back()->with('success', 'Soubor byl odstraněn.');
    }

    public function step4($id)
    {
        $application = Application::with('details')->where('user_id', Auth::id())->findOrFail($id);
        return view('application.summary', compact('application'));
    }

    public function submit(Request $request, $id)
    {
        $application = Application::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'consent' => 'accepted',
        ]);

        $appNumber = date('Y') . str_pad($application->id, 4, '0', STR_PAD_LEFT);

        $application->update([
            'status' => 'submitted',
            'submitted_at' => now(),
            'application_number' => $appNumber,
        ]);

        return redirect()->route('dashboard')->with('success', 'Přihláška byla úspěšně odeslána!');
    }
}
