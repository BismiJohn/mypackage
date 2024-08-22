@extends('layouts.app')

@section('title', 'Sensor data reports')

@section('content')
    <div class="row" style="border-radius:5px;">
        <div class="col-md-12">

            <div class="d-flex">
                <h3 class="table-heading">Device Data</h3>
                <div class="ml-auto">
                    <button id="toggleFilter" class="btn btn-secondary mr-2" type="button">
                        <i class="fas fa-filter"></i>
                    </button>
                    <button type="button" id="resetFilters" class="btn btn-light">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            <form id="filter-form" action="{{ route('sensor-data.index') }}" method="GET" class="form-inline"
                style="display: none;">
                <input type="hidden" name="filter_applied" id="filter_applied"
                    value="{{ request('filter_applied', 'false') }}">
                <div class="row">
                    <div class="form-group mr-2">
                        <label for="start_date" class="mr-2">Start Date:</label>
                        <input type="date" name="start_date" id="start_date" class="form-control"
                            value="{{ request('start_date') }}">
                    </div>
                    <div class="form-group mr-2">
                        <label for="end_date" class="mr-2">End Date:</label>
                        <input type="date" name="end_date" id="end_date" class="form-control"
                            value="{{ request('end_date') }}">
                    </div>
                    <div class="form-group mr-2">
                        <label for="device_id" class="mr-2">Device ID:</label>
                        <select name="device_id" id="device_id" class="form-control">
                            <option value="">Select Device ID</option>
                            @foreach ($deviceIds as $deviceId)
                                <option value="{{ $deviceId->device_id }}"
                                    {{ request('device_id') == $deviceId->device_id ? 'selected' : '' }}>
                                    {{ $deviceId->device_id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary custom-btn-bg">Apply</button>
                    </div>
                </div>
            </form>
            <div id="device-data-table">
                @include('sensor_data.table', ['deviceData' => $deviceData])
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleFilter = document.getElementById('toggleFilter');
            const filterForm = document.getElementById('filter-form');
            const resetFilters = document.getElementById('resetFilters');
            const filterApplied = document.getElementById('filter_applied');


            // Display filter form if any filter is applied
            if ({{ request()->hasAny(['start_date', 'end_date', 'device_id']) ? 'true' : 'false' }}) {
                filterForm.style.display = 'block';
            }

            // Toggle filter form visibility
            toggleFilter.addEventListener('click', function() {
                filterForm.style.display = filterForm.style.display === 'none' || filterForm.style
                    .display === '' ? 'block' : 'none';
            });

            // Reset filters and keep the form visible
            resetFilters.addEventListener('click', function() {
                document.getElementById('start_date').value = '';
                document.getElementById('end_date').value = '';
                document.getElementById('device_id').value = '';
                filterForm.submit();
            });
        });
    </script>
@endsection
