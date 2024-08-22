<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Projects;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class projectController extends Controller
{
    public function projects()
    {
        $projects = Projects::paginate(8); // Fetch all projects from the database

        return view('projects.index', compact('projects')); // Ensure 'projects' matches the filename in resources/views
    }

    public function index()
    {
        $projects = Projects::with('customer')->paginate(8);

        // $projectCount = projects::count();
        // Debugging output
        // dd($projectCount);

        return view('projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'customer_id' => 'required|exists:customers,customer_id',
                'name' => 'required',
                'description' => 'nullable',
                'start_date' => 'required|date',
                'project_location_details' => 'required',
            ]);

            $project = Projects::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'New Project created successfully.',
                'redirect' => route('projects.index'),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log the validation error
            Log::error('Validation Error: ', $e->errors());

            return response()->json([
                'success' => false,
                'message' => 'Validation error occurred.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            // Log any other errors
            Log::error('Error: ', ['exception' => $e]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the project.',
            ], 500);
        }
    }


    public function create()
    {
        $customers = Customers::all(); // Assuming you have a Customer model
        return view('projects.create', compact('customers'));
    }

    public function edit($project_id)
    {
        $project = Projects::findOrFail($project_id);
        $customers = Customers::all();
        return view('projects.edit', compact('project', 'customers'));
    }

    public function update(Request $request, $project_id)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'name' => 'required',
            'description' => 'nullable',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ]);

        $project = Projects::findOrFail($project_id);
        $project->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => $validatedData['name'] . ' Project updated successfully.',
            'redirect' => route('projects.index'),
        ]);
    }
    public function show(projects $project)
    {
    }

    public function destroy($project_id)
    {
        $project = Projects::findOrFail($project_id);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully!');
    }

    public function count()
    {
        $projectCount = Projects::count();
        return view('projects.count', compact('projectCount'));
    }
}
