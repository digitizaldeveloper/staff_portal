<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\User;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    private function calcStatus($expiry)
    {
        if (!$expiry) return 'valid';

        if ($expiry < today()) return 'expired';

        if (today()->diffInDays($expiry) < 30) return 'expiring';

        return 'valid';
    }

    public function index()
    {
        // $certifications = Certification::with('staff')->latest()->get();
        $certifications = Certification::orderBy('id', 'DESC')->paginate(5);
        return view('admin.certifications.index', compact('certifications'));
    }

    public function create()
    {
        $staff = User::where('role', 'staff')->where('status', 'Active')->get();
        return view('admin.certifications.create', compact('staff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required',
            'name'     => 'required',
            'number'     => 'required',
            'issue_date'     => 'required',
            'expiry_date' => 'nullable|date',
        ]);

        Certification::create([
            'staff_id'   => $request->staff_id,
            'name'       => $request->name,
            'number'     => $request->number,
            'issue_date' => $request->issue_date,
            'expiry_date'=> $request->expiry_date,
        ]);

        return redirect()->route('admin.certifications.index')
                         ->with('success', 'Certification added successfully.');
    }

    public function edit($id)
    {
        $cert = Certification::findOrFail($id);
        $staff = User::where('role', 'staff')->get();

        return view('admin.certifications.edit', compact('cert', 'staff'));
    }

    public function update(Request $request, $id)
    {
        $cert = Certification::findOrFail($id);

        $cert->update([
            'staff_id'   => $request->staff_id,
            'name'       => $request->name,
            'number'     => $request->number,
            'issue_date' => $request->issue_date,
            'expiry_date'=> $request->expiry_date,
            'status'     => $this->calcStatus($request->expiry_date),
        ]);

        return redirect()->route('admin.certifications.index')
                         ->with('success', 'Certification updated successfully.');
    }

    public function destroy($id)
    {
        Certification::findOrFail($id)->delete();

        return back()->with('success', 'Certification deleted.');
    }
     public function staff_index()
    {
        $certs = Certification::where('staff_id', auth()->id())->get();
        return view('staff.certifications', compact('certs'));
    }
 public function upload(Request $request, $id)
{
    // 1. Validate the request, ensuring the file input is named 'document'
    $request->validate([
        'document' => 'required|mimes:pdf,jpg,jpeg,png',
    ]);

    // 2. Find the certification record
    $cert = Certification::findOrFail($id);
    
    // Get the uploaded file instance
    $file = $request->file('document');

    // 3. Generate a unique file name
    // Using time() and the original extension is safer than the full original name
    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

    // 4. Move the file to the public storage location
    // The file is now at public/pending_certificates/{$fileName}
    $file->move(public_path('pending_certificates'), $fileName);

    // 5. Store the accessible path/filename in the database
    $cert->pending_document = 'pending_certificates/' . $fileName;
    $cert->save();

    return back()->with('success', 'Certificate uploaded for review!');
}
     public function approve($id)
    {
        $cert = Certification::findOrFail($id);

        // move pending to final approved document
        $cert->document = $cert->pending_document;
        $cert->pending_document = null;
        $cert->status = 'valid';
        $cert->save();

        return back()->with('success', 'Certificate approved!');
    }

    public function reject($id)
    {
        $cert = Certification::findOrFail($id);

        // remove pending document only
        $cert->pending_document = null;
        $cert->status = 'rejected';
        $cert->save();

        return back()->with('error', 'Certificate rejected!');
    }
}
