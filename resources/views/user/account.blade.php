@extends('layouts.main')

@section('body')
<style>
    .left-side{
        background-color: #27292a;
    }
    .col-4 img{
        width: 100%;
        aspect-ratio: 1/1;
        object-fit:cover;
    }
    .button {
        display: inline-block;
        position: relative;
        background-color: #e75e8d;
        border: none;
        border-radius: 15px;
        padding: 5px 15px;
        color: white;
    }
    .btntext {
        border: none;
        background-color: #27292a;
        color: red;
        font-size: 16px;
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
        <div class="containbg p-4 my-4">
            <form action="{{ route('update.user.info', $user->id) }}" method="POST" enctype="multipart/form-data" id="update-user-info-{{ $user->id }}">
                @csrf
                <h3 class="mb-5">Profile Settings</h3>
                <div class="row">
                    <div class="col-4">
                        <img src="{{ $user->avatar === null ? 'asset/img/person-icon.png' : asset('storage/' . $user->avatar) }}" alt="" id="preview_logo_image">
                        <input type="file" id="preview_logo" name="avatar" accept="image/*" style="display:none;" onchange="previewImage('preview_logo', 'preview_logo_image')">
                        <div class="d-flex justify-content-center my-3">
                            <button class="button" type="button" id="preview_logo_button">Select Avatar</button>
                        </div>
                    </div>
                    <div class="col-8 text-black my-auto">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Nama Lengkap" value="{{ $user->name }}">
                            <label for="name">Nama Lengkap</label>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" placeholder="Username" value="{{ $user->username }}">
                            <label for="username">Username</label>
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="wa" id="wa" placeholder="No. Whatsapp" value="{{ $user->Wa }}">
                            <label for="wa">No. Whatsapp</label>
                        </div>
                        <div class="d-flex justify-content-end my-3">
                            <button type="button" class="button" onclick="confirmChanges({{ $user->id }})">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="containbg p-4 my-4">
            <form action="{{ route('update.user.info', $user->id) }}" method="POST" id="update-user-password">
                @csrf
                <h3 class="mb-5 text-white">Ubah Password</h3>
                    <span style="font-size: 1.2rem; font-weight: bold;">Password saat ini</span>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="old_password" id="oldpassword" placeholder="Password Lama">
                        <label for="oldpassword" class="text-black">Password Lama</label>
                    </div>
                    <span style="font-size: 1.2rem; font-weight: bold;">Password baru</span>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Password Baru">
                        <label for="new_password" class="text-black">Password Baru</label>
                    </div>
                    <span style="font-size: 1.2rem; font-weight: bold;">Konfirmasi password baru</span>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation" placeholder="Konfirmasi Password Baru">
                        <label for="new_password_confirmation" class="text-black">Konfirmasi Password Baru</label>
                    </div>
                    <div class="d-flex justify-content-end my-3">
                        <button type="button" class="button" style="bottom: -50px" onclick="confirmPasswordChanges()">Simpan Perubahan</button>
                    </div>
            </form>
        </div>
        <div class="containbg p-4 my-4">
            <h3>Hapus Akun</h3>
            <p>Dengan menghapus akun Anda, semua informasi akan hilang. Proses tidak dapat dibatalkan.</p>
            <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: inline;" id="delete-form-{{ $user->id }}">
                @csrf
                @method('DELETE')
                <button class="btntext" type="button" onclick="confirmDelete({{ $user->id }})">
                    Hapus akun saya <span class="iconify" data-icon="iconoir:trash" data-inline="false"></span>
                </button>
            </form>
        </div>
    </div>
@endsection

@section('footer')
<script>
    function confirmChanges(id){
        Swal.fire({
            title: "Simpan informasi perubahan?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Save",
            denyButtonText: `Don't save`
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                document.getElementById('update-user-info-' + id).submit();
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    }
    function confirmPasswordChanges(){
        Swal.fire({
            title: "Simpan perubahan password?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Save",
            denyButtonText: `Don't save`
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                document.getElementById('update-user-password').submit();
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    }
    function confirmDelete(id){
        Swal.fire({
            title: "Apa kamu yakin ingin menghapus Akun-mu?",
            text: "Seluruh informasi yang kamu punya akan menghilang!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Hapus akun saya!",
            cancelButtonText: "Batal",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user mengonfirmasi, submit form
                document.getElementById('delete-form-' + id).submit();
            } else {
                Swal.fire("Dibatalkan", "Akun-mu Aman :).", "info");
            }
        });
    }
</script>
<script src="/asset/js/item.js"></script>   
    @include('partials.footer')
@endsection