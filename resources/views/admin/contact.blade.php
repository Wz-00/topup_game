@extends('layouts.main')
@section('body')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css">
    <div class="container">
        <div class="containadmin my-3 p-4 text-white">
            <h3 class="text-center mb-3">Messages</h3>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title pb-3 mt-0">Messages</h4>
                            <table class="table table-hover table-dark" id="example">
                                <thead>
                                    <tr class="align-self-center">
                                        <th scope="col">id</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Dibuat</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activities as $activity)
                                    <tr>
                                        <td>{{ $activity->request_id }}</td>
                                        <td>{{ $activity->subject }}</td>
                                        <td>{{ $activity->created_at }}</td>
                                        <td>{{ $activity->status }}</td>
                                        <td>
                                            @if ($activity->status === 'unread')
                                                <form action="{{ route('update.status.message', $activity->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">Read</button>
                                                </form>
                                            @else
                                                <a href="/contact/{{ $activity->request_id }}" class="btn btn-primary">Read</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    @include('partials.adminfooter')
@endsection