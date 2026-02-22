<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/js/app.js'])
</head>
<body class="bg-light">
    <div class="min-vh-100 d-flex align-items-center py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-7 col-lg-5">
                    <div class="text-center mb-4">
                        <a href="/" class="text-decoration-none">
                            <span class="fs-3 fw-bold">{{ config('app.name', 'Laravel') }}</span>
                        </a>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            {{ $slot }}
                        </div>
                    </div>

                    <p class="text-center text-muted mt-3 mb-0" style="font-size:.9rem;">
                        © {{ date('Y') }} {{ config('app.name', 'Laravel') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>