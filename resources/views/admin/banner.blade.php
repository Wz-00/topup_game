@extends('layouts.main')

@section('body')
    <style>
        .kartu {
            border-radius: 10px;
            background-color: #27292a;
            color: white;
        }
        .col img {
            width: 100%;
            max-width: 280px;
        }
        .row .button, .d-flex .button  {
            background-color: #e75e8d;
            border: none;
            border-radius: 15px;
            padding: 5px 15px;
            color: white;
            font-family: fantasy;
        }
        .containadmin h4{
            font-family: fantasy;
            font-size: 40px;
            text-align: center;
        }
        .close-btn {
            display: inline-block;
            position: relative;
            color: red;
            background-color: transparent;
            border: none;
            top: -17px;
            left: 25px;
            font-size: 25px;
        }
        .close-btn:hover{
            color: white;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css">
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
        {{-- Banner --}}
        <div class="containadmin p-4 my-4">
            <h4>Banner</h4>
            <form onsubmit="confirmSubmit(event)" action="{{ route('banner.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="banner-container" class="row">
                    @foreach ($banners as $index => $banner)
                    <div class="col-xl-6 col-md-12 mb-3 banner-card">
                        <div class="kartu px-3 pb-3">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="close-btn" onclick="removeCard(this)"><i class="fa-regular fa-circle-xmark"></i></button>
                            </div>
                            <div class="row row-cols-sm-1 row-cols-md-2 d-flex align-items-center">
                                <div class="col">
                                    <img id="preview_banner_{{ $index }}" src="{{ asset('storage/' . $banner->banner) }}" alt="No Image" style="max-width: 100%;">
                                    <input type="file" id="banner_img_{{ $index }}" name="banner_img_{{ $index }}" accept="image/*" style="display:none;" onchange="previewImage(this, 'preview_banner_{{ $index }}')">
                                </div>
                                <div class="col">
                                    <select name="game_{{ $index }}" id="game_{{ $index }}" class="form-control mb-3">
                                        <option value="" disabled>Pilih Game</option>
                                        @foreach ($games as $game)
                                            <option value="{{ $game->id }}" {{ $game->id == $banner->game_id ? 'selected' : '' }}>{{ $game->game }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="button" onclick="document.getElementById('banner_img_{{ $index }}').click();">Select Image</button>
                                </div>
                            </div>
                            <input type="hidden" name="banner_id_{{ $index }}" value="{{ $banner->id }}">
                        </div>
                    </div>
                    @endforeach
                </div>
            
                <input type="hidden" name="deleted_banners" id="deleted_banners" value="">
                <input type="hidden" name="new_banner_count" id="new_banner_count" value="0">
                <div class="d-flex justify-content-evenly">
                    <button class="button" type="button" onclick="addMoreBanner()">Add More Banner</button>
                    <button type="submit" class="button">
                        <i class="fa-solid fa-floppy-disk"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
        {{-- Discount --}}
        <div class="containadmin p-4 my-3">
            <h4>Discount</h4>
            <table class="table table-hover table-dark" id="example">
                <thead>
                    <tr class="align-self-center">
                        <th scope="col">Game</th>
                        <th scope="col">Item</th>
                        <th scope="col">Price</th>
                        <th scope="col">Discount</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->game->game }}</td>
                            <td>{{ $item->item }}</td>
                            <td>{{ $item->price }}</td>
                            <td>
                                @if ($item->discount === null)
                                    0
                                @else
                                    {{ $item->discount }}%
                                @endif
                            </td>
                            <td class="text-center">
                                <!-- Form untuk set diskon -->
                                <form action="{{ route('items.setDiscount', $item->id) }}" method="POST" id="set-discount-form-{{ $item->id }}" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="discount" id="discount-input-{{ $item->id }}">
                                    <button type="button" class="btn btn-primary" onclick="setDiscount({{ $item->id }})">Set Discount</button>
                                </form>

                                <!-- Form untuk remove diskon -->
                                <form action="{{ route('items.removeDiscount', $item->id) }}" method="POST" id="remove-discount-form-{{ $item->id }}" style="display: inline;">
                                    @csrf
                                    @method('POST') <!-- Menggunakan POST, tetapi proses sebagai penghapusan diskon -->
                                    <input type="hidden" name="remove_discount" value="1">
                                    <button type="button" class="btn btn-warning" onclick="removeDiscount({{ $item->id }})">Remove Discount</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- Bonus Coins --}}
        <div class="containadmin p-4 my-3">
            <h4>Bonus Coins</h4>
            <table class="table table-hover table-dark" id="example1">
                <thead>
                    <tr class="align-self-center">
                        <th scope="col">Game</th>
                        <th scope="col">Item</th>
                        <th scope="col">Price</th>
                        <th scope="col">Coins</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->game->game }}</td>
                            <td>{{ $item->item }}</td>
                            <td>{{ $item->price }}</td>
                            <td>
                                @if ($item->coins === null)
                                    0
                                @else
                                    {{ $item->coins }}
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('items.setCoins', $item->id) }}" method="POST" id="set-coins-{{ $item->id }}">
                                    @csrf
                                    <input type="hidden" name="coins" id="coins-input-{{ $item->id }}">
                                    <button type="button" class="btn btn-primary" onclick="setCoins({{ $item->id }})">Set Coin</button>
                                </form>
                                <form action="{{ route('items.deleteCoins', $item->id) }}" method="POST" id="remove-coins-{{ $item->id }}">
                                    @csrf
                                    <input type="hidden" name="remove_coins" value="1">
                                    <button type="button" class="btn btn-warning" onclick="removeCoins({{ $item->id }})">Remove Coins</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>    
