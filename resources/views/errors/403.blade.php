@extends('master')
@section('title', '403')

@section('content')
    <section class="box">
        <h1>403</h1>

    <p>
    {{$exception->getMessage()}}
    </p>
</section>
@endsection
