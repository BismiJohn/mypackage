<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Chlorinator</title>
    <link rel="icon" href="{{ asset('images/favicon2.png') }}" type="image/png">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('{{ asset('images/doserbg.png') }}'); /* Background image */
            background-size: cover; /* Cover the entire page */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent repeating */
            color: #333; /* Text color */
            min-height: 100vh; /* Ensure full height */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-header {
            background-color: #1e6797; /* Your theme color */
            color: white;
            text-align: center;
            padding: 1.5rem;
        }
        .btn-primary {
            background-color: #1e6797; /* Your theme color */
            border-color: #1e6797;
        }
        .btn-primary:hover {
            background-color: #155a7f; /* Darker shade of your theme color */
            border-color: #155a7f;
        }
        .form-control {
            border-radius: 0.25rem;
        }
        .card {
            border-radius: 0.5rem;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        .login-title {
            font-size: 2rem;
            color: rgb(255, 255, 255);
            margin-bottom: 0.5rem;
        }
        .register-link {
            text-align: center;
            color: rgb(224, 214, 214);
            margin-top: 1rem;
        }
        .register-link a {
            color: #1e6797;
            font-weight: bold;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header">
                        <img class="logo-img"
                            src="{{ asset('images/Smart_Cl.png') }}" alt="" width="45%">
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="register-link">
                    Don't have an account? <a href="{{ route('register') }}">Register here</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
