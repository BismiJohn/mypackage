<?php

namespace App\Http\Controllers;

use App\Models\Sensors;
use App\Models\Maintenance;
use App\Models\ServiceTeams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Maintenance::query();

        if ($request->filled('team_name')) {
            $query->whereHas('serviceTeam', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->team_name . '%');
            });
        }

        if ($request->filled('location_name')) {
            $query->whereHas('sensor.location', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->location_name . '%');
            });
        }

        if ($request->filled('maintenance_date')) {
            $query->whereDate('maintenance_date', $request->maintenance_date);
        }

        if ($request->filled('sensor_type')) {
            $query->whereHas('sensor', function ($q) use ($request) {
                $q->where('sensor_type', 'like', '%' . $request->sensor_type . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $maintenances = $query->with(['sensor.location', 'serviceTeam'])->paginate(8);

        return view('maintenances.index', compact('maintenances'));
    }

    public function create()
    {
        $sensors = Sensors::all();
        $serviceTeams = ServiceTeams::all();
        return view('maintenances.create', compact('sensors', 'serviceTeams'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'sensor_id' => 'required|exists:sensors,sensor_id',
                'team_id' => 'required|exists:service_teams,team_id',
                'description' => 'required',
                'maintenance_date' => 'required|date',
                'status' => 'required|in:Completed,Pending',
            ]);

            Maintenance::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Maintenance record created successfully.',
                'redirect' => route('maintenances.index'),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error: ', $e->errors());

            return response()->json([
                'success' => false,
                'message' => 'Validation error occurred.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error: ', ['exception' => $e]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the maintenance record.',
            ], 500);
        }
    }

    public function show(Maintenance $maintenance)
    {
        return view('maintenances.show', compact('maintenance'));
    }

    public function edit(Maintenance $maintenance)
    {
        $sensors = Sensors::all();
        $serviceTeams = ServiceTeams::all();
        return view('maintenances.edit', compact('maintenance', 'sensors', 'serviceTeams'));
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $validatedData = $request->validate([
            'sensor_id' => 'required|exists:sensors,sensor_id',
            'team_id' => 'required|exists:service_teams,team_id',
            'description' => 'required',
            'maintenance_date' => 'required|date',
            'status' => 'required|in:Completed,Pending',
        ]);

        try {
            $maintenance->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Maintenance record updated successfully.',
                'redirect' => route('maintenances.index'),
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating maintenance record: ', ['exception' => $e]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the maintenance record.',
            ], 500);
        }
    }
    public function destroy(Maintenance $maintenance)
    {
        try {
            $maintenance->delete();

            return redirect()->route('maintenances.index')->with('success', 'Maintenance record deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error: ', ['exception' => $e]);

            return redirect()->route('maintenances.index')->with('error', 'An error occurred while deleting the maintenance record.');
        }
    }
}
