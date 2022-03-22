<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/assets/img/favicon.ico">
    <title>{{ $title }} | SPK Objek Wisata</title>

    <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/assets/css/dashboard.css" rel="stylesheet">
  </head>
  <body>

    {{-- Topbar --}}
    @include('partials.topbar')
    {{-- Topbar --}}

    <div class="container-fluid">
      <div class="row">
        {{-- Sidebar --}}
        @include('partials.sidebar')
        {{-- Sidebar --}}

        {{-- Main Content --}}
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          @yield('content')
        </main>
        {{-- Main Content --}}
      </div>
    </div>

    <script src="/assets/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/assets/js/script.js"></script>
    <script src="/assets/js/dashboard.js"></script>

    {{-- alert from session --}}
    @if (session()->has('success'))
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: "{{ session('success') }}",
        });
      </script>
    @endif
    @if (session()->has('failed'))
      <script>
        Swal.fire({
          icon: 'error',
          title: 'Failed',
          text: "{{ session('failed') }}",
        });
      </script>
    @endif
    @if (isset($errors) && $errors->has('oldPassword') || $errors->has('password'))
      <script>
        const myModal = document.getElementById('modalUbahPassword');
        const modal = bootstrap.Modal.getOrCreateInstance(myModal);
        modal.show();
      </script>
    @endif
  </body>
</html>
