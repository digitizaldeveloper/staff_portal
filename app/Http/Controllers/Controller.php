<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
class Controller extends BaseController
{

    public function store_contact(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'email'   => 'required|email',
            'phone'   => 'nullable',
            'message' => 'required|min:10',
        ]);

        Contact::create($request->all());

        return back()->with('success', 'Your message has been sent successfully!');
    }
    public function all_contact()
    {
    // $contacts = Contact::latest()->get();
    $contacts = Contact::orderBy('id', 'DESC')->paginate(5);
    return view('admin.contact_enquiries', compact('contacts'));
    }
    public function destroy_contact($id)
{
    Contact::findOrFail($id)->delete();

    return redirect()->route('admin.contact_enquiries')
        ->with('success', 'Contact enquiry deleted successfully!');
}
}
