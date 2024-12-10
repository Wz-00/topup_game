@extends('layouts.main')

@section('body')
<style>
    img {
        aspect-ratio: 1/1;
        object-fit:cover;
    }
</style>
    <div class="container">
        <div class="containbg my-3 p-4 text-white">
            <b>#{{ $activity->request_id }}</b>
            <h3 class="my-3">{{ $activity->subject }}</h3>
            <div class="card">
                <div class="card-body">
                    <div class="head mb-4">
                        <div class="row">
                            @php
                                $avatar = auth()->user()->avatar;
                            @endphp 
                            <div class="col-xl-1 col-md-2 col-sm-3 col-3">
                                <img src="{{ auth()->user()->avatar === null ? '/asset/img/person-icon.png' : asset('storage/' . $avatar) }}" alt="" height="60" class="rounded-circle">
                            </div>
                            <div class="col">
                                <p>{{ $activity->name }} </p>
                                <p>{{ $elapsedTime }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="badan">
                        <p>{{ $activity->message }}</p>
                    </div>
                </div>
            </div>
            @if ($activity->status === 'Solved')
                <div class="card my-3">
                    <div class="card-body">
                        <div class="head mb-4">
                            <div class="row">
                                <div class="col-xl-1 col-md-2 col-sm-3 col-3">
                                    <img src="/asset/img/person-icon.png" alt="" height="60" class="rounded-circle">
                                </div>
                                <div class="col">
                                    <p>Admin</p>
                                    <p>{{ $adminElapsedTime }}</p>
                                </div>
                            </div>
                            
                        </div>
                        <div class="badan">
                            <p>{{ $reply }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection