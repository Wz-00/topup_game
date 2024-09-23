@extends('layouts.main')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('navbar')
    @include('partials.navbaradmin')
@endsection

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
        <div class="containadmin p-4 mb-3">
            <h4>Banner</h4>
            <form action="">
                <div class="row" id="banner-container">
                    @foreach ($banners as $banner)
                        <div class="col-xl-6 col-md-12 mb-3 banner-card">
                            <div class="kartu px-3 pb-3">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="close-btn" onclick="removeCard(this)"><i class="fa-regular fa-circle-xmark"></i></button>
                                </div>
                                <div class="row row-cols-sm-1 row-cols-md-2 d-flex align-items-center">
                                    <div class="col">
                                        <img id="preview_banner_{{ $loop->index }}" src="{{ asset('storage/' . $banner->banner) }}" alt="Banner Image" style="max-width: 100%;">
                                        <input type="file" id="banner_img_{{ $loop->index }}" name="banner_img_{{ $loop->index }}" accept="image/*" style="display:none;" onchange="previewImage(this, 'preview_banner_{{ $loop->index }}')">
                                    </div>
                                    <div class="col">
                                        <select name="game" id="Game_{{ $loop->index }}" class="form-control mb-3">
                                            <option value="" selected disabled>Pilih Game</option>
                                            @foreach ($games as $game)
                                                <option value="{{ $game->game }}">{{ $game->game }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="button" onclick="document.getElementById('banner_img_{{ $loop->index }}').click();">Select Image</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-evenly">
                    <button type="button" class="button" id="add-more-btn" onclick="addMoreBanner()">
                        <i class="fa-solid fa-plus"></i> Add More Banner
                    </button>
                    <button type="button" class="button">
                        <i class="fa-solid fa-floppy-disk"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
        <div class="containadmin p-4">
            <h4>Discount</h4>
            <table class="table table-hover table-dark" id="example">
                <thead>
                    <tr class="align-self-center">
                        <th scope="col">Game</th>
                        <th scope="col">Item</th>
                        <th scope="col">Price</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->game->game }}</td>
                            <td>{{ $item->item }}</td>
                            <td>{{ $item->price }}</td>
                            <td>0</td>
                            <td class="text-center">
                                <button type="submit" class="btn btn-primary">Discount</button>
                                <button type="" class="btn btn-warning">Remove Discount</button>
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
    <script>
        // Function to preview the selected image
        function previewImage(input, previewId) {
            const file = input.files[0]; // Get the selected file
            if (file) {
                const reader = new FileReader(); // FileReader to read the file
                reader.onload = function (e) {
                    document.getElementById(previewId).src = e.target.result; // Change the image src to the selected file
                };
                reader.readAsDataURL(file); // Read the file as data URL
            }
        }
        
        // Function to add a new banner card
        function addMoreBanner() {
            const bannerContainer = document.getElementById('banner-container');
            const bannerCount = document.querySelectorAll('.banner-card').length; // Count current banners
            const newCardHTML = `
                <div class="col-xl-6 col-md-12 mb-3 banner-card">
                    <div class="kartu px-3 pb-3">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="close-btn" onclick="removeCard(this)"><i class="fa-regular fa-circle-xmark"></i></button>
                        </div>
                        <div class="row row-cols-sm-1 row-cols-md-2 d-flex align-items-center">
                            <div class="col">
                                <img id="preview_banner_${bannerCount}" src="" alt="No Image" style="max-width: 100%;">
                                <input type="file" id="banner_img_${bannerCount}" name="banner_img_${bannerCount}" accept="image/*" style="display:none;" onchange="previewImage(this, 'preview_banner_${bannerCount}')">
                            </div>
                            <div class="col">
                                <select name="game" id="Game_${bannerCount}" class="form-control mb-3">
                                    <option value="" selected disabled>Pilih Game</option>
                                    @foreach ($games as $game)
                                        <option value="{{ $game->game }}">{{ $game->game }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="button" onclick="document.getElementById('banner_img_${bannerCount}').click();">Select Image</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            // Insert new card inside the banner container before the add more button
            bannerContainer.insertAdjacentHTML('beforeend', newCardHTML); // Append new card
            checkCloseButtonVisibility(); // Check visibility of close buttons
        }
        
        // Function to remove a banner card
        function removeCard(button) {
            const card = button.closest('.banner-card'); // Find the closest parent card
            card.remove(); // Remove the card
            checkCloseButtonVisibility(); // Check visibility of close buttons
        }
        
        // Function to ensure close button is hidden if only one card remains
        function checkCloseButtonVisibility() {
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
        
        // Call the check visibility function on page load to handle the initial state
        document.addEventListener('DOMContentLoaded', function() {
            checkCloseButtonVisibility();
        });
        </script>
@endsection