@extends('layouts.main')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('navbar')
    @include('partials.navbaradmin')
@endsection

@section('body')
<style>
    .close-btn {
        display: inline-block;
        position: relative;
        color: red;
        background-color: transparent;
        border: none;
        top: -15px;
        left: 15px;
        font-size: 25px;
    }
    .close-btn:hover{
        color: white;
    }
    .detail .button, .content .button  {
        display: inline-block;
        position: relative;
        background-color: #e75e8d;
        border: none;
        border-radius: 20px;
        padding: 5px 15px;
        color: white;
        font-size: 16px;
    }
</style>
<div class="container-fluid text-light">
    <div class="containadmin p-4">
        <form onsubmit="saveUpdate(event)" action="{{ url('/'.$game->slug.'/edit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h3 class="text-center mb-3 ">{{ $game->game }}</h3>
            <div class="grid" style="--bs-columns: 3;">
                <div class="g-col-3 g-col-md-1">
                    <div class="content">
                        <img id="preview_game" src="{{ asset('storage/' . $game->image) }}" alt="" class="img-fluid GameBanner">
                        <input type="file" id="game_image" name="game_image" accept="image/*" style="display:none;" onchange="previewImage('game_image', 'preview_game')">
                        <div class="d-flex justify-content-center">
                            <button type="button" id="game_image_button" class="button text-center text-light" style="top: -16px;">Select Image</button>
                        </div>
                        <div class="mb-3">
                            <label for="game_name">Nama Game</label>
                            <input type="text" id="game_name" name="game" value="{{ $game->game }}" class="form-control" placeholder="Nama Game">
                        </div>
                        
                    
                        <label for="deskripsi" class="mb-3">Deskripsi</label>
                        <textarea name="description" id="deskripsi" class="form-control" style="height: 315px;">{!! $game->description !!}</textarea>
                        
                    </div>
                </div>
                <div class="g-col-3 g-col-md-2 text-center">
                    <div class="item p-3">
                        <h3>ITEM</h3>
                        <div class="row row-cols-md-1 row-cols-lg-3" id="item-container">
                            @foreach ($item as $it)
                                <div class="col item-card">
                                    <div class="detail p-1 my-1">
                                        <div class="row">
                                            <div class="col d-flex justify-content-end">
                                                <button type="button" class="close-btn" onclick="removeItem(this)">
                                                    <i class="fa-regular fa-circle-xmark"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" name="item_id[]" value="{{ $it->id }}"> <!-- Hidden input for item ID -->

                                        <img src="{{ asset('storage/' . $it['icon']) }}" alt="" class="img-fluid mx-auto my-1" style="max-height: 50px;" id="preview_item_{{ $loop->index }}"><br>
                                        <input type="file" id="preview_icon_{{ $loop->index }}" name="item_image[]" accept="image/*" style="display:none;" onchange="previewImage('preview_icon_{{ $loop->index }}', 'preview_item_{{ $loop->index }}')">
                                        <button type="button" class="button text-center text-light" onclick="document.getElementById('preview_icon_{{ $loop->index }}').click();">Select Icon</button>
                                        
                                        <div class="row text-center">
                                            <div class="col">Item</div>
                                            <div class="col">Harga</div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-start form-floating">
                                                <input type="text" id="item_name_{{ $loop->index }}" name="item_name[]" value="{{ $it['item'] }}" style="width: 100%;" class="form-control mt-0 py-0">
                                            </div>
                                            <div class="col text-end form-floating">
                                                <input type="number" id="item_price_{{ $loop->index }}" name="item_price[]" value="{{ $it->price }}" style="width: 100%;" class="form-control py-0">
                                            </div>
                                        </div>
                                        <p class="text-center">Stock</p>
                                        <div class="form-floating">
                                            <input type="number" id="item_stock_{{ $loop->index }}" name="item_stock[]" value="{{ $it->stock }}" style="width: 100%" class="form-control py-0">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <input type="hidden" id="delete_item_ids" name="delete_item_ids">
                        </div>
                        <div class="text-center">
                            <button type="button" class="tombol" onclick="addMoreItem()"><i class="fa-solid fa-plus"></i> Tambah Item</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                <button class="tombol" type="submit"><i class="fa-regular fa-pen-to-square"></i>Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function saveUpdate(event){
            event.preventDefault();
            Swal.fire({
                title: "Do you want to save the changes?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Save",
                denyButtonText: `Don't save`
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire("Saved!", "", "success");
                    event.target.submit();
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        }
    </script>
    <script src="/asset/js/item.js"></script>
    @include('partials.adminfooter')
@endsection