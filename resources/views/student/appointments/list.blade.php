@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($appointments->count() > 0)
            @foreach ($appointments as $appointment)
            <div class="card mb-3
                @if($appointment->request_status == 'refused') bg-danger text-medium @endif
                @if($appointment->request_status == 'accepted') bg-success text-white @endif
                @if($appointment->request_status == 'pending') bg-warning @endif
            ">
                <div class="card-header text-capitalize">{{ $appointment->counselor->fname }} Counselling Status - <span
                        class="font-weight-bold">{{ $appointment->request_status }}</span></div>

                <div class="card-body pb-2">
                    @if ($appointment->request_status == 'accepted')
                    <div class="row" style="overflow-x: hidden;">
                        <div class="col-md-6">
                            <small>Counselor Specialty</small>
                            <p class="b">
                                @if (!empty($appointment->counselor->specialty->title))
                                <span class="font-weight-bold">{{ $appointment->counselor->specialty->title }}</span>
                                @else
                                <span class="font-weight-bold text-danger">This user counselor specialty is not stated
                                    yet!</span>
                                @endif
                            </p>
                            <small>Your Reason</small>
                            <p class="b">
                                <span class="font-weight-bold">{{ $appointment->student_reason ?? '-' }}</span>
                            </p>
                            <small>Counselling Date</small>
                            <p class="b">
                                <span
                                    class="font-weight-bold">{{ \Carbon\Carbon::parse($appointment->student_date)->diffForHumans() ?? '-' }}({{ $appointment->student_date }})</span>
                            </p>
                            <hr />
                            <p class="pb-0 mb-0">Request sent
                                {{ $appointment->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="col-md-6 bg-white text-dark pt-2 pb-1">
                            <p>
                                <button class="btn btn-link btn-sm" type="button" data-toggle="collapse"
                                    data-target="#collapseCounselorNote" aria-expanded="false"
                                    aria-controls="collapseCounselorNote">
                                    {{ $appointment->counselor->fname }}'s Note
                                </button>
                            </p>
                            <div class="collapse" id="collapseCounselorNote">
                                {!! $appointment->counselor_note !!}
                            </div>

                            <p class="b">Metting Id: <strong>{{$appointment->metting_id }}</strong></p>
                            <p class="b">Metting Passcode: <strong>{{$appointment->metting_passcode }}</strong></p>
                            <p class="b">Metting Time:
                                <strong>{{ \Carbon\Carbon::parse($appointment->metting_time_date)->diffForHumans() ?? 'error' }}</strong>
                            </p>
                            <div class="col-md-12 d-flex justify-content-center">
                                <a href="{{ env('ZOOM_URL') }}/index.html?mettingName={{ auth()->user()->fname }}&mettingId={{ $appointment->metting_id }}&mettingPassCode={{ $appointment->metting_passcode }}"
                                    target="_blank" rel="noopener noreferrer" class="btn btn-success btn-md">Join
                                    ZoomUs</a>

                            </div>
                        </div>
                    </div>
                    @else
                    <small>Counselor Specialty</small>
                    <p class="b">
                        @if (!empty($appointment->counselor->specialty->title))
                        <span class="font-weight-bold">{{ $appointment->counselor->specialty->title }}</span>
                        @else
                        <span class="font-weight-bold text-danger">This user counselor specialty is not stated
                            yet!</span>
                        @endif
                    </p>
                    <small>Your Reason</small>
                    <p class="b">
                        <span class="font-weight-bold">{{ $appointment->student_reason ?? '-' }}</span>
                    </p>
                    <small>Counselling Date</small>
                    <p class="b">
                        <span
                            class="font-weight-bold">{{ \Carbon\Carbon::parse($appointment->student_date)->diffForHumans() ?? '-' }}({{ $appointment->student_date }})</span>
                    </p>
                    <hr />
                    <p class="pb-0 mb-0">Request sent
                        {{ $appointment->created_at->diffForHumans() }}</p>
                    @endif
                </div>
            </div>
            @endforeach
            <div class="mt-2">
                {{ $appointments->links() }}
            </div>
            @else
            <div class="alert alert-danger" role="alert">
                <p class="pt-2 font-weight-bold">There is no any appointments yet!</p>
                <p class="lead">To add new appointment first send a <a href="/counselors"
                        class="btn btn-link btn-sm">Counselor
                        Request</a></p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
