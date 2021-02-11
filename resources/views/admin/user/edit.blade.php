@extends('template_backend.home')
@section('subjudul', 'Edit User')
@section('content')

    @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif

    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session('success') }}
        </div>
    @endif

    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('patch')
        <div class="form-group">
            <label>Nama User</label>
            <input type="text" class="form-control" name="name" value="{{ $user->name }}">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" value="{{ $user->email }}" readonly>
        </div>
        <div class="form-group">
            <label>Tipe User</label>
            <select name="type" class="form-control" id="">
                <option value="">Pilih tipe user</option>
                <option value="1" @if ($user->type === 1) selected @endif>
                    Administrator</option>
                <option value="0" @if ($user->type === 0) selected @endif>
                    Author</option>
            </select>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block">Edit User</button>
        </div>
    </form>

@endsection
