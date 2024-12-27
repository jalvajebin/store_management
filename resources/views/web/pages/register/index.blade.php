<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <title>Register | {{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('assets/admin/media/custom/logos/favicon.svg') }}" rel="shortcut icon">
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" rel="stylesheet">
    <link href="{{ asset('assets/admin/plugins/global/plugins.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/style.bundle.css') }}" rel="stylesheet">
    <style>
        body{
            background-color: #1a1a1a;
        }
    </style>
</head>
<body class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat" id="kt_body">
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-column flex-column-fluid flex-lg-row">
        <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10"></div>
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
            <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                    <form id="registerForm" class="form w-100" method="POST" action="{{ route('register.store') }}">
                        @csrf
                        <div class="text-center mb-8">
                            <a href="{{ route('register.index') }}">
                                <h6> STORE MANAGEMENT</h6>
                            </a>
                            <div class="text-gray-500 fw-semibold fs-6">
                                USER REGISTER
                            </div>
                        </div>
                        <div class="fv-row mb-8">
                            <label class="fs-5 fw-semibold mb-2" for="name">Name</label>
                            <input class="form-control bg-transparent" id="name" name="name" type="text" placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                <div data-field="email">{{ $message }}</div>
                            </div>
                            @enderror
                        <div class="fv-row mb-8">
                            <label class="fs-5 fw-semibold mb-2" for="email">Email</label>
                            <input class="form-control bg-transparent" id="email" name="email" type="text" placeholder="Email" value="{{ old('email') }}">
                            @error('email')
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                <div data-field="email">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                        <div class="fv-row mb-8">
                            <label class="fs-5 fw-semibold mb-2" for="password">Password</label>
                            <input class="form-control bg-transparent" id="password" name="password" type="password" placeholder="Password">
                            @error('password')
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                <div data-field="password">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                            <div class="fv-row mb-8">
                                <label class="fs-5 fw-semibold mb-2" for="password_confirmation">Confirm Password</label>
                                <input class="form-control bg-transparent" id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm Password">
                                @error('password_confirmation')
                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    <div data-field="password">{{ $message }}</div>
                                </div>
                                @enderror
                            </div>
                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">
                        <div class="fv-row mb-8">
                            <label class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" name="remember" type="checkbox" @if(old('remember')) checked @endif>
                                <span class="form-check-label fw-semibold text-muted">Remember</span>
                            </label>
                        </div>
                            <div class="d-grid">
                                <button class="btn btn-dark" id="button-login" type="submit">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    document.getElementById('registerForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        // Attempt to get the user's location
        navigator.geolocation.getCurrentPosition(
            function (position) {
                // Populate hidden fields with latitude and longitude
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;

                // Submit the form once location is retrieved
                event.target.submit();
            },
            function (error) {
                // Handle errors
                if (error.code === error.PERMISSION_DENIED) {
                    alert("Location permission is required to proceed. Please allow location access.");
                } else {
                    alert("Unable to fetch your location. Please try again.");
                }
            }
        );
    });
</script>
