@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td>Имя</td>
                    <td>Емейл</td>
                    <td>Дата создания</td>
                </tr>
                </thead>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->created_at}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection
