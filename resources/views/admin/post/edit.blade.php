@extends('template_backend.home')
@section('subjudul', 'Edit Post')
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

    <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-group">
            <label>Judul</label>
            <input type="text" class="form-control" name="judul" value="{{ $post->judul }}">
        </div>
        <div class="form-group">
            <label>Kategori</label>
            <select class="form-control" name="category_id">
                <option value="" holder>Pilih Kategori</option>
                @foreach ($category as $result)
                    <option value="{{ $result->id }}" @if ($post->category_id === $result->id) selected @endif>{{ $result->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Tags</label>
            <select class="form-control select2" multiple="" name="tags[]">
                @foreach ($tags as $result)
                    <option value="{{ $result->id }}" @foreach ($post->tags as $value)  @if ($result->id===$value->id)
                        selected @endif
                @endforeach

                >{{ $result->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Content</label>
            <textarea name="content" class="form-control"
                style="height: 250px; resize: none">{{ $post->content }}</textarea>
        </div>
        <div class="form-group">
            <label>Thumbnail</label>
            <input type="file" class="form-control" name="gambar">
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block">Simpan Post</button>
        </div>
    </form>

@endsection
