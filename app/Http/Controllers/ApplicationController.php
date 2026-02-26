<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\StudyProgram;
use App\Models\ApplicationAttachment;
use App\Rules\BirthNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'user_id'          => Auth::id(),
            'study_program_id' => $program->id,
            'status'           => 'draft',
        ]);

        return redirect()->route('application.step1', $app->id);
    }

    public function step1($id)
    {
        $application = Application::where('user_id', Auth::id())->findOrFail($id);
        return view('application.personal', compact('application'));
    }

    public function storeStep1(Request $request, $id)
    {
        $application = Application::where('user_id', Auth::id())->findOrFail($id);

        $isExit      = $request->has('save_and_exit');
        $switchToUrl = $request->input('switch_to');

        $rules = [
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'gender'       => 'required|string|in:Muž,Žena',
            'birth_number' => ['required', 'string', new BirthNumber],
            'birth_date'   => 'required|date|before:-18 years',
            'birth_city'   => 'required|string|max:255',
            'citizenship'  => 'required|string|max:255',
            'email'        => 'required|email',
            'phone'        => ['required', 'regex:/^(\+420)?\s?[1-9][0-9]{2}\s?[0-9]{3}\s?[0-9]{3}$/'],
            'street'       => 'required|string|max:255',
            'city'         => 'required|string|max:255',
            'zip'          => ['required', 'regex:/^\d{3}\s?\d{2}$/'],
            'country'      => 'required|string|max:255',
        ];

        if ($isExit) {
            $rules = array_map(fn($rule) => is_string($rule) ? str_replace('required', 'nullable', $rule) : $rule, $rules);
            $rules['birth_number'] = ['nullable', 'string', new BirthNumber];
            $rules['phone']        = ['nullable', 'regex:/^(\+420)?\s?[1-9][0-9]{2}\s?[0-9]{3}\s?[0-9]{3}$/'];
            $rules['zip']          = ['nullable', 'regex:/^\d{3}\s?\d{2}$/'];
        }

        $data = $request->validate($rules, [
            'first_name.required'   => 'Křestní jméno je povinné.',
            'first_name.max'        => 'Křestní jméno může mít nejvýše 255 znaků.',
            'last_name.required'    => 'Příjmení je povinné.',
            'last_name.max'         => 'Příjmení může mít nejvýše 255 znaků.',
            'gender.required'       => 'Pohlaví je povinné.',
            'gender.in'             => 'Pohlaví musí být Muž nebo Žena.',
            'birth_number.required' => 'Rodné číslo je povinné.',
            'birth_date.required'   => 'Datum narození je povinné.',
            'birth_date.date'       => 'Datum narození není platné.',
            'birth_date.before'     => 'Uchazeč musí být starší 18 let.',
            'birth_city.required'   => 'Místo narození je povinné.',
            'citizenship.required'  => 'Státní občanství je povinné.',
            'email.required'        => 'E-mail je povinný.',
            'email.email'           => 'E-mail nemá správný formát.',
            'phone.required'        => 'Telefon je povinný.',
            'phone.regex'           => 'Telefonní číslo nemá správný formát.',
            'street.required'       => 'Ulice a číslo popisné jsou povinné.',
            'city.required'         => 'Město je povinné.',
            'zip.required'          => 'PSČ je povinné.',
            'zip.regex'             => 'PSČ nemá správný formát.',
            'country.required'      => 'Stát je povinný.',
        ]);

        $verifiedFields = $application->verified_fields ?? [];
        foreach ($verifiedFields as $field) {
            if (array_key_exists($field, $data)) {
                unset($data[$field]);
            }
        }

        $application->update($data);

        if ($switchToUrl) {
            if ($switchToUrl === 'dashboard') {
                return redirect()->route('dashboard')->with('success', 'Rozpracovaná přihláška byla uložena.');
            }
            return redirect($switchToUrl);
        }

        if ($isExit) {
            return redirect()->route('dashboard')->with('success', 'Rozpracovaná přihláška byla uložena.');
        }

        return redirect()->route('application.step2', $application->id);
    }

    public function step2($id)
    {
        $application = Application::where('user_id', Auth::id())->findOrFail($id);
        return view('application.education', compact('application'));
    }

    public function storeStep2(Request $request, $id)
    {
        $application = Application::where('user_id', Auth::id())->findOrFail($id);

        $isExit      = $request->has('save_and_exit');
        $switchToUrl = $request->input('switch_to');

        $fileInDb        = $application->attachments()->where('type', 'maturita')->exists();
        $gradYear        = $request->input('graduation_year');
        $gradeAvg        = $request->input('grade_average');
        $hasUpload       = $request->hasFile('maturita_file');
        $isFillingGraduation = !empty($gradYear) || !empty($gradeAvg) || $hasUpload || $fileInDb;

        $rules = [
            'previous_school'           => 'required|string|max:255',
            'izo'                        => 'required|string|max:50',
            'school_type'               => 'required|string|max:50',
            'previous_study_field'      => 'required|string|max:255',
            'previous_study_field_code' => 'required|string|max:50',
        ];

        if ($isFillingGraduation && !$isExit) {
            $rules['graduation_year'] = 'required|numeric|digits:4';
            $rules['grade_average']   = 'required|numeric|between:1.00,5.00';
            $rules['maturita_file']   = $fileInDb
                ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240'
                : 'required|file|mimes:pdf,jpg,jpeg,png|max:10240';
        } else {
            $rules['graduation_year'] = 'nullable';
            $rules['grade_average']   = 'nullable';
            $rules['maturita_file']   = 'nullable';
        }

        if ($isExit) {
            $rules = array_map(fn($r) => is_string($r) ? str_replace('required', 'nullable', $r) : $r, $rules);
        }

        $data = $request->validate($rules, [
            'previous_school.required'           => 'Název střední školy je povinný.',
            'previous_school.max'                => 'Název školy může mít nejvýše 255 znaků.',
            'izo.required'                        => 'IZO školy je povinné.',
            'school_type.required'               => 'Typ školy je povinný.',
            'previous_study_field.required'      => 'Obor studia je povinný.',
            'previous_study_field_code.required' => 'Kód oboru je povinný.',
            'graduation_year.required'           => 'Pokud vyplňujete průměr nebo nahráváte vysvědčení, musíte uvést rok maturity.',
            'graduation_year.numeric'            => 'Rok maturity musí být číslo.',
            'graduation_year.digits'             => 'Rok maturity musí mít 4 číslice.',
            'grade_average.required'             => 'Pokud nahráváte vysvědčení nebo vyplňujete rok, musíte zadat průměr známek.',
            'grade_average.numeric'              => 'Průměr známek musí být číslo.',
            'grade_average.between'              => 'Průměr známek musí být v rozmezí 1,00 až 5,00.',
            'maturita_file.required'             => 'Pokud vyplňujete rok maturity nebo průměr, je nutné nahrát kopii vysvědčení.',
            'maturita_file.mimes'                => 'Povolené formáty jsou PDF, JPG, JPEG a PNG.',
            'maturita_file.max'                  => 'Maximální velikost souboru je 10 MB.',
        ]);

        if ($request->hasFile('maturita_file')) {
            $old = $application->attachments()->where('type', 'maturita')->first();
            if ($old) {
                Storage::disk('public')->delete($old->disk_path);
                $old->delete();
            }

            $file = $request->file('maturita_file');
            $path = $file->store('applications/' . $application->id, 'public');

            $application->attachments()->create([
                'type'      => 'maturita',
                'filename'  => $file->getClientOriginalName(),
                'disk_path' => $path,
                'mime_type' => $file->getMimeType(),
                'size'      => $file->getSize(),
            ]);
        }
        unset($data['maturita_file']);

        $application->update($data);

        if ($switchToUrl) {
            if ($switchToUrl === 'dashboard') {
                return redirect()->route('dashboard')->with('success', 'Rozpracovaná přihláška byla uložena.');
            }
            return redirect($switchToUrl);
        }

        if ($isExit) {
            return redirect()->route('dashboard')->with('success', 'Rozpracovaná přihláška byla uložena.');
        }

        return redirect()->route('application.step3', $application->id);
    }

    public function step3($id)
    {
        $application = Application::where('user_id', Auth::id())->findOrFail($id);
        return view('application.additional', compact('application'));
    }

    public function storeStep3(Request $request, $id)
    {
        $application = Application::where('user_id', Auth::id())->findOrFail($id);

        $isExit      = $request->has('save_and_exit');
        $switchToUrl = $request->input('switch_to');

        $data = $request->validate([
            'specific_needs' => 'nullable|string',
            'note'           => 'nullable|string',
            'other_files.*'  => 'nullable|file|mimes:pdf,jpg,png|max:10240',
        ], [
            'other_files.*.mimes' => 'Povolené formáty jsou PDF, JPG a PNG.',
            'other_files.*.max'   => 'Maximální velikost souboru je 10 MB.',
        ]);

        if ($request->hasFile('other_files')) {
            foreach ($request->file('other_files') as $file) {
                $path = $file->store('applications/' . $application->id, 'public');
                $application->attachments()->create([
                    'type'      => 'other',
                    'filename'  => $file->getClientOriginalName(),
                    'disk_path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'size'      => $file->getSize(),
                ]);
            }
        }
        unset($data['other_files']);

        $application->update($data);

        if ($switchToUrl) {
            if ($switchToUrl === 'dashboard') {
                return redirect()->route('dashboard')->with('success', 'Rozpracovaná přihláška byla uložena.');
            }
            return redirect($switchToUrl);
        }

        if ($isExit) {
            return redirect()->route('dashboard')->with('success', 'Rozpracovaná přihláška byla uložena.');
        }

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
        $application = Application::where('user_id', Auth::id())->findOrFail($id);
        return view('application.summary', compact('application'));
    }

    public function submit(Request $request, $id)
    {
        $application = Application::where('user_id', Auth::id())->findOrFail($id);

        $isExit      = $request->has('save_and_exit');
        $switchToUrl = $request->input('switch_to');

        if ($isExit || $switchToUrl) {
            if ($isExit || $switchToUrl === 'dashboard') {
                return redirect()->route('dashboard');
            }
            return redirect($switchToUrl);
        }

        $request->validate([
            'consent' => 'accepted',
        ], [
            'consent.accepted' => 'Musíte potvrdit souhlas se zpracováním údajů.',
        ]);

        $appNumber = date('Y') . str_pad($application->id, 4, '0', STR_PAD_LEFT);

        $application->update([
            'status'             => 'submitted',
            'submitted_at'       => now(),
            'application_number' => $appNumber,
        ]);

        return redirect()->route('dashboard')->with('success', 'Přihláška byla úspěšně odeslána!');
    }
}
