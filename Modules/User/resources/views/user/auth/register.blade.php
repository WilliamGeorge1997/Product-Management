@extends('common::layouts.master')
@section('title', 'Register')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
@endsection



@section('content')
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif
        <div class="row vh-100 justify-content-center align-items-center">
            <div class="col-12 col-lg-6">
                <img src="{{ asset('assets/images/register.jpg') }}" alt="Register" class="img-fluid w-100">
            </div>
            <div class="col-12 col-lg-6 col-xl-4 offset-xl-1">
                <h2>Register</h2>
                <form class="mt-5" action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email')}} ">
                    </div>
                    <div>
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <p><small>Do you have an email? <a href="{{ route('login.form') }}">Login</a></small></p>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class='text-danger'>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection



@section('js')
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function() {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);

            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    </script>
@endsection
