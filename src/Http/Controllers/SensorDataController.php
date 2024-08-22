<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceApiData;

class SensorDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = DeviceApiData::query()->orderBy('created_at', 'desc');

        if ($request->has('start_date') && $request->start_date) {
            $startDate = $request->start_date . ' 00:00:00';
            $query->where('created_at', '>=', $startDate);
        }

        if ($request->has('end_date') && $request->end_date) {
            $endDate = $request->end_date . ' 23:59:59';
            $query->where('created_at', '<=', $endDate);
        }

        if ($request->has('device_id') && $request->device_id) {
            $query->where('device_id', $request->device_id);
        }

        $deviceData = $query->paginate(8);

        // Fetch distinct device IDs
        $deviceIds = DeviceApiData::select('device_id')->distinct()->get();

        if ($request->ajax()) {
            return view('sensor_data.table', compact('deviceData'))->render();
        }

        return view('sensor_data.index', compact('deviceData', 'deviceIds'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeviceApiData  $sensorData
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, string $id)
    {
        //return view('sensor_data.show', compact('sensorData'));
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeviceApiData  $sensorData
     * @return \Illuminate\Http\Response
     */
    public function edit(DeviceApiData $sensorData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeviceApiData  $sensorData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeviceApiData $DeviceApiData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeviceApiData  $sensorData
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeviceApiData $DeviceApiData)
    {
        //
    }
    public function count()
    {
        $reportCount = DeviceApiData::count();
        return view('sensor_data.count', compact('reportCount'));
    }
}
