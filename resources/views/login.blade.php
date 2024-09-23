@extends('layouts.main')

@section('body')
<link rel="stylesheet" href="css/login.css">
<div class="pt5 pb5">
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('loginfailed'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('loginfailed') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="login align-self-center mx-auto">
        <div class="d-flex flex-columns">
            <div class="container py-4">
                <form action="/login" method="POST">
                    @csrf
                    <h3 class="text-center">Login</h3>
                    <div class="mb-3 form-floating">
                        <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" autofocus value="{{ old('username') }}">
                        <label for="username">Username :</label>
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        <label for="password">Password :</label>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        
                    </div>
                    <div class="d-flex">
                        <input type="checkbox" id="rememberme" class="form-check-input">
                        <label for="rememberme" class="form-check-label">Remember me</label>
                        <span class="ms-auto">don't have an account? <a href="/register" >Register</a></span>                        
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="button">Login</button>
                    </div>                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection