@extends('layouts.app')

@section('title', 'Customers')

@section('content')
    <h3 class="mb-4 table-heading">Customers</h3>

    <!-- Project Listing Table -->
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Sl No.</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Number of Projects</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $id = 1;
                ?>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $id++ }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->contact_email }}</td>
                    <td>{{ $customer->contact_phone }}</td>
                    <td>{{ $customer->project_count }}</td>
                    <td>
                        <a href="{{ route('customers.show', $customer->customer_id) }}"
                            class="btn btn-info custom-btn-bg btn-sm">
                            <i class="fas fa-eye custom-icon-color"></i>
                        </a>
                        <a href="{{ route('customers.edit', $customer->customer_id) }}"
                            class="btn btn-primary custom-btn-bg btn-sm "><i class="fas fa-edit custom-icon-color"></i></a>
                        <form action="{{ route('customers.destroy', $customer->customer_id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger  custom-btn-bg btn-sm"><i
                                    class="fas fa-trash-alt custom-icon-color"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $customers->links('vendor.pagination.bootstrap-4') }}

    <a href="{{ route('customers.create') }}" class="btn btn-success custom-btn-bg">Add New Customer</a>
@endsection
