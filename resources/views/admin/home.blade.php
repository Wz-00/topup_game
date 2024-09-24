@extends('layouts.main')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('navbar')
    @include('partials.navbaradmin')
@endsection

@section('body')
<link rel="stylesheet" href="/asset/css/modal.css">
@if (session()->has('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="container">
  <div class="row">
    <div class="col-xl-6 col-lg-6 my-2">
      <canvas id="myChart" height="400" aria-label="Hello ARIA World" role="img" style="background-color: white;"></canvas>
    </div>
    <div class="col-xl-6 col-lg-6 my-2">
      <div class="card p-3">
        <div class="card-body">
          <h4 class="card-title">Top Selling Product</h4>
          <ul class="list-group list-group-flush list-group-numbered">
            <li class="list-group-item">Valorant</li>
            <li class="list-group-item">Mobile Legend</li>
            <li class="list-group-item">PUBG</li>
            <li class="list-group-item">League of Legend</li>
            <li class="list-group-item">Genshin Impact</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container my-2 p-4 containadmin">
    <div class="row">
      <h4 class="text-center" style="color: white; font-family: fantasy;">Your Game</h4>
        @foreach ($games as $game)
        <div class="col-xl-6 col-lg-6 my-2">
            <div class="card">
              <div class="card-statistic-3 p-4">
                <div class="card-icon card-icon-large"><i class="fa-solid fa-gamepad"></i></div>
                <div class="mb-4">
                  <h5 class="card-title mb-0">{{ $game['game'] }}</h5>
                </div>
                <div class="row align-items-center mb-2 d-flex">
                  <div class="col-4">
                    <h2 class="d-flex align-items-center mb-0">
                      3,243
                    </h2>
                  </div>
                  <div class="col-2 text-right">
                    <span>12.5% <i class="fa fa-arrow-up"></i></span>
                  </div>
                  <div class="col-4">
                    <a href="/{{ $game->slug }}" class="btn btn-primary btn-md mr-2 float-end"><i class="fa-solid fa-circle-info"></i> Detail</a>
                  </div>
                </div>
                <div class="progress mt-1" data-height="8" style="height: 8px;">
                  <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 75%;"></div>
                </div>
              </div>
            </div>
          </div>
        @endforeach   
        
        <!-- modal Add game -->
        <div class="modal fade" id="addgame" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fa-solid fa-plus"></i> Add Game</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="/" id="uploadForm" class="container" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                  <table class="table table-striped bordered">
                    <!-- sesuaikan dengan button yang ditekan/ ambil dari database -->
                    <tr>
                      <td>Game :</td>
                      <td><input type="text" placeholder="Nama Game" name="game" id="game" value="{{ old('game') }}"></td>
                    </tr>
                    <tr>
                      <td>Description</td>
                      <td><textarea name="description" id="description" placeholder="Deskripsi" maxlength="500" value="{{ old('description') }}"></textarea></td>
                    </tr>
                    <tr>
                      <td>Image</td>
                      <td><button class="select-image btn btn-primary">Select Image</button></td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <input type="file" name='image' id="image" accept=".jpg" hidden required>
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

    </div>
    <div class="text-center">
      <button type="button" class="tombol" data-bs-toggle="modal" data-bs-target="#addgame">
        <i class="fa-solid fa-plus"></i> Add more game
      </button>
    </div>
</div>
@endsection
@section('footer')
    @include('partials.adminfooter')
@endsection