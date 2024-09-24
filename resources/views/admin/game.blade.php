@extends('layouts.main')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('navbar')
    @include('partials.navbaradmin')
@endsection

@section('body')
<div class="container my-4 p-4 containadmin">
    <h3 class="text-center mb-3">{{ $game->game }}</h3>
    <div class="grid" style="--bs-columns: 3;">
        <div class="g-col-3 g-col-md-1">
            <div class="content">
                <img src="{{ asset('storage/' . $game->image) }}" alt="" class="img-fluid GameBanner">
                <p class="p-3">{!! $game->description !!}</p>
            </div>
        </div>
        <div class="g-col-3 g-col-md-2 text-center">
            <div class="item p-3">
                <h3>ITEM</h3>
                <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                    @foreach ($item as $it)
                    <div class="col">
                        <div class="detail p-1 my-1">
                            <img src="{{ asset('storage/' .$it['icon']) }}" alt="" class="img-fluid mx-auto my-1" style="max-height: 50px;"><br>
                            <b>{{ $it['item'] }}</b>
                            <p>Rp. {{ number_format($it['price'], 2, ",", ".") }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <button class="tombol"><a href='/{{ $game->slug }}/edit'><i class="fa-regular fa-pen-to-square"></i>Edit This Game</a></button>
    </div>
</div>
@endsection
@section('footer')
    @include('partials.adminfooter')
@endsection