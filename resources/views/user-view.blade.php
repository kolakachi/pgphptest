@extends('layout.master')
@section('title')
<title>User Card - {{ $user->name }}</title>
@endsection
@section('content')
<section id="main">
    <header>
        <span class="avatar"><img src="{{'images/users/'. $user->photo->image}}" alt="" /></span>
        <h1>{{$user->name}}</h1>
        <p>{{ $user->comments }}</p>
    </header>
</section>
@endsection