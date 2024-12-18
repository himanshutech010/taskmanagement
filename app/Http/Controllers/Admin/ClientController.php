<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule as ValidationRule;

class ClientController extends Controller
{
    /**
     * Display a listing of the clients.
     */
    public function index()
    {
        $clients = Client::where('isdeleted', 0)->get();
        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new client.
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            // 'client_name' => 'required|string|max:255',
            'mobile' => 'nullable|numeric|digits_between:6,15',
            'email' => ['required', 'email:rfc,dns', 'max:255', 'unique:clients,email'],
            'linkedin' => 'nullable|url|max:255',
            'skype' => 'nullable|string|max:255',
            'other' => 'nullable|string|max:255',
            'location' => 'nullable|string',

        ]);

        Client::create($validated);

        return redirect()->route('admin.clients.index')->with('success', 'Client created successfully.');
    }

  

    /**
     * Show the form for editing the specified client.
     */

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // 'client_name' => 'required|string|max:255',
            'client_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => ['required',  'email:rfc,dns', 'max:255', ValidationRule::unique('clients')->ignore($id)],
            'mobile' => 'nullable|numeric|digits_between:6,15',
            'linkedin' => 'nullable|url',
            'skype' => 'nullable|string|max:255',
            'other' => 'nullable|string|max:255',
            'location' => 'nullable|string',

        ]);

        $client = Client::findOrFail($id);
        $client->update($request->all());

        return redirect()->route('admin.clients.index')->with('success', 'Client updated successfully.');
    }


    /**
     * Remove the specified client from storage.
     */
    public function destroy($id)
    {
        $client = Client::findOrfail($id);
        $client->isdeleted = 1;
        $client->save();

        return redirect()->route('admin.clients.index')->with('success', 'Client deleted successfully.');
    }

    public function show($id)
    {
        $client = Client::with('projects')->findOrFail($id);
        return view('admin.clients.details', compact('client'));
    }
}
