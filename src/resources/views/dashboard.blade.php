@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
    <style>
        .graph-container {
            background-color: #ffffff;
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-1">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="graph-container">
                                    <h5>Chlorine Injection Monitor</h5>
                                    <canvas id="outputInjectionChart" width="400"height="300"></canvas>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="graph-container">
                                    <h5 class="d-inline">Chlorine Weight Status</h5>
                                    <canvas id="weightHistogram" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="graph-container">
                                    <h5>Device Working Status</h5>
                                    <canvas id="deviceWorkingChart" width="400"height="336"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="graph-container">
                                    <h5 class="d-inline">Device Modes-<small class="text-muted">
                                            Manual({{ $manualModePercentage }}%)
                                            Auto({{ $autoModePercentage }}%)</small></h5>
                                    <canvas id="deviceModesChart" width="400" height="336"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="deviceSelect">Select Device:</label>
                            <select id="deviceSelect" class="form-control" onchange="">
                                @foreach ($devices as $device)
                                    <option value="{{ $device->device_id }}"
                                        {{ $device->device_id == $latestDeviceId ? 'selected' : '' }}>
                                        {{ $device->device_id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Area Chart for Output Injection Rate -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="graph-container">
                                    <h5>Chlorine Injection Monitor</h5>
                                    <canvas id="outputInjectionRateChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="graph-container">
                                    <h5>Flow Rate Monitor</h5>
                                    <canvas id="flowRateChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                        @if ($latestDeviceSettings)
                            <form action="#" class="form-control" id="deviceSettingsUpdateForm">
                                @csrf
                                <input type="text" value={{ $latestDeviceId }} hidden name="device_id" id="device_id">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="graph-container text-center">
                                            <h5>Device Mode:</h5>
                                            <select name="mode" class="form-control" id="device_mode">
                                                <option value="M"
                                                    {{ $latestDeviceSettings->mode == 'M' ? 'selected' : '' }}>Manual
                                                </option>
                                                <option value="A"
                                                    {{ $latestDeviceSettings->mode == 'A' ? 'selected' : '' }}>Auto</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="graph-container text-center">
                                            <h5>Device Status:</h5>
                                            <select name="device_status" class="form-control" id="device_status">
                                                <option value="ON"
                                                    {{ $latestDeviceSettings->device_status == 'ON' ? 'selected' : '' }}>ON
                                                </option>
                                                <option value="OFF"
                                                    {{ $latestDeviceSettings->device_status == 'OFF' ? 'selected' : '' }}>
                                                    OFF</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="graph-container text-center">
                                            <h5>Doser Setpoint:</h5>
                                            <input type="number" name="setpoint" class="form-control" id="device_setpoint"
                                                value="{{ $latestDeviceSettings->setpoint }}" min="0" max="5" step="0.0000000001"
                                                placeholder="0.0000000000">
                                        </div>
                                    </div>

                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="graph-container text-center">
                                            <h5>Key:</h5>
                                            <input type="text" name="key" class="form-control" id="device_key"
                                                value="{{ $latestDeviceSettings->key }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="graph-container text-center">
                                            <h5>Updation Rate:</h5>
                                            <input type="number" name="updation_rate" class="form-control" id="device_updation_rate"
                                                value="{{ $latestDeviceSettings->updation_rate }}" min="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 pb-5">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary" id="deviceSettingsEditbutton">Save
                                            Changes</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="graph-container">
                                        <h5>Device Settings Not Found</h5>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var injectionRateChart; // Declare a global variable to store the chart instance

        function renderInjectionRateChart(data) {
            var ctx = document.getElementById('outputInjectionRateChart').getContext('2d');

            // Check if the chart instance exists and destroy it
            if (injectionRateChart) {
                injectionRateChart.destroy();
            }

            // Create a new chart instance and store it in the global variable
            injectionRateChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Output Injection Rate',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        data: data.values,
                        fill: true,
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                max: 100
                            }
                        }]
                    }
                }
            });
        }

        var flowRateChart; // Declare a global variable to store the chart instance

        function renderDeviceFlowChart(data) {
            var ctx = document.getElementById('flowRateChart').getContext('2d');

            // Check if the chart instance exists and destroy it
            if (flowRateChart) {
                flowRateChart.destroy();
            }

            // Create a new chart instance and store it in the global variable
            flowRateChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Output Injection Rate',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        data: data.values,
                        fill: true,
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                max: 100
                            }
                        }]
                    }
                }
            });
        }


        function fetchDeviceFlowData(deviceId) {
            $.ajax({
                url: '{{ route('dashboard.deviceModeData') }}',
                type: 'GET',
                data: {
                    device_id: deviceId
                },
                success: function(response) {
                    renderDeviceFlowChart(response);
                }
            });
        }

        function fetchDeviceSettings(deviceId) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route('settingsform.update') }}',
                type: 'POST',
                data: {
                    device_id: deviceId
                },
                success: function(response) {
                    if (response.success) {
                        $('#device_id').val(deviceId);
                        $('#device_mode').val(response.data.mode);
                        $('#device_status').val(response.data.device_status);
                        $('#device_setpoint').val(response.data.setpoint);
                        $('#device_key').val(response.data.key);
                        $('#device_updation_rate').val(response.data.updation_rate);
                    } else {
                        alert('Failed to fetch device settings');
                    }
                }
            });
        }

        function fetchInjectionRateData(deviceId) {
            $.ajax({
                url: '{{ route('dashboard.deviceData') }}',
                type: 'GET',
                data: {
                    device_id: deviceId
                },
                success: function(response) {
                    renderInjectionRateChart(response);
                }
            });
        }


        $(document).ready(function() {
            var initialDeviceId = $('#deviceSelect').val();
            fetchDeviceFlowData(initialDeviceId);
            fetchInjectionRateData(initialDeviceId);

            $('#deviceSelect').on('change', function() {
                var selectedDeviceId = $(this).val();
                fetchDeviceFlowData(selectedDeviceId);
                fetchInjectionRateData(selectedDeviceId);
                fetchDeviceSettings(selectedDeviceId);

            });

            $('#deviceSettingsUpdateForm').on('submit', function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '{{ route('settings.update') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            if (response.flag == 2) {
                                console.log(formData);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'info', // Information alert
                                    title: 'Information',
                                    text: response.message,
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                            }

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update device settings',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>

    <script>
        var ctxDeviceModes = document.getElementById('deviceWorkingChart').getContext('2d');
        var deviceModesChart = new Chart(ctxDeviceModes, {
            type: 'pie',
            data: {
                labels: [
                    'No fault: {{ $noFaultCountPercentage }}%',
                    'Other: {{ $faultCount1Percentage }}%',
                    'Network: {{ $faultCount2Percentage }}%',
                    'Chlroine level: {{ $faultCount3Percentage }}%'
                ],
                datasets: [{
                    label: 'Device Modes',
                    data: [
                        {{ $noFaultCountPercentage }},
                        {{ $faultCount1Percentage }},
                        {{ $faultCount2Percentage }},
                        {{ $faultCount3Percentage }}
                    ],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',

                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',

                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                plugins: {
                    datalabels: {
                        formatter: (value, ctx) => {
                            let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            let percentage = (value / sum * 100).toFixed(2) + "%";
                            return percentage;
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                legend: {
                    position: 'right',
                    labels: {
                        fontSize: 12,
                        boxWidth: 15,
                        padding: 15
                    }
                },
                layout: {
                    padding: {
                        left: 10,
                        right: 10,
                        top: 10,
                        bottom: 10
                    }
                }
            }
        });
    </script>
    <script>
        var weights = {{ Illuminate\Support\Js::from($weights) }}
        var ctx = document.getElementById('weightHistogram').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(weights),
                datasets: [{
                    label: 'Chlorine content',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    data: Object.values(weights),
                    fill: true,
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 50
                        }
                    }]
                }
            }
        });
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(weights),
                datasets: [{
                    label: 'Chlorine content',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    data: Object.values(weights),
                    fill: true,
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 50
                        }
                    }]
                }
            }
        });
    </script>
    <script>
        var outputInjectionRate = {{ Illuminate\Support\Js::from($outputInjectionRate) }}
        var ctx = document.getElementById('outputInjectionChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: Object.keys(weights),
                datasets: [{
                    label: 'Chlorine Injection Rate',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    data: Object.values(outputInjectionRate),
                    fill: true,
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 50
                        }
                    }]
                }
            }
        });
    </script>
    <script>
        var ctxDeviceModes = document.getElementById('deviceModesChart').getContext('2d');
        var deviceModesChart = new Chart(ctxDeviceModes, {
            type: 'doughnut',
            data: {
                labels: ['Manual Mode', 'Auto Mode'],
                datasets: [{
                    label: 'Device Modes',
                    backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                    borderColor: ['rgba(255, 99, 132, 0.4)', 'rgba(54, 162, 235, 0.4)'],
                    data: [{{ $manualModePercentage }}, {{ $autoModePercentage }}],
                    fill: false,
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    datalabels: {
                        formatter: (value, ctx) => {
                            let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            let percentage = (value / sum * 100).toFixed(2) + "%";
                            return percentage;
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                legend: {
                    position: 'right',
                    labels: {
                        fontSize: 12,
                        boxWidth: 15,
                        padding: 15
                    }
                },
                layout: {
                    padding: {
                        left: 10,
                        right: 10,
                        top: 10,
                        bottom: 10
                    }
                }
            }
        });
    </script>
@endsection
