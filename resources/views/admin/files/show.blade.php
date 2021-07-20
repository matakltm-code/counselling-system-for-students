@extends('layouts.app')

@section('content')
<div class="container">
    <a href="/files" class="btn btn-link btn-sm">Go Back</a>
    <div class="d-flex flex-row justify-content-between">
        <div>
            <h1>{{$file->title}}</h1>
        </div>
        <div>
            <a href="/{{$file->file_path}}">Download File</a>
        </div>
    </div>

    <div>
        {!!$file->body!!}
    </div>
    <small>Written on {{$file->created_at}} ({{$file->created_at->diffForHumans()}}) by {{$file->user->name}}</small>
    <div>
        <small>Shared to {{$file->shared_to->fname . ' ' . $file->shared_to->lname}}</small>
    </div>
    <hr>
    <div class="d-flex justify-content-between">
        @if(Auth::user()->id == $file->user_id)
        {{-- <a href="/files/{{$file->id}}/edit" class="btn btn-info">Edit</a> --}}

        <form method="POST" action="/files/{{$file->id}}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                {{ __('Delete') }}
            </button>
        </form>
        @endif
    </div>
</div>
@endsection
