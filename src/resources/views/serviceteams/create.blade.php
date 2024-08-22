@extends('layouts.app')

@section('title', 'Add New Service Team')

@section('content')
    <div class="container">
        <h1>Add New Team</h1>
        <form action="{{ route('serviceteams.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="project_id">Team Name</label>
                <input type="text" name="team_name" id="team_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="sensor_type">Contact Email Address</label>
                <input type="text" name="contact_email" id="contact_email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="installation_date">Team Contact Number</label>
                <input type="text" name="contact_number" id="contact_number" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
