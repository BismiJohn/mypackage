<?php

namespace App\Http\Controllers;

use App\Models\ServiceTeams;
use Illuminate\Http\Request;

class ServiceTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = ServiceTeams::all();
        return view('serviceteams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('serviceteams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'team_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:20',
        ]);


        $team = ServiceTeams::create([
            'name' => $validatedData['team_name'],
            'contact_email' => $validatedData['contact_email'],
            'contact_phone' => $validatedData['contact_number'],
        ]);

        return redirect()->route('serviceteams.index')->with('success', 'Service team created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $team = ServiceTeams::findOrFail($id);
        return view('serviceteams.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)

    {
        $validatedData = $request->validate([
            'team_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:20',
        ]);

        $team = ServiceTeams::findOrFail($id);
        $team->update([
            'name' => $validatedData['team_name'],
            'contact_email' => $validatedData['contact_email'],
            'contact_phone' => $validatedData['contact_number'],
        ]);

        return redirect()->route('serviceteams.index')->with('success', 'Service team updated successfully!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function storeAjax(Request $request)
{
    $validatedData = $request->validate([
        'team_name' => 'required|string|max:255',
        'contact_email' => 'required|email|max:255',
        'contact_number' => 'required|string|max:20',
    ]);

    $team = ServiceTeams::create([
        'name' => $validatedData['team_name'],
        'contact_email' => $validatedData['contact_email'],
        'contact_phone' => $validatedData['contact_number'],
    ]);

    return response()->json([
        'success' => true,
        'team' => $team,
    ]);
}

}
