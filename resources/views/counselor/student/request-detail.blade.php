@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card
                @if($appointment->request_status == 'refused') bg-danger text-medium @endif
                @if($appointment->request_status == 'accepted') bg-success text-white @endif
                @if($appointment->request_status == 'pending') bg-warning @endif
            ">
                <div class="card-header text-capitalize">
                    Counselling Status - <span class="font-weight-bold">{{ $appointment->request_status }}</span>
                    <br>
                    <small>Sent {{ $appointment->created_at->diffForHumans() }}</small>
                </div>

                <div class="card-body pb-2 pl-5">
                    <small>{{ $appointment->student->fname }}'s Reason</small>
                    <p class="b">
                        <span class="font-weight-bold">{{ $appointment->student_reason ?? '-' }}</span>
                    </p>
                    <small>{{ $appointment->student->fname }}'s Comfortable Date</small>
                    <p class="b">
                        <span
                            class="font-weight-bold">{{ \Carbon\Carbon::parse($appointment->student_date)->diffForHumans() ?? '-' }}({{ $appointment->student_date }})</span>
                    </p>
                    <p class="small border-top pt-2">Phone: {{ $appointment->student->phone }}, Email:
                        {{ $appointment->student->email }}</p>
                </div>
            </div>

            <hr class="my-3">

            <div class="card">
                <div class="card-header text-capitalize">
                    <p class="h3 font-weight-bold">Accept request</p>
                </div>
                <div class="card-body">
                    <form action="/counselling-request-accepted" method="post">
                        @csrf
                        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                        {{-- counselor_note --}}
                        <div class="form-group row">
                            <label for="counselor_note" class="col-md-12 col-form-label">Enter your note</label>
                            <div class="col-md-12">
                                <textarea id="counselor_note" name="counselor_note" class="editor" rows="10"
                                    value="{{ old('counselor_note') ?? $appointment->counselor_note }}"></textarea>
                                @error('counselor_note')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        {{-- metting_id --}}
                        <div class="form-group row">
                            <label for="metting_id" class="col-md-12 col-form-label">Enter Metting Id</label>
                            <div class="col-md-12">
                                <input id="metting_id" name="metting_id" placeholder="Enter Metting Id"
                                    class="form-control  @error('metting_id') is-invalid @enderror" type="text"
                                    value="{!! old('metting_id') ?? $appointment->metting_id !!}">
                                @error('metting_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        {{-- metting_passcode --}}
                        <div class="form-group row">
                            <label for="metting_passcode" class="col-md-12 col-form-label">Enter Metting
                                Passcode</label>
                            <div class="col-md-12">
                                <input id="metting_passcode" name="metting_passcode"
                                    placeholder="Enter Metting Passcode"
                                    class="form-control  @error('metting_passcode') is-invalid @enderror" type="text"
                                    value="{!! old('metting_passcode') ?? $appointment->metting_passcode !!}">
                                @error('metting_passcode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        {{-- metting_time_date --}}
                        <div class="form-group row">
                            <label for="metting_time_date" class="col-md-12 col-form-label">Specific date you
                                want</label>
                            <div class="col-md-12">
                                <input id="metting_time_date" name="metting_time_date"
                                    placeholder="Enter your specific available date"
                                    class="form-control  @error('metting_time_date') is-invalid @enderror" type="date"
                                    value="{!! old('metting_time_date') ?? $appointment->metting_time_date !!}">
                                @error('metting_time_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button name="submit" type="submit" class="btn btn-success btn-md">Update Request</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
