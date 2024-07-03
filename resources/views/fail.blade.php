@extends('auth.layout')

@section('main')
<form action="{{ route('billing') }}" class="sign__form" method="GET">
    @csrf
    <a href="index.html" class="sign__logo">

        <img src="img/logo.svg" alt="">
    </a>


    <div class="sign__group">
        <span>You need to subscribe other plan first!</span>
    </div>


    <button type="submit" class="sign__btn" >Subscription plan</button>
</form>
@endsection
