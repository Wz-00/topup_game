<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a href='/' class='navbar-brand text-light'>
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Laravel.svg/1969px-Laravel.svg.png" class="navbar-logo" alt="logo" style="width: 50px">
            <b>Your Company</b>
        </a>
        <ul class="nav justify-content-end ">
            <li class="nav-item "><a href="/" class="nav-link {{ ($title === "Home" ? 'recolor' : '') }}" id="link1">Home</a></li>
            <li class="nav-item">
                <a href="/cari-pesanan" class="nav-link {{ ($title === 'Cek Pesanan' ? 'recolor' : '') }}" id="link1">Cek Pesanan</a>
            </li>
            <li class='nav-item'><a href="/login" class="guest">Login</a></li>
        </ul>
    </div>
</nav>