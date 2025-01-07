<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dsr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DsrController extends Controller
{

    public function index()
    {
        $dsrs = Dsr::with('createdBy')->orderBy('created_at', 'desc')->get();
        return view('admin.dsrs.index', compact('dsrs'));
    }


    public function create()
    {
        $users = User::where('isdeleted', 0)->get();
        return view('admin.dsrs.create', compact('users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'today_work' => 'required|string|max:255',
            'comment' => 'nullable|string',
            'status' => 'required|in:in progress,completed,not started',
            'time_taken' => 'required|numeric|min:0',
        ]);

        Dsr::create([
            'today_work' => $request->today_work,
            'comment' => $request->comment,
            'status' => $request->status,
            'time_taken' => $request->time_taken,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.dsr.index')->with('success', 'DSR created successfully.');
    }


    public function show($id)
    {
        $dsr = Dsr::with('createdBy')->findOrFail($id);
        return view('admin.dsr.show', compact('dsr'));
    }

    // Show the form for editing the specified DSR
    public function edit($id)
    {
        $dsr = Dsr::findOrFail($id);
        return view('admin.dsrs.edit', compact('dsr'));
    }

    // Update the specified DSR in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'today_work' => 'required|string|max:255',
            'comment' => 'nullable|string',
            'status' => 'required|in:in progress,completed,not started',
            'time_taken' => 'required|numeric|min:0',
        ]);

        $dsr = Dsr::findOrFail($id);
        $dsr->update([
            'today_work' => $request->today_work,
            'comment' => $request->comment,
            'status' => $request->status,
            'time_taken' => $request->time_taken,
        ]);

        return redirect()->route('admin.dsr.index')->with('success', 'DSR updated successfully.');
    }

    // Remove the specified DSR from storage
    public function destroy($id)
    {
        $dsr = Dsr::findOrFail($id);
        $dsr->delete();

        return redirect()->route('admin.dsr.index')->with('success', 'DSR deleted successfully.');
    }
}
