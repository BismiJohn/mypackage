@extends('layouts.app')

@section('title', 'Service Teams')

@section('content')
    <div class="container">
        <h3 class="table-heading">Teams</h3>

        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Sl No.</th>
                    <th>Team Name</th>
                    <th>Contact Email</th>
                    <th>Contact Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $id=1;
                ?>
                @foreach($teams as $team)
                    <tr>
                        <td>{{ $id++ }}</td>
                        <td>{{ $team->name ?? 'N/A' }}</td>
                        <td>{{ $team->contact_email ?? 'N/A' }}</td>
                        <td>{{ $team->contact_phone ?? 'N/A' }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('serviceteams.edit', $team->team_id) }}" class="btn custom-btn-bg  mr-2"><i class="fas fa-edit custom-icon-color"></i></a>
                                <form action="{{ route('serviceteams.destroy', $team->team_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger custom-btn-bg" onclick="return confirm('Are you sure you want to delete this sensor?')"><i class="fas fa-trash-alt custom-icon-color"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('serviceteams.create') }}" class="btn btn-primary custom-btn-bg mb-3">Add New Team</a>
    </div>
@endsection
