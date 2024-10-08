@extends('layouts.main')

@section('body')
<link rel="stylesheet" href="/asset/css/modal.css">
<style>
    td .btn a{
        color: black;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css">
<div class="container-fluid">
    <div class="containadmin p-4 my-4">
        <div class="row">
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
            <div class="col-xl-12">
                <div class="card my-3">
                    <div class="card-body">
                        <h4 class="header-title pb-3 mt-0">Payment Method</h4>
                        <!-- Ambil dari database -->
                        <!-- jika status sukses, badge primary. jika status belum selesai, badge warning. jika status dibatalkan, badge danger -->
                        <table class="table table-hover table-dark" id="example">
                            <thead>
                                <tr class="align-self-center">
                                    <th scope="col">Method</th>
                                    <th scope="col">Number</th>
                                    <th scope="col">Logo</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->method }}</td>
                                        <td>{{ $payment->number }}</td>
                                        <td><img src="storage/{{ $payment->logo }}" class="payment mx-auto" alt=""></td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <!-- Switch akan checked jika status 'Available' -->
                                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault_{{ $payment->id }}" 
                                                onchange="confirmSwitchChange(event, {{ $payment->id }})" {{ $payment->status == 'Available' ? 'checked' : '' }}>
                                                
                                                <!-- Label akan sesuai dengan status dari database -->
                                                <label class="form-check-label" for="flexSwitchCheckDefault_{{ $payment->id }}" data-payment-id="{{ $payment->id }}">
                                                    {{ $payment->status == 'Available' ? 'Available' : 'Unavailable' }}
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($payment->id !== 1)
                                                <button class="btn btn-warning"><a href="/payment/{{ $payment->slug }}/edit"><i class="fa-regular fa-pen-to-square"></i> Edit</a></button>
                                                <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" id="delete-form-{{ $payment->id }}" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $payment->id }})">
                                                        <i class="fa-solid fa-trash-can"></i> Delete
                                                    </button>
                                                </form>
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
        <div class="modal fade" id="addPayment" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fa-solid fa-plus"></i> Add Payment Method</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('payment.upload') }}" id="uploadForm" class="container" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <table class="table table-striped bordered">
                                <!-- sesuaikan dengan button yang ditekan/ ambil dari database -->
                                <tr>
                                    <td>Payment name</td>
                                    <td><input type="text" placeholder="Nama method" name="method" id="method" value="{{ old('method') }}"></td>
                                </tr>
                                <tr>
                                    <td>Nomor Rekening</td>
                                    <td><input type="number" class="form-control" placeholder="Nomor rekening" name="rekening" id="rekening" value="{{ old('rekening') }}"></td>
                                </tr>
                                <tr>
                                    <td>Logo</td>
                                    <td><button class="select-image btn btn-primary">Select Image</button></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                    <input type="file" name='logo' id="image" accept="image/*" hidden required>
                                    <div class="img-area" data-img="">
                                        <i class='bx bxs-cloud-upload icon'></i>
                                        <h3>Upload Image</h3>
                                        <p>Image size must be less than <span>20MB</span></p>
                                    </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add</button>
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="button" class="tombol" data-bs-toggle="modal" data-bs-target="#addPayment">
                <i class="fa-solid fa-plus"></i> Add more method
            </button>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script src="/asset/js/modal.js"></script>
<script>
    function confirmSwitchChange(event, paymentId) {
        event.preventDefault();
        const switchInput = event.target;
        const row = switchInput.closest('tr'); // Ambil baris tempat switch berada
        const label = row.querySelector('label'); // Ambil label dalam baris tersebut

        Swal.fire({
            title: "Do you want to save the changes?",
            showDenyButton: true,
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText: "Save",
            denyButtonText: `Don't save`
        }).then((result) => {
            if (result.isConfirmed) {
                // Ubah teks label dan status switch
                label.textContent = switchInput.checked ? 'Available' : 'Unavailable';
                
                // Kirim data perubahan ke server menggunakan URL saat ini
                updatePaymentStatus(paymentId, switchInput.checked ? 'Available' : 'Unavailable');

                Swal.fire("Saved!", "", "success");
            } else if (result.isDenied) {
                // Kembalikan switch ke status sebelumnya
                switchInput.checked = !switchInput.checked;
                label.textContent = switchInput.checked ? 'Available' : 'Unavailable';
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    }

    function updatePaymentStatus(paymentId, status) {
        $.ajax({
            url: window.location.href, // Kirim ke URL yang sama (current page URL)
            method: 'POST', // Menggunakan metode POST
            data: {
                _token: '{{ csrf_token() }}', // Sertakan CSRF token untuk keamanan
                payment_id: paymentId,
                status: status
            },
            success: function(response) {
                console.log("Status updated successfully!");
            },
            error: function(xhr, status, error) {
                console.error("Error updating status:", error);
            }
        });
    }

    function confirmDelete(paymentId) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user mengonfirmasi, submit form
                document.getElementById('delete-form-' + paymentId).submit();
            } else {
                Swal.fire("Cancelled", "The payment is safe.", "info");
            }
        });
    }
</script>
    @include('partials.adminfooter')
@endsection