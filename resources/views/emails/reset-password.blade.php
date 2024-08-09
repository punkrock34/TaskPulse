@extends('emails.layout')

@section('content')
    <p>Hello, {{ $name }}</p>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <a href="{{ $resetLink }}" class="button">Click here to reset your password</a>
    <p>If you did not request a password reset, no further action is required.</p>
@endsection
