@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($requests->count() > 0)
            @foreach ($requests as $appointment)
            {{-- {{ dd($appointment->student ) }} --}}
            <div class="card mb-3
                @if($appointment->request_status == 'refused') bg-danger text-medium @endif
                @if($appointment->request_status == 'accepted') bg-success text-white @endif
                @if($appointment->request_status == 'pending') bg-warning @endif
            ">
                <div class="card-header text-capitalize">
                    <div class="row p-0 m-0" style="overflow: hidden;">
                        <div class="col-md-6">
                            Counselling Status - <span
                                class="font-weight-bold">{{ $appointment->request_status }}</span>
                            <br>
                            <small>Sent {{ $appointment->created_at->diffForHumans() }}</small>
                        </div>

                        <div class="col-md-6 d-flex justify-content-between">
                            <form action="/counselling-requests" method="post">
                                @csrf
                                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                                <button name="submit" type="submit" class="btn btn-danger btn-sm">Refuse</button>
                            </form>
                            <div>
                                <a href="/counselling-requests/{{ $appointment->id }}" class="btn btn-info btn-sm">Show
                                    detail</a>
                            </div>
                        </div>
                    </div>
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
            @endforeach
            <div class="mt-2">
                {{ $requests->links() }}
            </div>
            @else
            <div class="alert alert-danger" role="alert">
                <p>There is no any requests yet!</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
