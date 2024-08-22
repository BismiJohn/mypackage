@extends('layouts.app')

@section('title', 'Add new customer')

@section('content')
    <div class="card">
        <div class="card-header">
            Edit Customer
        </div>
        <div class="card-body">

            <form action="{{ route('customers.store') }}" method="POST" id="createCustomerForm">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Customer Name</label>
                            <input class="form-control" type="text" value="" name="name"
                                id="customer_name">
                        </div>


                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="contact_phone" rows="3"
                                value="">
                        </div>



                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="contact_email"
                                value="">
                        </div>

                        <div class="form-group">
                            <label for="phone">Address</label>
                            <textarea type="text" class="form-control" id="address" name="address" rows="3" value=""></textarea>
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
        $('#createCustomerForm').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('customers.store') }}',
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
                        }, 3200);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Error when adding new project',
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
