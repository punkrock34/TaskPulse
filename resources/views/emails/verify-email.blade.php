@extends('emails.layout')

@section('content')
    <p>Hello, {{ $name }}</p>
    <p>Please click the button below to verify your email address:</p>
    <a href="{{ $verificationUrl }}" class="button">Verify Email</a>
    <p>If you did not create an account, no further action is required.</p>
@endsection
