@extends('auth.layout')

@section('main')
<form action="{{ route('welcome') }}" class="sign__form" method="GET">
    @csrf
    <a href="{{ route('welcome') }}" class="sign__logo">

        <img src="img/logo.svg" alt="">
    </a>

    <div class="sign__group">
        <span style="color: rgb(55, 0, 253)">You have login successfully</span>
    </div>


    <button class="sign__btn" >Back to dashboard</button>
</form>
@endsection
