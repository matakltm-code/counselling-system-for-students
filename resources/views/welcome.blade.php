@extends('layouts.app')

@section('content')
<div class="container-fluid p-0 m-0">
    @include('inc.slide')
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="jumbotron">
                @auth
                <h5>Welcome, <span
                        class="text-primary font-weight-bold">{{ auth()->user()->account_type_text(auth()->user()->user_type) }}</span>
                </h5>
                @endauth
                <h1 class="display-4">Counselling System for UOG Students</h1>
                <p class="lead">From time to time, people face difficulties in their lives. You may know the situation
                    when you just can not make a decision yourself and need someone to guide you towards the right
                    direction. In this case, it would be wise to appeal to a professional counselor who will listen to
                    all your concerns and give you professional advice in order to help solving your problems</p>
                <hr class="my-4">
                <p>Quick Links</p>
                @guest
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="/login" role="button">Login</a>
                </p>
                @else
                @if(auth()->user()->is_admin)
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="/account" role="button">Users Account Management</a>
                </p>
                <p class="lead">
                    <a class="btn btn-link btn-lg" href="/account/login-history" role="button">Users Login
                        History</a>
                </p>
                @elseif(auth()->user()->is_counselor)

                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="/counselling-requests" role="button">Counselling
                        Requests</a>
                </p>
                @elseif(auth()->user()->is_student)
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="/appointments" role="button">Appointments</a>
                </p>
                <p class="lead">
                    <a class="btn btn-link btn-lg" href="/counselors" role="button">Find Counselors</a>
                </p>
                @endif

                @endguest
            </div>
        </div>
    </div>
</div>
@endsection
