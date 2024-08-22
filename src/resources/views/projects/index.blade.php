@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <h3 class="mb-4 table-heading">Projects</h3>

    <!-- Project Listing Table -->
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Name</th>
                <th>Description</th>
                <th>Location Details</th>
                <th>Start Date</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->customer->name }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->description }}</td>
                    <td>{{ $project->project_location_details }}</td>
                    <td>{{ $project->start_date }}</td>
                    <td>
                            <a href="{{ route('projects.edit', $project->project_id) }}" class="btn btn-primary custom-btn-bg btn-sm "><i class="fas fa-edit custom-icon-color"></i></a>
                            <form action="{{ route('projects.destroy', $project->project_id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger  custom-btn-bg btn-sm"><i class="fas fa-trash-alt custom-icon-color"></i></button>
                            </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $projects->links('vendor.pagination.bootstrap-4') }}

    <a href="{{ route('projects.create') }}" class="btn btn-success custom-btn-bg">Add New Project</a>
@endsection
