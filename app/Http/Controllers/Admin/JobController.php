<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        // $jobs = Job::latest()->get();
        $jobs = Job::orderBy('id', 'DESC')->paginate(5);
        return view('admin.jobs.index', compact('jobs'));
    }
    public function showjobs()
    {
    $jobs = Job::latest()->get();
    return view('all_jobs', compact('jobs'));
    }
    public function job_Id($id)
    {
    $job = Job::findOrFail($id);
    return view('view_job', compact('job'));
    }
    public function applyForm($id)
    {
    $job = Job::findOrFail($id);
    return view('apply_job', compact('job'));
    }

    public function create()
    {
        return view('admin.jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        Job::create($request->all());

        return redirect()->route('admin.jobs.index')->with('success', 'Job created!');
    }

    public function edit($id)
    {
        $job = Job::findOrFail($id);
        return view('admin.jobs.edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        $job->update($request->all());

        return redirect()->route('admin.jobs.index')->with('success', 'Job updated!');
    }

    public function destroy($id)
    {
        Job::findOrFail($id)->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Job deleted!');
    }
    public function destroy_application($id)
    {
        JobApplication::findOrFail($id)->delete();
       return redirect()->route('admin.job.job_applications')->with('success', 'Job Application deleted!');

    }

    public function applySubmit(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'resume' => 'required|mimes:pdf,doc,docx|max:2048',
        'message' => 'nullable'
    ]);

    $resumeName = time() . '-' . uniqid() . '.' . $request->resume->extension();
    $request->resume->move(public_path('resumes'), $resumeName);

    JobApplication::create([
        'job_id' => $id,
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'message' => $request->message,
        'resume' => $resumeName
    ]);

    // return redirect()->back()->with('success', 'Your application has been submitted!');
    return redirect()->route('all_jobs')->with('success', 'Your application has been submitted!');
}
public function all_application()
{
    $applications = JobApplication::with('job')->latest()->get();
    return view('admin.jobs.job_applications', compact('applications'));
}

}
