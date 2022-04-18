@extends('layouts.auth')

@section('content')
  <main class="form-signin">
    <form action="/signup" method="POST">
      @csrf

      <img class="mb-4" src="/assets/img/palmtree-silhouette.svg" alt="Palm Tree" width="72" height="57">
      <h1 class="h3 fw-normal">Sign Up</h1>
      <small class="text-center d-block mb-3">it's quite easy</small>

      <div class="form-floating">
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="name@example.com" value="{{ old('name') }}" autocomplete="off" required>
        <label for="name">Fullname</label>
        @error('name')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="form-floating">
        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="name@example.com" value="{{ old('username') }}" autocomplete="off" required>
        <label for="username">Username</label>
        @error('username')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="form-floating">
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" autocomplete="off" required>
        <label for="email">Email address</label>
        @error('email')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="form-floating">
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
        <label for="password">Password</label>
        @error('password')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="my-2">
        {!! NoCaptcha::renderJs() !!}
        {!! NoCaptcha::display() !!}

        @error('g-recaptcha-response')
          <span class="help-block text-danger">
            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
          </span>
        @enderror
      </div>

      <div class="mb-2 @error('password') mt-4 @enderror">
        Already have an account? 
        <a href="/" class="text-decoration-none">Sign In</a>
      </div>

      <button class="w-100 btn btn-lg btn-primary" type="submit">Sign Up</button>
      <p class="mt-3 mb-3 text-muted">&copy; SPK Objek Wisata {{ now()->year }}</p>
    </form>
  </main>
@endsection