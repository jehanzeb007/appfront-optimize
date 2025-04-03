<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @yield('style')
</head>
<body>
    <div class="admin-container">
        <!-- Navigation Header -->
        <div class="admin-header">
            <h1>@yield('header', 'Admin Panel')</h1>
            <div>
                @yield('header-actions', '')
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <!-- Content -->
        @yield('content')
    </div>
</body>
</html>
