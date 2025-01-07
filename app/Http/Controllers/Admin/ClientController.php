<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule as ValidationRule;

class ClientController extends Controller
{
    
    public function index()
    {
        $clients = Client::where('isdeleted', 0)->get();
        return view('admin.clients.index', compact('clients'));
    }


    public function create()
    {
        return view('admin.clients.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
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

  
    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('admin.clients.edit', compact('client'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
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
