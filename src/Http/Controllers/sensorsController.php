<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sensors;
use App\Models\Location;
use App\Models\Projects;
use App\Models\Maintenance;
use App\Models\ServiceTeams;
use Illuminate\Http\Request;
use App\Models\DeviceSettings;
use App\Models\MaintenanceSchedule;
use Illuminate\Support\Facades\Log;
use App\Models\Calibration_intervals;
use Illuminate\Validation\ValidationException;

class SensorsController extends Controller
{
    public function index()
    {
        $sensors = Sensors::with(['project', 'location', 'maintainors', 'calibrationInterval'])->paginate(8);
        return view('sensors.index', compact('sensors'));
    }

    public function show($sensor_id)
    {
        $sensor = Sensors::with(['project', 'location'])->findOrFail($sensor_id);
        return view('sensors.show', compact('sensor'));
    }

    public function create()
    {
        $data = [
            'maintainers' => ServiceTeams::all(),
            'intervals' => Calibration_intervals::all(),
            'projects' => Projects::all()
        ];
        return view('sensors.create', $data);
    }

    public function store(Request $request)
    {
        $validated = $this->validateSensor($request, 'store');

        $sensor = Sensors::create($validated);
        $this->storeDeviceSettings($validated, $sensor->sensor_id);

        $this->storeMaintenanceSchedule($validated['calibration_frequency'], $validated['installation_date'], $sensor->sensor_id);

        return response()->json([
            'success' => true,
            'message' => 'New device added successfully.',
            'redirect' => route('sensors.index'),
        ]);
    }

    public function edit($sensor_id)
    {
        $data = [
            'sensor' => Sensors::findOrFail($sensor_id),
            'maintainers' => ServiceTeams::all(),
            'intervals' => Calibration_intervals::all(),
            'projects' => Projects::all()
        ];
        return view('sensors.edit', $data);
    }

    public function update(Request $request, $sensor_id)
    {
        $validated = $this->validateSensor($request, 'update');

        $sensor = Sensors::findOrFail($sensor_id);
        $sensor->update($validated);

        return response()->json([
            'success' => true,
            'message' => $validated['sensor_type'] . ' updated successfully.',
            'redirect' => route('sensors.index'),
        ]);
    }

    public function getCalibrationDates($sensor)
    {
        $calibrationData = MaintenanceSchedule::where('device_id', $sensor)->whereNull('deleted_at')->get();
        return view('sensors.maintenancelist', compact('calibrationData'));
    }

    public function destroy($sensor_id)
    {
        Sensors::findOrFail($sensor_id)->delete();
        return redirect()->route('sensors.index')->with('success', 'Sensor deleted successfully.');
    }

    public function count()
    {
        $sensorCount = Sensors::count();
        return view('sensors.count', compact('sensorCount'));
    }

    public function showCalibrationDate($id)
    {
        $calibrationDate = MaintenanceSchedule::findOrFail($id);
        return response()->json($calibrationDate);
    }

    public function updateCalibrationDate(Request $request, $id)
    {
        $request->validate(['date' => 'required|date']);

        $calibrationDate = MaintenanceSchedule::findOrFail($id);
        $calibrationDate->update(['maintenance_date' => $request->date]);

        return response()->json([
            'success' => true,
            'message' => 'Calibration date updated successfully.',
            'redirect' => route('sensors.index'),
        ]);
    }

    public function deleteCalibrationDate($id)
    {
        MaintenanceSchedule::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Calibration date deleted successfully.',
            'redirect' => route('sensors.index'),
        ]);
    }

    private function validateSensor(Request $request, $action)
    {
        $rules = [
            'project_id' => 'required|exists:projects,project_id',
            'sensor_type' => 'required|string|max:255',
            'installation_date' => 'required|date',
            'status' => 'required|in:Active,Inactive',
            'warranty_date' => 'nullable|date',
            'maintainor' => 'nullable|integer',
            'calibration_frequency' => 'nullable|integer',
            'location_name' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];

        if ($action === 'store') {
            $rules = array_merge($rules, [
                'key' => 'required|string|max:255',
                'updation_rate' => 'required|integer',
                'mode' => 'required|in:A,M',
                'device_status' => 'required|in:ON,OFF',
                'setpoint' => 'required|integer|min:0|max:1400',
                'calibration_frequency' => 'required|integer',
            ]);
        }

        try {
            return $request->validate($rules);
        } catch (ValidationException $e) {
            Log::error('Validation error: ' . $e->getMessage(), ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());
            abort(500, 'An error occurred while processing your request. Please try again later.');
        }
    }

    private function storeDeviceSettings(array $validated, $deviceId)
    {
        DeviceSettings::create([
            'device_id' => $deviceId,
            'key' => $validated['key'],
            'updation_rate' => $validated['updation_rate'],
            'mode' => $validated['mode'],
            'device_status' => $validated['device_status'],
            'setpoint' => $validated['setpoint'],
        ]);
    }

    private function storeMaintenanceSchedule($calibrationFrequency, $installationDate, $deviceId)
    {
        $interval = Calibration_intervals::findOrFail($calibrationFrequency);
        $nextMaintenanceDates = $this->calculateNextMaintenanceDates($interval->name, $installationDate);

        foreach ($nextMaintenanceDates as $date) {
            MaintenanceSchedule::create([
                'device_id' => $deviceId,
                'calibration_id' => $calibrationFrequency,
                'maintenance_date' => $date,
            ]);
        }
    }

    private function calculateNextMaintenanceDates($interval, $installation_date)
    {
        $dates = [];
        $currentDate = Carbon::parse($installation_date);
        $endDate = $currentDate->copy()->addYears(3);

        while ($currentDate->lte($endDate)) {
            switch ($interval) {
                case 'Once a week':
                    $currentDate->addWeek();
                    break;
                case 'Twice a month':
                    $currentDate->addDays(15);
                    break;
                case 'Once a month':
                    $currentDate->addMonth();
                    break;
                case 'Once every 3 months':
                    $currentDate->addMonths(3);
                    break;
                case 'Once every 6 months':
                    $currentDate->addMonths(6);
                    break;
                case 'Once a year':
                    $currentDate->addYear();
                    break;
                default:
                    throw new \Exception('Invalid interval');
            }
            $dates[] = $currentDate->toDateString();
        }

        return $dates;
    }
}
