@extends('layouts.frontend.app')

@section('title', 'Admin Login')

@section('content')
<style>
    .admin-login-wrapper {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 15px;
    }
    .admin-login-card {
        width: 100%;
        max-width: 440px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 30px;
        border: 1px solid #eaeaea;
    }
    .admin-login-card .header-title {
        color: #002f5f;
        font-weight: 700;
        font-size: 22px;
        margin-bottom: 20px;
        text-align: center;
    }
    .admin-login-card .form-control {
        height: 45px;
        border-radius: 6px;
    }
    .admin-login-card .btn-login {
        background: #002f5f;
        color: #ffffff;
        font-weight: 600;
        height: 45px;
        border-radius: 6px;
        border: none;
        transition: all 0.3s ease;
    }
    .admin-login-card .btn-login:hover {
        background: #001f3f;
        color: #ffffff;
    }
</style>

<?php
Session::forget('link');
Session::put(['link' => url()->previous()]);
?>

<div class="admin-login-wrapper">
    <div class="admin-login-card">
        @if(!empty(setting('auth_logo')))
            <div class="text-center mb-3">
                <a href="{{ route('home') }}">
                    <img style="max-width: 130px; max-height: 60px; object-fit: contain;" src="{{ asset('uploads/setting/' . setting('auth_logo')) }}" alt="{{ config('app.name') }}">
                </a>
            </div>
        @endif

        <h4 class="header-title">Admin Sign In</h4>

        <form action="{{ route('super.login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Username / Email / Phone <span style="color: red;">*</span></label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    class="form-control @error('username') is-invalid @enderror" 
                    value="{{ old('username') }}" 
                    placeholder="Enter username, email or phone" 
                    required 
                    autofocus 
                />
                @error('username')
                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password <span style="color: red;">*</span></label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    placeholder="Enter your password" 
                    required 
                />
                @error('password')
                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-login btn-block mt-4">Login to Admin</button>

            <div class="text-center mt-3">
                <a href="{{ route('password.request') }}" class="text-muted" style="font-size: 14px;">Forgot Password?</a>
            </div>
        </form>
    </div>
</div>

@endsection