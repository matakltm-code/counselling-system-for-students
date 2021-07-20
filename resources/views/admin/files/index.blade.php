@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between">
        <h1>Files</h1>
        @if (auth()->user()->is_admin)
        <a href="/files/create" class="btn btn-link btn-sm">Share new file</a>
        @endif
    </div>
    @if(count($files) > 0)
    @foreach($files as $file)
    <div class="card p-2 mb-2">
        <div class="row">
            <div class="col-md-8 col-sm-8 d-flex flex-column">
                <div>
                    <h3><a href="/files/{{$file->id}}">{{$file->title}}</a></h3>
                </div>
                <div>
                    <small>Shared on {{$file->created_at}}
                        ({{$file->created_at->diffForHumans()}}) by {{$file->user->fname}}
                    </small>
                </div>

                <div>
                    <small>Shared to {{$file->shared_to->fname . ' ' . $file->shared_to->lname}}</small>
                </div>
                <div>
                    <small class="text-muted">User type:
                        {{ $file->user->account_type_text($file->user->user_type) }}</small>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 d-flex align-items-center">
                <div>
                    <a href="/{{$file->file_path}}">Download File</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    {{$files->links()}}
    @else
    <p>No file found</p>
    @endif
</div>
@endsection
