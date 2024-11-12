@extends('layouts.main')

@section('body')
<style>
    a {
        color: white;
        text-decoration: none;
    }
    a:hover {
        color: #e75e8d;
    }
    .button {
        background-color: #e75e8d;
        border: none;
        border-radius: 20px;
        padding: 5px 15px;
        color: white;
    }
</style>
    <div class="container">
        @if (session('success'))
            <script>
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "{{ session('error') }}",
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        @endif
        <div class="containbg my-3 p-4 text-white">
            <h3 class="text-center">Contact Us</h3>
            <p class="text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia tenetur, expedita
                cumque voluptates soluta unde porro sunt, nisi alias assumenda placeat culpa, sapiente impedit facere
                iste! Dolor saepe quibusdam quidem.</p>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="row">
                        <div class="col-md-2 col-3">
                            <span class="iconify" data-icon="ic:sharp-whatsapp" data-inline="false"
                                style="font-size: 70px; color:white;"></span>
                        </div>
                        <div class="col-md-10 col-9">
                            <a href="https://api.whatsapp.com/send/?phone={{ $company->wa }}&text&type=phone_number&app_absent=0">
                                <p>Whatsapp</p>
                            </a>
                            <p>+{{ $company->wa }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-3">
                            <span class="iconify" data-icon="mdi:instagram" data-inline="false"
                                style="font-size: 70px; color:white;"></span>
                        </div>
                        <div class="col-md-10 col-9">
                            <a href="https://www.instagram.com/{{ $company->ig }}">
                                <p>Instagram</p>
                            </a>
                            <p>{{ $company->ig }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-3">
                            <span class="iconify" data-icon="ic:baseline-email" data-inline="false"
                                style="font-size: 70px; color:white;"></span>
                        </div>
                        <div class="col-md-10 col-9">
                            <a href="">
                                <p>Email</p>
                            </a>
                            <p>{{ $company->email }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <form action="{{ route('contact.message') }}" method="POST" class="text-black" id="form-message" enctype="multipart/form-data" style="display: inline;">
                        @csrf
                        <h4 class="text-white">Send Message</h4>
                        @if (Auth::check())
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="subject">
                                <label for="subject">Subject</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea name="message" id="message" class="form-control" placeholder="Pesan anda"
                                    style="height:250px"></textarea>
                                <label for="message">Pesan anda</label>
                            </div>
                            <input type="hidden" id="name" value="{{ Auth::user()->name }}">
                            <input type="hidden" id="email" value="{{ Auth::user()->email }}">
                        @else
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Nama Lengkap">
                                <label for="name">Nama Lengkap</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                <label for="email">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="subject">
                                <label for="subject">Subject</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea name="message" id="message" class="form-control" placeholder="Pesan anda"
                                    style="height:250px"></textarea>
                                <label for="message">Pesan anda</label>
                            </div>
                        @endif
                        <div class="d-flex justify-content-end">
                            <button class="button" type="button" onclick="sendMessage()">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if (Auth::check() && $activities->isNotEmpty())
            <div class="containbg my-3 p-4 text-white">
                <h3 class="text-center mb-3">Aktivitas kamu</h3>
                <table class="table table-hover table-dark" id="table">
                    <thead>
                        <tr class="align-self-center">
                            <th scope="col">id</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Pesan</th>
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
                                <td>{{ $activity->message }}</td>
                                <td>{{ $activity->created_at }}</td>
                                <td>{{ $activity->status }}</td>
                                <td>
                                    <a href="/contact/{{ $activity->request_id }}" class="btn btn-primary">Read</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        
    </div>
@endsection

@section('footer')
    <script>
        function sendMessage(){
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const subject = document.getElementById('subject').value;
            const message = document.querySelector('textarea[name="message"]').value;
            Swal.fire({
                title: "Konfirmasikan Pesan Anda",
                html: `
                <table class="table text-start">
                    <tr>
                        <td>Nama Lengkap</td>
                        <td>${name}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>${email}</td>
                    </tr>
                    <tr>
                        <td>Subject</td>
                        <td>${subject}</td>
                    </tr>
                    <tr>
                        <td>Pesan</td>
                        <td>${message}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Pastikan data yang anda kirimkan sudah benar</td>
                    </tr>
                </table>`,
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Lanjutkan",
                denyButtonText: `Batalkan`,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika dikonfirmasi, submit form
                    document.getElementById('form-message').submit();
                } else if (result.isDenied) {
                    Swal.fire("Pesan dibatalkan", "", "info");
                }
            });
        }
    </script>
    @include('partials.footer')
@endsection