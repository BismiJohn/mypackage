@extends('layouts.app')

@section('title', 'Edit Device Details')

@section('content')
    <div class="card">
        <div class="card-header">
            Edit Device
        </div>
        <div class="card-body">
            <form action="{{ route('sensors.update', $sensor->sensor_id) }}" method="POST" id="updateSensorForm">
                @csrf
                @method('PUT')
                <!-- Form fields here -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="project_id">Project</label>
                            <select name="project_id" id="project_id" class="form-control" required>
                                <option value="" disabled>Select a Project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->project_id }}"
                                        {{ $sensor->project_id == $project->project_id ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sensor_type">Device Name</label>
                            <input type="text" name="sensor_type" id="sensor_type" class="form-control"
                                value="{{ $sensor->sensor_type }}" required>
                        </div>
                        <div class="form-group">
                            <label for="installation_date">Installation Date</label>
                            <input type="date" name="installation_date" id="installation_date" class="form-control"
                                value="{{ $sensor->installation_date }}" required>
                        </div>
                        <div class="form-group">
                            <label for="calibration_frequency">Calibration Frequency</label>
                            <select name="calibration_frequency" id="calibration_frequency" class="form-control" required>
                                <option value="" disabled>Select an interval</option>
                                @foreach ($intervals as $interval)
                                    <option value="{{ $interval->id }}"
                                        {{ $sensor->calibration_frequency == $interval->id ? 'selected' : '' }}>
                                        {{ $interval->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="Active" {{ $sensor->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $sensor->status == 'Inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="warranty_date">Warranty Date</label>
                            <input type="date" name="warranty_date" id="warranty_date" class="form-control"
                                value="{{ $sensor->warranty_date }}">
                        </div>
                        <div class="form-group">
                            <label for="maintainor">Maintainer</label>
                            <select name="maintainor" id="maintainor" class="form-control" required>
                                <option value="" disabled>Select a maintainer</option>
                                @foreach ($maintainers as $maintainer)
                                    <option value="{{ $maintainer->team_id }}"
                                        {{ $sensor->maintainor == $maintainer->team_id ? 'selected' : '' }}>
                                        {{ $maintainer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="location_name">Location</label>
                            <input type="text" name="location_name" id="location_name" class="form-control"
                                value="{{ $sensor->location_name }}">
                        </div>
                        <div class="form-group">
                            <label for="latitude">Latitude</label>
                            <input type="number" name="latitude" id="latitude" class="form-control" step="0.000001"
                                min="-90" max="90" value="{{ $sensor->latitude }}" required>
                        </div>
                        <div class="form-group">
                            <label for="longitude">Longitude</label>
                            <input type="number" name="longitude" id="longitude" class="form-control" step="0.000001"
                                min="-180" max="180" value="{{ $sensor->longitude }}" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary custom-btn-bg">Update</button>
            </form>
            <div id="successMessage" style="display:none;" class="alert alert-success mt-3"></div>
        </div>
    </div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        $('#updateSensorForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('sensors.update', ['sensor' => $sensor->sensor_id]) }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData + '&_method=PUT',
                success: function(data) {
                    if (data.success) {
                        $('#successMessage').text(data.message).fadeIn();

                        setTimeout(function() {
                            $('#successMessage').fadeOut(function() {
                                window.location.href = data.redirect;
                            });
                        }, 3000);
                    } else {
                        alert('There was an error updating the sensor.');
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        });
    });
</script>
