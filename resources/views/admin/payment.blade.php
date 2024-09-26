@extends('layouts.main')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('navbar')
    @include('partials.navbaradmin')
@endsection

@section('body')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css">
<div class="container-fluid">
    <div class="containadmin p-4">
        <div class="row">
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
                                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" onchange="confirmSwitchChange(event)">
                                                <label class="form-check-label" for="flexSwitchCheckDefault" id="switchLabel">Unavailable</label>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning"><i class="fa-regular fa-pen-to-square"></i> Edit</button>
                                            <button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="button" class="tombol">
            <i class="fa-solid fa-plus"></i> Add more method
            </button>
        </div>
    </div>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmSwitchChange(event) {
        event.preventDefault();
        const switchInput = event.target;
        const label = document.getElementById('switchLabel');

        Swal.fire({
            title: "Do you want to save the changes?",
            showDenyButton: true,
            toast: true,
            preDeny : false,
            confirmButtonText: "Save",
            denyButtonText: `Don't save`
        }).then((result) => {
            if (result.isConfirmed) {
                // Change the label and state of the switch
                label.textContent = switchInput.checked ? 'Available' : 'Unavailable';
                Swal.fire("Saved!", "", "success");
            } else if (result.isDenied) {
                // Reset the switch to its previous state
                switchInput.checked = !switchInput.checked;
                label.textContent = switchInput.checked ? 'Available' : 'Unavailable';
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    }
</script>
@section('footer')
    @include('partials.adminfooter')
@endsection