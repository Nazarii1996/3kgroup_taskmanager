@extends('layouts.app')

@section('content')
    <list :statuses='@json($statuses)'></list>
@endsection
