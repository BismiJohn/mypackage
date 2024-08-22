@extends('layouts.app')

@section('title', 'Edit Project Details')

@section('content')
    <div class="card">
        <div class="card-header">
            Edit Project
        </div>
        <div class="card-body">

            <form action="{{ route('projects.update', $project->project_id) }}" method="POST" id="updateProjectForm">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="customer_id">Customer</label>
                            <select class="form-control" id="customer_id" name="customer_id">
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->customer_id }}"
                                        {{ $project->customer_id == $customer->customer_id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $project->name) }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $project->description) }}</textarea>
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ $project->start_date }}">
                        </div>

                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ $project->end_date }}">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary custom-btn-bg">Update</button>
            </form>
        </div>
    </div>

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        // Handle form submission for creating project
        $('#updateProjectForm').on('submit', function(e) {
            e.preventDefault();
            var projectId = '{{ $project->project_id }}';

            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('projects.update', ['project_id' => $project->project_id]) }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function(data) {
                    if (data.success) {
                        // Show success message
                        $('#successMessage').text(data.message).fadeIn();

                        // Hide success message after 3 seconds
                        setTimeout(function() {
                            $('#successMessage').fadeOut();
                        }, 3000);

                        // Redirect after message fades
                        setTimeout(function() {
                            window.location.href = data.redirect;
                        }, 3500);
                    } else {
                        alert('There was an error creating the project.');
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        });
    });
</script>
