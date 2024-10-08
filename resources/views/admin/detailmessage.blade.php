@extends('layouts.main')
@section('body')
<style>
    .head {
        width: 25%;
    }
    .button {
        background-color: #e75e8d;
        border: none;
        border-radius: 20px;
        padding: 5px 15px;
        color: white;
        text-decoration: none;
    }
</style>
<div class="container">
    <div class="containadmin my-3 p-4 text-white">
        <b>#{{ $activity->request_id }}</b>
        <p class="my-3">{{ $activity->user_id === null ? 'User Unregistered' : 'User Registered' }}</p>
        <h3 class="my-3">{{ $activity->subject }}</h3>
        <div class="card">
            <div class="card-body">
                <div class="head mb-4">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ auth()->user()->avatar === null ? '/asset/img/person-icon.png' : asset('storage/' . $avatar) }}" alt="" height="60" class="rounded-circle">
                        </div>
                        <div class="col-9">
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
        <div class="d-flex justify-content-end my-3">
            @if ($activity->user_id !== null)
                @if ($activity->status !== 'Solved')
                    <button class="button" id="reply-btn">Reply Message</button>
                @endif
            @else
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $activity->email }}&su=Subject&body=Message" class="button">Send Email</a>
            @endif
        </div>
        @if ($activity->status === 'Solved')
            <div class="card">
                <div class="card-body">
                    <div class="head mb-4">
                        <div class="row">
                            <div class="col-3">
                                <img src="/asset/img/person-icon.png" alt="" height="60" class="rounded-circle">
                            </div>
                            <div class="col-9">
                                <p>Admin</p>
                                <p>{{ $adminElapsedTime }}</p>
                            </div>
                        </div>
                        <div class="badan">
                            <p>{{ $reply }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Div "reply" disembunyikan secara default -->
    <div class="containadmin my-3 p-4" id="reply" style="display: none;">
        <h3 class="my-3">Reply</h3>
        <form action="{{ route('reply.message', $activity->id) }}" method="POST" id="form-reply">
            @csrf
            <div class="form-floating mb-3 text-black">
                <textarea name="message" id="message" class="form-control" placeholder="Pesan anda" style="height:250px"></textarea>
                <label for="message">Pesan anda</label>
            </div>
            <div class="d-flex justify-content-end">
                <button class="button" type="button" onclick="sendMessage()">Send Reply</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('footer')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const replyDiv = document.getElementById("reply");
        const replyButton = document.getElementById("reply-btn");

        // Cek status activity
        const isSolved = "{{ $activity->status }}" === "Solved";

        if (!isSolved) {
            // Hanya jika status tidak 'Solved', event listener akan ditambahkan
            if (replyButton) {
                replyButton.addEventListener("click", function() {
                    replyDiv.style.display = "block"; // Tampilkan div "reply"
                });
            }
        } else {
            // Jika 'Solved', tetap sembunyikan div dan tidak biarkan terbuka
            replyDiv.style.display = "none";
        }
    });
    function sendMessage(){
        const message = document.querySelector('textarea[name="message"]').value;
        Swal.fire({
            title: "Konfirmasikan Pesan Anda",
            html: `
            <h3 class="text-start">Reply Message</h3>
            <hr>
            <p class="text-start">${message}</p>
            `,
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Lanjutkan",
            denyButtonText: `Batalkan`,
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika dikonfirmasi, submit form
                document.getElementById('form-reply').submit();
            } else if (result.isDenied) {
                Swal.fire("Pesan dibatalkan", "", "info");
            }
        });
    }
</script>
    @include('partials.adminfooter')
@endsection