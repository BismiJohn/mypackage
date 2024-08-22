<?php

namespace App\Http\Controllers;

use App\Models\Alerts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alerts = Alerts::with(['sensors'])->paginate(8);
        return view('alerts.index', compact('alerts'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Retrieve alert types from the config file
        $alertTypes = array_keys(config('alerts.alert_types'));

        // Log the alert types for debugging
        Log::info('Alert types:', $alertTypes);

        // Validate request data
        $validatedData = $request->validate([
            'sensor_id' => 'required|integer',
            'alert_type' => ['required', 'string', 'in:' . implode(',', $alertTypes)],
            'alert_message' => 'required|string',
            'status' => 'required|string',
        ]);

        // Create new alert
        $alert = Alerts::create($validatedData);

        // Return response
        return response()->json($alert, 201);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function count()
    {
        $totalAlertsCount = Alerts::count();
        $activeAlertsCount = Alerts::where('status', 'Active')->count();
        $inactiveAlertsCount = Alerts::where('status', 'Resolved')->count();

        return view('alerts.count', compact('totalAlertsCount', 'activeAlertsCount', 'inactiveAlertsCount'));
    }

    public function filterByType(Request $request)
    {
        // Retrieve the alert types
        $alertTypes = array_keys(config('constant.alert_types'));

        $validatedData = $request->validate([
            'alert_type' => ['required', 'string', 'in:' . implode(',', $alertTypes)],
        ]);

        $alertType = $validatedData['alert_type'];

        $alerts = Alerts::where('alert_type', $alertType)
            ->select('alert_type', 'alert_message', 'created_at')
            ->get();

        return response()->json($alerts);
    }
}
