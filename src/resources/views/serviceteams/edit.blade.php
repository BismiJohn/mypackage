@extends('layouts.app')

@section('title', 'Edit Service Team Details')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Edit Team
            </div>
            <div class="card-body">
                <form action="{{ route('serviceteams.update', $team->team_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="team_name">Team Name</label>
                        <input type="text" name="team_name" id="team_name" class="form-control" value="{{ $team->name }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="contact_email">Contact Email Address</label>
                        <input type="email" name="contact_email" id="contact_email" class="form-control"
                            value="{{ $team->contact_email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Team Contact Number</label>
                        <input type="text" name="contact_number" id="contact_number" class="form-control"
                            value="{{ $team->contact_phone }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary custom-btn-bg">Update</button>
                </form>
            </div>
        </div>
        @endsection
