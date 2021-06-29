@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-white bg-primary mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="h3 text-uppercase">{{ $user->fname . ' ' . $user->lname }}</p>
                            <p class="small pb-0 mb-0">Last login:
                                {{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}</p>
                            <p class="small pb-0 mb-0">Account created: {{ $user->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="col-md-6">
                            {{-- <p class="pb-0 mb-0">Username: {{ $user->username }}</p> --}}
                            <p class="h3">.</p>
                            <p class="small pb-0 mb-0">Phone: {{ $user->phone }}</p>
                            <p class="small pb-0 mb-0">Email: {{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <p class="font-weight-bold h3">{{ $user->specialty->title ?? '-' }}</p>

                    <div class="row p-1">
                        {!! $user->specialty->detail !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-3 mb-5">
        <div class="col-md-10">
            <p class="h3 font-weight-bold">
                Send appointment request for counselling
            </p>
            <div class="card p-3">
                <form method="POST" action="/counselors/send-counselling-request">
                    @csrf

                    {{-- counselor_id --}}
                    <input type="hidden" name="counselor_id" value="{{ $user->id }}">
                    {{-- Student reason --}}
                    <div class="form-group row">
                        <label for="student_reason" class="col-md-12 col-form-label">Your Reason</label>
                        <div class="col-md-12">
                            <input id="student_reason" name="student_reason" placeholder="Your reason"
                                class="form-control  @error('student_reason') is-invalid @enderror" type="text"
                                autocomplete="text">
                            @error('student_reason')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    {{-- Student schdule date --}}
                    <div class="form-group row">
                        <label for="student_date" class="col-md-12 col-form-label">Date you want</label>
                        <div class="col-md-12">
                            <input id="student_date" name="student_date" placeholder="Enter your available date"
                                class="form-control  @error('student_date') is-invalid @enderror" type="date"
                                autocomplete="text">
                            @error('student_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>



                    <div class="form-group row">
                        <div class="offset-4 col-8">
                            <button name="submit" type="submit" class="btn btn-primary">Send Request</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
@endsection
