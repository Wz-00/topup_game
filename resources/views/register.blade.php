@extends('layouts.main')
@section('body')
<link rel="stylesheet" href="css/login.css">
<div class="pt5 pb5">
    <div class="login align-self-center mx-auto">
        <div class="d-flex flex-columns">
            <div class="container py-4">
                <form action="/register" method="POST">
                    @csrf
                    <h3 class="text-center">Register</h3>
                    <div class="mb-3 form-floating">
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        <label for="name">Name :</label>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}">
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
                    <div class="mb-3 form-floating">
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        <label for="email">Email :</label>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="d-flex">
                        <span>already have an account? <a href="/login">Login</a></span>
                        <button class="button ms-auto p-2">Register</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection