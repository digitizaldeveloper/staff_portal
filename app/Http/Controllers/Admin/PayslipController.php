<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payslip;
use App\Models\User;
class PayslipController extends Controller
{
    //  public function index()
    // {
    //     return view('admin.payslips.index', [
    //         'payslips' => Payslip::with('staff')->orderBy('id', 'DESC')->get(),
    //     ]);
    // }
    public function index()
{
    return view('admin.payslips.index', [
        'payslips' => Payslip::with('staff')
            ->orderBy('id', 'DESC')
            ->paginate(5), // ← pagination added
    ]);
}


    public function create()
    {
        return view('admin.payslips.create', [
            'staff' => User::where('role', 'staff')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required',
            'pay_period' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        // upload
        $fileName = time() . '_' . $request->file->getClientOriginalName();
        $request->file->move(public_path('payslips'), $fileName);

        Payslip::create([
            'staff_id' => $request->staff_id,
            'pay_period' => $request->pay_period,
            'file_path' => $fileName,
        ]);

        return redirect()->route('admin.payslips.index')
                         ->with('success', 'Payslip uploaded successfully!');
    }

    public function edit($id)
    {
        return view('admin.payslips.edit', [
            'payslip' => Payslip::findOrFail($id),
            'staff' => User::where('role', 'staff')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $payslip = Payslip::findOrFail($id);

        $request->validate([
            'staff_id' => 'required',
            'pay_period' => 'required',
            'file' => 'nullable|mimes:pdf|max:2048',
        ]);

        // update file if uploaded
        if ($request->hasFile('file')) {
            // delete old
            if (file_exists(public_path('payslips/' . $payslip->file_path))) {
                unlink(public_path('payslips/' . $payslip->file_path));
            }

            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $request->file->move(public_path('payslips'), $fileName);
            $payslip->file_path = $fileName;
        }

        $payslip->staff_id = $request->staff_id;
        $payslip->pay_period = $request->pay_period;
        $payslip->save();

        return redirect()->route('admin.payslips.index')
                         ->with('success', 'Payslip updated successfully!');
    }

    public function destroy($id)
    {
        $payslip = Payslip::findOrFail($id);

        // delete file
        if (file_exists(public_path('payslips/' . $payslip->file_path))) {
            unlink(public_path('payslips/' . $payslip->file_path));
        }

        $payslip->delete();

        return back()->with('success', 'Payslip deleted successful!');
    }
    public function Show_payslip()
{
    $payslips = Payslip::where('staff_id', auth()->id())->latest()->get();

    return view('staff.payslips-personal', compact('payslips'));
}

}
