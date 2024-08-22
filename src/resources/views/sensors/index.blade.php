@extends('layouts.app')

@section('title', 'Devices')

@section('content')
    <div class="container">
        <h3 class="table-heading">Devices</h3>

        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Sl No.</th>
                    <th>Project</th>
                    <th>Device</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Warranty Date</th>
                    <th>Maintainer</th>
                    <th>Calibration Frequency</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $id = 1;
                ?>
                @foreach ($sensors as $sensor)
                    <tr>
                        <td>{{ $id++ }}</td>
                        <td>{{ $sensor->project->name ?? 'N/A' }}</td>
                        <td>{{ $sensor->sensor_type }}</td>
                        <td>{{ $sensor->location_name ?? 'N/A' }}</td>
                        <td>{{ $sensor->status }}</td>
                        <td>{{ $sensor->warranty_date }}</td>
                        <td>{{ $sensor->maintainors->name ?? 'N/A' }}</td>
                        <td>{{ $sensor->calibrationInterval->name ?? 'N/A' }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('sensors.edit', $sensor->sensor_id) }}" class="btn custom-btn-bg mr-2">
                                    <i class="fas fa-edit custom-icon-color"></i> <!-- Edit Icon -->
                                </a>
                                <a href="{{ route('sensors.calibration_dates', $sensor->sensor_id) }}" class="btn custom-btn-bg mr-2" title="Maintenance Details">
                                    <i class="fas fa-tools custom-icon-color"></i> <!-- Maintenance Icon -->
                                </a>
                                <form action="{{ route('sensors.destroy', $sensor->sensor_id) }}" method="POST" class="mr-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn custom-btn-bg"
                                        onclick="return confirm('Are you sure you want to delete this sensor?')">
                                        <i class="fas fa-trash-alt custom-icon-color"></i> <!-- Delete Icon -->
                                    </button>
                                </form>

                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('sensors.create') }}" class="btn btn-primary custom-btn-bg mb-3">Add New Device</a>
        {{ $sensors->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection
