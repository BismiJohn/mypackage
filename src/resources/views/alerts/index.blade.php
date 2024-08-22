@extends('layouts.app')

@section('title', 'Alert Records')

@section('content')

<div class="container my-2">
    <h3 class="mb-4 table-heading">Alerts</h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="">
                <tr>
                    <th>Alert ID</th>
                    <th>Sensor/Device</th>
                    <th>Alert Type</th>
                    <th>Alert Message</th>
                    <th>Timestamp</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i=1;
                ?>
                @foreach($alerts as $alert)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $alert->sensors->sensor_type }}</td>
                        <td>{{ $alert->alert_type }}</td>
                        <td>{{ $alert->alert_message }}</td>
                        <td>{{ $alert->timestamp }}</td>
                        <td>
                            @if($alert->status == 'Resolved')
                                <span class="badge badge-success">{{ $alert->status }}</span>
                            @else
                                <span class="badge badge-warning">{{ $alert->status }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $alerts->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>

@endsection
