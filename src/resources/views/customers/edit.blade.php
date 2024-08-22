@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Edit Customer
        </div>
        <div class="card-body">

            <form action="{{ route('customers.update', $customer->customer_id) }}" method="POST" id="updateCustomerForm">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Customer Name</label>
                            <input class="form-control" type="text" value="{{$customer->name}}" name="name" id="customer_name">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="contact_email"
                                value="{{ old('name', $customer->contact_email) }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="contact_phone" rows="3" value="{{ old('description', $customer->contact_phone) }}">
                        </div>



                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="phone">Address</label>
                            <textarea type="text" class="form-control" id="address" name="address" rows="3" value="">{{ old('description', $customer->address) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="project_count">Number Of Projects</label>
                            <input type="number" class="form-control" id="project_count" name="project_count"
                                value="{{ $customer->project_count }}" disabled>
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
        $('#updateCustomerForm').on('submit', function(e) {
            e.preventDefault();
            var projectId = '{{ $customer->customer_id }}';

            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('customers.update', ['customer' => $customer->customer_id]) }}',
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
