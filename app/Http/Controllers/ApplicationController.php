<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicantDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function create()
    {
        $draft = Application::where('user_id', Auth::id())
                    ->where('status', 'draft')
                    ->first();

        if (!$draft) {
            $draft = Application::create([
                'user_id' => Auth::id(),
                'status' => 'draft',
            ]);

            ApplicantDetail::create(['application_id' => $draft->id]);
        }

        return redirect()->route('application.step1', $draft->id);
    }

    public function step1($id)
    {
        $application = Application::with('details')->where('user_id', Auth::id())->findOrFail($id);

        return view('application.personal', compact('application'));
    }

    public function storeStep1(Request $request, $id)
    {
        $application = Application::where('user_id', Auth::id())->findOrFail($id);

        $data = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'street' => 'nullable|string',
            'city' => 'nullable|string',
            'zip' => 'nullable|string',
        ]);

        $application->details()->update($data);

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

        $data = $request->validate([
            'previous_school' => 'nullable|string|max:255',
            'previous_study_field' => 'nullable|string|max:255',
            'graduation_year' => 'nullable|numeric|digits:4',
            'grade_average' => 'nullable|numeric|between:1.00,5.00',
            'maturita_file' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
        ]);

        if ($request->hasFile('maturita_file')) {
            $path = $request->file('maturita_file')->store('applications/' . $application->id, 'public');
            $data['maturita_file_path'] = $path;
        }

        unset($data['maturita_file']);

        $application->details()->update($data);

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

        $data = $request->validate([
            'specific_needs' => 'nullable|string',
            'note' => 'nullable|string',
            'other_file' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
        ]);

        if ($request->hasFile('other_file')) {
            $path = $request->file('other_file')->store('applications/' . $application->id, 'public');
            $data['other_file_path'] = $path;
        }
        unset($data['other_file']);

        $application->details()->update($data);

        return redirect()->route('dashboard');
    }
}
