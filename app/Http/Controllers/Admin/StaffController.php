<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    // Staff List
    public function index()
    {
        // $staff = User::where('role', 'staff')->get();
        $staff = User::orderBy('id', 'DESC')->paginate(5);
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
    return view('admin.staff.form', ['member' => null]);
    }
    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'nullable|confirmed|min:6',
    ]);
     $password = $request->password
        ? Hash::make($request->password)
        : Hash::make('12345678'); // default password

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => 'staff',
        'status' => $request->status,
        'password' => $password,
    ]);

     return redirect()->route('admin.staff.index')
                     ->with('success', 'Staff created successfully!');
}
    public function edit($id)
    {
    $member = User::findOrFail($id);
    return view('admin.staff.form', compact('member'));
    }
    public function update(Request $request, $id)
{
    $member = User::findOrFail($id);

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
    ]);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'status' => $request->status,
    ];

    // If password is entered
    if ($request->password) {
        $request->validate(['password' => 'min:6|confirmed']);
        $data['password'] = Hash::make($request->password);
    }

    $member->update($data);

    return redirect()->route('admin.staff.index')->with('success', 'Staff updated');
}
public function destroy($id)
{
    $member = User::findOrFail($id);

    // prevent deleting super admin if needed
    // if ($member->role == 'admin') { return back()->with('error', 'Cannot delete admin'); }

    $member->delete();

    return redirect()->route('admin.staff.index')
        ->with('success', 'Staff member deleted successfully!');
}

}
