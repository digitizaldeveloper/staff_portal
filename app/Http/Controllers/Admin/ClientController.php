<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        // $clients = Client::latest()->get();
        $clients = Client::orderBy('id', 'DESC')->paginate(5);
        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'email'  => 'required|email|unique:clients',
            'phone'  => 'nullable',
            'company' => 'nullable',
            'address' => 'nullable',
        ]);

        Client::create($request->all());

        return redirect()->route('admin.clients.index')
                         ->with('success', 'Client created successfully!');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $request->validate([
            'name'   => 'required',
            'email'  => 'required|email|unique:clients,email,' . $client->id,
        ]);

        $client->update($request->all());

        return redirect()->route('admin.clients.index')
                         ->with('success', 'Client updated successfully!');
    }

    public function destroy($id)
    {
        Client::findOrFail($id)->delete();

        return redirect()->route('admin.clients.index')
                         ->with('success', 'Client deleted successfully!');
    }
}
