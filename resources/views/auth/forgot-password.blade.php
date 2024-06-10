@extends('auth.layout')

@section('main')
<form action="{{ route('password.email') }}" class="sign__form" method="POST">
    @csrf
    <a href="index.html" class="sign__logo">

        <img src="img/logo.svg" alt="">
    </a>

    @if (session('status'))
        <div style="color:green;">
            {{ session('status') }}
        </div>
    @endif

    <div class="sign__group">
        <input type="text" class="sign__input" value="{{ old('email') }}"
        placeholder="Email" name="email">
        @error('email')
        <span style="color:red;">{{ $message }}</span>
        @enderror
    </div>
    
    <button class="sign__btn" type="submit">Request Reset</button>


</form>
@endsection