

    <nav class="navbar navbar-expand-lg">
        
        <div class="container-fluid">
            <ul class="nav justify-content-start">
                <button class="btn" id="button-toggle">
                    <i class="fa-solid fa-equals" style="color:white"></i>
                </button>
                <a href='/' class='navbar-brand text-light'>
                    <img src="{{ asset('storage/' . $company->logo) }}" class="navbar-logo" alt="logo" style="width: 50px">
                    <b>{{ $company->name }}</b>
                </a>
            </ul>
            
            <ul class="nav justify-content-end ">
                @auth
                <div class="profile-dropdown">
                    <div onclick="toggle()" class="profile-dropdown-btn text-light">
                        <span>
                            {{ auth()->user()->name }}
                            <i class="fa-solid fa-angle-down"></i>
                        </span>
                    </div>

                    <ul class="profile-dropdown-list">
                        <li class="profile-dropdown-list-item">
                            <a href="/profile">
                                <i class="fa-regular fa-user"></i>
                                Profile
                            </a>
                        </li>

                        <li class="profile-dropdown-list-item">
                            <a href="#">
                                <i class="fa-regular fa-bell"></i>
                                Notification
                            </a>
                        </li>
                        <hr />
                        <li class="profile-dropdown-list-item">
                            <a href="/logout">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                Log out
                            </a>
                        </li>
                    </ul>
                </div>
                @else
                    <li class='nav-item'><a href="/login" class="guest">Login</a></li>
                @endauth
            </ul>
        </div>
    </nav>
