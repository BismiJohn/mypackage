<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceApiData;
use App\Models\DeviceSettings;
use App\Helpers\DateTimeHelper;
use App\Services\DeviceService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DeviceDataController extends Controller
{

    protected $deviceService;

    public function __construct(DeviceService $deviceService)
    {
        $this->deviceService = $deviceService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        return $this->deviceService->storeDeviceData($request);
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
    public function update(Request $request, $id)
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

    public function getDeviceSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Device_ID' => 'required|string|exists:device_settings,device_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid Device_ID'], 400);
        }
        $deviceId = $request->Device_ID;

        $deviceSettingsData = DeviceSettings::where('device_id', $deviceId)->orderBy('created_at', 'desc')->first();

        if (!$deviceSettingsData) {
            return response()->json(['error' => 'No settings found for the given device'], 404);
        }

        $formattedDateTime = DateTimeHelper::getFormattedDateTime();

        $responseString = "#{$deviceId},P1:{$deviceSettingsData->key},P2:{$deviceSettingsData->updation_rate},P3:0,P4:0,P5:0,P6:0,P7:{$formattedDateTime}%";

        return response($responseString);
    }
}
