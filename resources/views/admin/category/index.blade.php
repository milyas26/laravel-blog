@extends('template_backend.home')
@section('subjudul', 'Kategory')
@section('content')

    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session('success') }}
        </div> 
    @endif

<a href="{{ route('category.create') }}" class="btn btn-success mb-3 btn-sm">Tambah Kategory</a>

    <table class="table table-stripped table-hover table-sm table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Category</th>
                <th>Slug</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($category as $result => $hasil)
            <tr>
                <td>{{ $result + $category -> firstitem()}}</td>
                <td>{{$hasil -> name}}</td>
                <td>{{$hasil -> slug}}</td>
                <td>
                    <form action="{{ route('category.destroy', $hasil->id) }}" method="POST">
                        @csrf
                        @method('delete')
                        <a href="{{ route('category.edit', $hasil->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button type="submit" href="" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $category->links() }}

@endsection