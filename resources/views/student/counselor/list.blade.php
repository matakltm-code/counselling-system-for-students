@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($users->count() > 0)
            @foreach ($users as $user)
            <div class="card mb-3">
                <div class="card-header text-capitalize">{{ $user->fname . ' ' . $user->lname }}</div>

                <div class="card-body pb-2">
                    <p class="b">
                        <small>Conselor Specialty</small> <br>
                        @if (!empty($user->specialty->title))
                        <span class="font-weight-bold">{{ $user->specialty->title }}</span>
                        @else
                        <span class="font-weight-bold text-danger">This counselor specialty is not stated
                            yet!</span>
                        @endif
                    </p>
                    <p class="pb-0 mb-0">Email: {{ $user->email }}, Last login:
                        {{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}</p>
                    <hr>
                    <a href="/counselors/{{ $user->id }}" class="btn btn-md btn-primary">Show Detail</a>
                </div>
            </div>
            @endforeach
            <div class="mt-2">
                {{ $users->links() }}
            </div>
            @else
            <div class="alert alert-danger" role="alert">
                <p>There is no any available counselor yet!</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
