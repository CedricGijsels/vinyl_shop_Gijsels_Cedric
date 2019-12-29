@extends('layouts.template')

@section('title', "Edit user: $user->name")

@section('main')
    <h1>Update user</h1>
    <form action="/admin/users/{{ $user->id }}" method="post" class="deleteUser">
        @method('put')
        @include('admin.users.form')
    </form>
@endsection
