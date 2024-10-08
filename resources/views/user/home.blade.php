@extends('layouts.main')

@section('body')
<div class="container my-4 p-4 containbg">
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
    <div class="banner">        
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($banners as $key => $banner)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <a href="{{ $banner->game->slug }}">
                            <img src="{{ asset('storage/' . $banner['banner']) }}"  class="d-block w-100">
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="carousel-indicators">
                @foreach($banners as $key => $banner)
                    <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></button>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div class="content">
        <h1 style="font-size:4vw;font-family: fantasy; text-align: center;">Pick Your Game</h1>
        <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-5">
            @foreach ($games as $game)
                <div class="col">
                    <div class="detail my-3 mx-3 pb-4">
                        <a href="{{ $game['slug'] }}">
                            <img src="{{ asset('storage/' . $game->image) }}" class="card-img-top p-2"  style="height: 200px; object-fit:cover;">
                            <h5>
                                {{ $game->game }}
                            </h5>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('footer')
    <link rel="stylesheet" href="/css/footer.css">
    @include('partials.footer')
@endsection