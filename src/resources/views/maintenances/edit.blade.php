@extends('layouts.app')

@section('title', 'Edit Maintenance Record')

@section('content')
    <div class="card">
        <div class="card-header">
            Edit Maintenance Record
        </div>
        <div class="card-body">
            <form action="{{ route('maintenances.update', $maintenance->maintenance_id) }}" method="POST" id="updateMaintenanceForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sensor_id">Sensor</label>
                            <select class="form-control" id="sensor_id" name="sensor_id">
                                @foreach ($sensors as $sensor)
                                    <option value="{{ $sensor->sensor_id }}" {{ $maintenance->sensor_id == $sensor->sensor_id ? 'selected' : '' }}>
                                        {{ $sensor->sensor_type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required>{{ $maintenance->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="Completed" {{ $maintenance->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Pending" {{ $maintenance->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="team_id">Service Team</label>
                            <select class="form-control" id="team_id" name="team_id">
                                @foreach ($serviceTeams as $team)
                                    <option value="{{ $team->team_id }}" {{ $maintenance->team_id == $team->team_id ? 'selected' : '' }}>
                                        {{ $team->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="maintenance_date">Maintenance Date</label>
                            <input type="date" class="form-control" id="maintenance_date" name="maintenance_date" value="{{ $maintenance->maintenance_date }}">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary ">Update</button>
            </form>
        </div>
    </div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#updateMaintenanceForm').on('submit', function(e) {
            e.preventDefault();
            var maintenanceId = '{{ $maintenance->maintenance_id }}';
            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('maintenances.update',['maintenance'=>$maintenance->maintenance_id]) }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message,
                            timer: 3000,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.href = data.redirect;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'There was an error updating the maintenance record.',
                        });
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an error processing your request.',
                    });
                }
            });
        });
    });
</script>
