@extends('layouts.app')

@section('title', 'Maitenance List')

@section('content')
    <div class="container">
        <h1>Upcoming Calibration Dates</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Sl No.</th>
                    <th>Calibration Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $id = 1;
                ?>
                @foreach ($calibrationData as $data)
                    <tr>
                        <td>{{ $id++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->maintenance_date)->format('j F Y, l') ?? 'N/A' }}</td>
                        <td>
                            <div class="d-flex">
                                <button type="button" class="btn custom-btn-bg mr-2" data-toggle="modal"
                                    data-target="#editModal" data-id="{{ $data->id }}">
                                    <i class="fas fa-edit custom-icon-color"></i>
                                </button>
                                <button type="button" class="btn custom-btn-bg mr-2" data-toggle="modal"
                                    data-target="#deleteModal" data-id="{{ $data->id }}">
                                    <i class="fas fa-trash-alt custom-icon-color"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Calibration Date</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="editId" name="id">
                        <div class="form-group">
                            <label for="editDate">Calibration Date</label>
                            <input type="date" class="form-control" id="editDate" name="date">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Calibration Date</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this calibration date?
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="deleteId" name="id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#editModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);

                $.ajax({
                    url: '/calibration-dates/' + id,
                    method: 'GET',
                    success: function(data) {
                        modal.find('#editId').val(data.id);
                        modal.find('#editDate').val(data.maintenance_date);

                        // Set min and max dates for the date picker
                        var maintenanceDate = new Date(data.maintenance_date);
                        var minDate = new Date(maintenanceDate);
                        minDate.setDate(maintenanceDate.getDate() - 4);
                        var maxDate = new Date(maintenanceDate);
                        maxDate.setDate(maintenanceDate.getDate() + 4);
                        modal.find('#editDate').attr('min', minDate.toISOString().split('T')[
                        0]);
                        modal.find('#editDate').attr('max', maxDate.toISOString().split('T')[
                        0]);
                    }
                });
            });

            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#editId').val();
                var date = $('#editDate').val();

                $.ajax({
                    url: '/calibration-dates/' + id,
                    method: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        date: date
                    },
                    success: function(data) {
                        $('#editModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message,
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    }
                });
            });

            $('#deleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);
                modal.find('#deleteId').val(id);
            });

            $('#confirmDelete').on('click', function() {
                var id = $('#deleteId').val();

                $.ajax({
                    url: '/calibration-dates/' + id,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#deleteModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            text: 'Calibration date deleted successfully',
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    }
                });
            });
        });
    </script>
@endsection
