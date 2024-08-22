@extends('layouts.app')

@section('title', 'Create Maintenance Record')

@section('content')
    <div class="card">
        <div class="card-header">
            Create New Maintenance Record
        </div>
        <div class="card-body">
            <form action="{{ route('maintenances.store') }}" method="POST" id="createForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sensor_id">Sensor</label>
                            <select class="form-control" id="sensor_id" name="sensor_id">
                                @foreach ($sensors as $sensor)
                                    <option value="{{ $sensor->sensor_id }}">{{ $sensor->sensor_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="Completed">Completed</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="team_id">Service Team</label>
                            <select class="form-control" id="team_id" name="team_id">
                                @foreach ($serviceTeams as $team)
                                    <option value="{{ $team->team_id }}">{{ $team->name }}</option>
                                @endforeach
                                <option value="add_new_team">Add New Team</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="maintenance_date">Maintenance Date</label>
                            <input type="date" class="form-control" id="maintenance_date" name="maintenance_date" required>
                        </div>

                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <!-- Add New Team Modal -->
    <div class="modal fade" id="addTeamModal" tabindex="-1" role="dialog" aria-labelledby="addTeamModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTeamModalLabel">Add New Team</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addTeamForm">
                        @csrf
                        <div class="form-group">
                            <label for="modal_team_name">Team Name</label>
                            <input type="text" name="team_name" id="modal_team_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="modal_contact_email">Contact Email Address</label>
                            <input type="email" name="contact_email" id="modal_contact_email" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="modal_contact_number">Team Contact Number</label>
                            <input type="text" name="contact_number" id="modal_contact_number" class="form-control"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"
    integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.slim.js"
    integrity="sha512-docBEeq28CCaXCXN7cINkyQs0pRszdQsVBFWUd+pLNlEk3LDlSDDtN7i1H+nTB8tshJPQHS0yu0GW9YGFd/CRg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.slim.min.js"
    integrity="sha512-sNylduh9fqpYUK5OYXWcBleGzbZInWj8yCJAU57r1dpSK9tP2ghf/SRYCMj+KsslFkCOt3TvJrX2AV/Gc3wOqA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        var teamSelect = $('#team_id');
        var addTeamModal = $('#addTeamModal');

        teamSelect.on('change', function() {
            if ($(this).val() === 'add_new_team') {
                addTeamModal.modal('show');
            }
        });

        $('#addTeamForm').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('serviceteams.storeAjax') }}',
                method: 'POST',
                data: formData,
                success: function(data) {
                    if (data.success) {
                        // Add the new team to the dropdown
                        var newOption = new Option(data.team.name, data.team.team_id, true,
                            true);
                        teamSelect.append(newOption).trigger('change');

                        // Hide the modal
                        addTeamModal.modal('hide');
                    } else {
                        alert('There was an error adding the team.');
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        });

        // Handle form submission for creating maintenance record
        $('#createForm').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();
            console.log(formData);

            $.ajax({
                url: '{{ route('maintenances.store') }}',
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
                        });

                        // Redirect after message fades
                        setTimeout(function() {
                            window.location.href = data.redirect;
                        }, 3000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Cannot create a new maintenance record',
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
