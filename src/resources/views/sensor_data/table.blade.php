<div class="table-responsive content-wrapper top-widget-tabs horizontal" style="box-sizing: border-box; margin:0">
    <table class="table table-striped mt-3">
        <thead class="" >
            <tr>
                <th>Sl No</th>
                <th>Device ID</th>
                <th>Setpoint</th>
                <th>Working Pump</th>
                <th>Output Injection Rate</th>
                <th>Flow Rate</th>
                <th>Network Status</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $perPage = $deviceData->perPage();
            $currentPage = $deviceData->currentPage();
            $startIndex = ($currentPage - 1) * $perPage + 1;
            ?>
            @foreach($deviceData as $index => $data)
                <tr>
                    <td>{{ $startIndex + $index }}</td>
                    <td>{{ $data->device_id }}</td>
                    <td>{{ $data->setpoint }}</td>
                    <td>{{ $data->working_pump }}</td>
                    <td>{{ $data->output_injection_rate }}%</td>
                    <td>{{ $data->flow_rate }}</td>
                    <td>{{ $data->network_status }}</td>
                    <td>{{ $data->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $deviceData->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}
</div>
