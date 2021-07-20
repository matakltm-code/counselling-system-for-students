@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Create Post</h1>
    <form action="/files" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <label for="title" class="col-12 col-form-label">Title</label>
            <div class="col-12">
                <input value="{{ old('title') }}" id="title" name="title" placeholder="Enter title"
                    class="form-control  @error('title') is-invalid @enderror" type="text">
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="editor" class="col-12 col-form-label">Description</label>
            <div class="col-12">
                <textarea name="body" class="editor" rows="10" value="{!! old('body') !!}"></textarea>
            </div>
            @error('body')
            <span class="text-danger pl-3" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group row p-2">
            <div class="input-group-prepend">
                <span class="input-group-text">File</span>
            </div>
            <div class="custom-file">
                <input type="file" name="file" class="custom-file-input" id="inputGroupFile01">
                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
            </div>
            @error('file')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group row">
            <label for="counselor_id" class="col-12 col-form-label">To</label>
            <div class="col-12">
                <select class="form-control  @error('counselor_id') is-invalid @enderror" name="counselor_id"
                    id="counselor_id">
                    @foreach (\App\Models\User::where('user_type', 'counselor')->get() as $user)
                    <option value="{{$user->id}}">{{ $user->fname . ' ' . $user->lname }}</option>
                    @endforeach
                </select>
            </div>
            @error('counselor_id')
            <span class="text-danger pl-3" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group row">
            <div class="col-12">
                <button name="submit" type="submit" class="btn btn-primary">Share File</button>
            </div>
        </div>
    </form>
</div>
@endsection
