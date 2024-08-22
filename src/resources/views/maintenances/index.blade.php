@extends('layouts.app')

@section('title', 'Maintenance Records')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="table-heading">Maintenance Records</h3>
        <div class="d-flex">
            <button id="toggleFilter" class="btn btn-secondary mr-2">
                <i class="fas fa-filter"></i>
            </button>
            <button type="button" id="resetFilters" class="btn btn-light">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>

    <form id="filterForm" action="{{ route('maintenances.index') }}" method="GET" class="mb-4" style="display: none;">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="team_name">Team Name:</label>
                    <input type="text" id="team_name" name="team_name" class="form-control"
                        value="{{ request('team_name') }}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="location_name">Location:</label>
                    <input type="text" id="location_name" name="location_name" class="form-control"
                        value="{{ request('location_name') }}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="maintenance_date">Maintenance Date:</label>
                    <input type="date" id="maintenance_date" name="maintenance_date" class="form-control"
                        value="{{ request('maintenance_date') }}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="sensor_type">Sensor Type:</label>
                    <input type="text" id="sensor_type" name="sensor_type" class="form-control"
                        value="{{ request('sensor_type') }}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status" class="form-control">
                        <option value="">Select Status</option>
                        <option value="Completed" {{ request('status') === 'Completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary btn-block custom-btn-bg">Apply</button>
                </div>
            </div>
        </div>
    </form>

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Sensor</th>
                <th>Team</th>
                <th>Description</th>
                <th>Maintenance Date</th>
                <th>Location</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($maintenances as $maintenance)
                <tr>
                    <td>{{ $maintenance->sensor->sensor_type }}</td>
                    <td>{{ $maintenance->serviceTeam->name }}</td>
                    <td>{{ $maintenance->description }}</td>
                    <td>{{ $maintenance->maintenance_date }}</td>
                    <td>{{ $maintenance->sensor->location_name }}</td>
                    <td>{{ $maintenance->status }}</td>
                    <td>
                        <a href="{{ route('maintenances.edit', $maintenance->maintenance_id) }}"
                            class="btn custom-btn-bg btn-sm">
                            <i class="fas fa-edit custom-icon-color"></i></a>
                        <form action="{{ route('maintenances.destroy', $maintenance->maintenance_id) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn custom-btn-bg btn-sm"><i
                                    class="fas fa-trash-alt custom-icon-color"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $maintenances->links('vendor.pagination.bootstrap-4') }}
    <p>
        <a href="{{ route('maintenances.create') }}" class="btn btn-primary custom-btn-bg">Add New Maintenance Record</a>
    </p>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleFilter = document.getElementById('toggleFilter');
            const filterForm = document.getElementById('filterForm');
            const resetFilters = document.getElementById('resetFilters');

            // Display filter form if any filter is applied
            if ({{ request()->hasAny(['team_name', 'location_name', 'maintenance_date', 'sensor_type', 'status']) ? 'true' : 'false' }}) {
                filterForm.style.display = 'block';
            }

            toggleFilter.addEventListener('click', function() {
                filterForm.style.display = filterForm.style.display === 'none' ? 'block' : 'none';
            });

            resetFilters.addEventListener('click', function() {
                document.getElementById('team_name').value = '';
                document.getElementById('location_name').value = '';
                document.getElementById('maintenance_date').value = '';
                document.getElementById('sensor_type').value = '';
                document.getElementById('status').value = '';
                filterForm.submit();
            });
        });
    </script>
@endsection
