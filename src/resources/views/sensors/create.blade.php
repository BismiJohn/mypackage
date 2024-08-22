@extends('layouts.app')

@section('title', 'Add New Device')

@section('content')
    <div class="container">
        <h1 class="mb-4">Add New Device</h1>
        <form action="{{ route('sensors.store') }}" method="POST" id="createDeviceForm">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="project_id">Project</label>
                    <select name="project_id" id="project_id" class="form-control" required>
                        <option value="" disabled selected>Select a Project</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->project_id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="sensor_type">Device Name</label>
                    <input type="text" name="sensor_type" id="sensor_type" class="form-control" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="installation_date">Installation Date</label>
                    <input type="date" name="installation_date" id="installation_date" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="calibration_frequency">Calibration Frequency</label>
                    <select name="calibration_frequency" id="calibration_frequency" class="form-control" required>
                        <option value="" disabled selected>Select an interval</option>
                        @foreach ($intervals as $interval)
                            <option value="{{ $interval->id }}">{{ $interval->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="warranty_date">Warranty Date</label>
                    <input type="date" name="warranty_date" id="warranty_date" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="maintainor">Maintainer</label>
                    <select name="maintainor" id="maintainor" class="form-control" required>
                        <option value="" disabled selected>Select a maintainer</option>
                        @foreach ($maintainers as $maintainor)
                            <option value="{{ $maintainor->team_id }}">{{ $maintainor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="location_name">Location</label>
                    <input type="text" name="location_name" id="location_name" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="latitude">Latitude</label>
                    <input type="number" name="latitude" id="latitude" class="form-control" step="0.000001" min="-90" max="90" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="longitude">Longitude</label>
                    <input type="number" name="longitude" id="longitude" class="form-control" step="0.000001" min="-180" max="180" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="key">Key</label>
                    <input type="text" name="key" id="key" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="updation_rate">Updation Rate</label>
                    <input type="number" name="updation_rate" id="updation_rate" class="form-control" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="mode">Mode</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="mode" id="modeAuto" value="A" required>
                        <label class="form-check-label" for="modeAuto">Auto</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="mode" id="modeManual" value="M" required>
                        <label class="form-check-label" for="modeManual">Manual</label>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="device_status">Device Status</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="device_status" id="deviceStatusOn" value="ON" required>
                        <label class="form-check-label" for="deviceStatusOn">ON</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="device_status" id="deviceStatusOff" value="OFF" required>
                        <label class="form-check-label" for="deviceStatusOff">OFF</label>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="setpoint">Setpoint</label>
                    <input type="number" name="setpoint" id="setpoint" class="form-control" min="0" max="1400" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Save</button>
        </form>
    </div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        // Handle form submission for creating project
        $('#createDeviceForm').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('sensors.store') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function(data) {
                    if (data.success) {
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message,
                            timer: 3000,
                            showConfirmButton: false
                        });

                        // Redirect after message fades
                        setTimeout(function() {
                            window.location.href = data.redirect;
                        }, 3500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops',
                            text: 'There is some error when adding a new device',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        });
    });
</script>