@endsection

@section('footer')
    @include('partials.adminfooter')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Function to preview the selected image
        function removeCard(button) {
            const card = button.closest('.banner-card');
            const bannerId = card.querySelector('input[name^="banner_id_"]').value;

            const deletedBanners = document.getElementById('deleted_banners');
            deletedBanners.value += (deletedBanners.value ? ',' : '') + bannerId;

            card.remove();
            checkCloseButtonVisibility();
        }

        function addMoreBanner() {
            const bannerContainer = document.getElementById('banner-container');
            const bannerCount = document.querySelectorAll('.banner-card').length;
            const newBannerCountInput = document.getElementById('new_banner_count');

            const newBannerCount = parseInt(newBannerCountInput.value) + 1; // Tambahkan jumlah banner baru
            newBannerCountInput.value = newBannerCount;

            const newCardHTML = `
                <div class="col-xl-6 col-md-12 mb-3 banner-card">
                    <div class="kartu px-3 pb-3">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="close-btn" onclick="removeCard(this)"><i class="fa-regular fa-circle-xmark"></i></button>
                        </div>
                        <div class="row row-cols-sm-1 row-cols-md-2 d-flex align-items-center">
                            <div class="col">
                                <img id="preview_banner_new_${newBannerCount}" src="" alt="No Image" style="max-width: 100%;">
                                <input type="file" id="new_banner_img_${newBannerCount}" name="new_banner_img_${newBannerCount}" accept="image/*" style="display:none;" onchange="previewImage(this, 'preview_banner_new_${newBannerCount}')">
                            </div>
                            <div class="col">
                                <select name="new_game_${newBannerCount}" id="new_game_${newBannerCount}" class="form-control mb-3">
                                    <option value="" selected disabled>Pilih Game</option>
                                    @foreach ($games as $game)
                                        <option value="{{ $game->id }}">{{ $game->game }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="button" onclick="document.getElementById('new_banner_img_${newBannerCount}').click();">Select Image</button>
                                <input type="hidden" name="banner_id_{{ $index }}" value="{{ $banner->id }}">
                            </div>
                        </div>
                    </div>
                </div>
            `;

            bannerContainer.insertAdjacentHTML('beforeend', newCardHTML);
        }

        function previewImage(input, previewId) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }
        function confirmSubmit(event) {
            // Prevent form from submitting immediately
            event.preventDefault();

            // Use SweetAlert2 to show confirmation modal
            Swal.fire({
                title: "Do you want to save the changes?",
                showDenyButton: true,
                confirmButtonText: "Save",
                denyButtonText: `Don't save`
            }).then((result) => {
                // Check if user confirmed the action
                if (result.isConfirmed) {
                    // Show success message and submit form
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Your work has been saved",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    // Submit the form after confirmation
                    event.target.submit();
                } else if (result.isDenied) {
                    // Show info that changes are not saved
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        }

        // Function to ensure close button is hidden if only one card remains
        function checkCloseButtonVisibility(itemId) {
            const cards = document.querySelectorAll('.banner-card'); // Select all cards
            cards.forEach(card => {
                const closeButton = card.querySelector('.close-btn');
                if (cards.length === 1) {
                    closeButton.style.display = 'none'; // Hide close button if only one card is left
                } else {
                    closeButton.style.display = 'block'; // Show close button if more than one card
                }
            });
        }

        function setDiscount(itemId) {
            Swal.fire({
                title: "Set Discount",
                icon: "question",
                input: "number",
                inputLabel: "Enter discount percentage",
                inputPlaceholder: "0-100",
                inputAttributes: {
                    min: 0,
                    max: 100,
                    step: 1
                },
                showCancelButton: true,
                confirmButtonText: "Save",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    let discountValue = result.value || 0;

                    // Set nilai diskon di input form
                    document.getElementById('discount-input-' + itemId).value = discountValue;

                    // Submit form untuk set diskon
                    document.getElementById('set-discount-form-' + itemId).submit();
                }
            });
        }

        // Konfirmasi dan remove diskon
        function removeDiscount(itemId) {
            Swal.fire({
                title: "Are you sure?",
                text: "This will remove the discount.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, remove it!",
                cancelButtonText: "Cancel",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form untuk remove diskon
                    document.getElementById('remove-discount-form-' + itemId).submit();
                }
            });
        }

        function setCoins(itemId) {
            Swal.fire({
                title: "Set Coins Bonus",
                icon: "question",
                input: "number",
                inputLabel: "Enter Coins",
                inputPlaceholder: "0-1000",
                inputAttributes: {
                    min: 0,
                    max: 1000,
                    step: 1
                },
                showCancelButton: true,
                confirmButtonText: "Save",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    let coinsValue = result.value || 0;

                    // Set nilai diskon di input form
                    document.getElementById('coins-input-' + itemId).value = coinsValue;

                    // Submit form untuk set diskon
                    document.getElementById('set-coins-' + itemId).submit();
                }
            });
        }
        function removeCoins(itemId) {
            Swal.fire({
                title: "Are you sure?",
                text: "This will remove the Coins.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, remove it!",
                cancelButtonText: "Cancel",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form untuk remove diskon
                    document.getElementById('remove-coins-' + itemId).submit();
                }
            });
        }
        
        // Call the check visibility function on page load to handle the initial state
        document.addEventListener('DOMContentLoaded', function() {
            checkCloseButtonVisibility();
        });
        </script>
@endsection