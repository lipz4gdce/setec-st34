@extends('auth.layout')

@section('main')
    <!-- registration form -->
    <form action="{{ route('password.update') }}" class="sign__form" method="POST">
        @csrf
        <a href="index.html" class="sign__logo">

            <img src="img/logo.svg" alt="">
        </a>
        <input type="hidden" value="{{request()->route('token')}}" name="token" >

        <div class="sign__group">
            <input type="text" class="sign__input"
            placeholder="Email" name="email" value="{{ $_GET['email'] }}">
            @error('email')
            {{ $message }}
        @enderror
        </div>

        <div class="sign__group">
            <input type="password" name="password" class="sign__input" 
            placeholder="Password">
        @error('password')
            {{ $message }}
        @enderror

        </div>
        <div class="sign__group">
            <input type="password" name="password_confirmation" class="sign__input" placeholder="Re-Password">
        </div>
        
        <button class="sign__btn" type="submit">Reset</button>

    </form>
    <!-- registration form -->
@endsection