<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Rensy Gallery</title>

    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/pastel.css') }}">

    <style>body{font-family:'Quicksand',sans-serif;background:#FDF2F8;}</style>
</head>

<body>

    {{-- Navbar component --}}
    <x-navbar />

    {{-- flash messages --}}
    <div class="container py-3">
        @if(session('success'))
            <div class="alert alert-success rounded-3 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger rounded-3 shadow-sm">
                {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- main content --}}
    <main class="container pb-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
