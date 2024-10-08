<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopUp Store | {{ $title }}</title>
    <link rel="stylesheet" href="/asset/css/header.css">
    <link rel="stylesheet" href="/asset/css/body.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .mySlides {
            display: none;
            padding-top: 20px;
        }

        .w3-left,
        .w3-right,
        .w3-badge {
            cursor: pointer
        }

        .w3-badge {
            height: 13px;
            width: 13px;
            padding: 0
        }

        body {
            background-color: #1f2122;
        }

        .row {
            padding-bottom: 10px;
        }


        .w3-display-container {
            padding-top: 10vh;
        }

        .w3-container {
            display: grid;
            grid-template-columns: auto auto auto auto;
            padding: 10px 0;
        }

        /* .mySlides {display:none; padding-top:20px;}
        .w3-left, .w3-right, .w3-badge {cursor:pointer}
        .w3-badge {height:13px;width:13px;padding:0}
        body {
                background-color: #363062;
            }
        .row {
            padding-bottom: 10px;
        }
        .waves {
            display: grid;
            grid-template-columns: auto;
            top: 0;
            left: 0;
            z-index: -1;
        }
        .w3-container {
            display: grid;
            grid-template-columns: auto auto auto auto;
            padding: 10px 0;
        }

        .footer{
            background-color: #F5E8C7;
        }
        .fkiri img {
            height: 90px;
        } */
        .footer {
            padding: 0;
            margin: 0;
        }
    </style>
</head>

<body>
    @if(Auth::check())
        @if(Auth::user()->role === 'admin')
            <style>
                body {
                background-color: #27292a;
                }
            </style>
        @else
            <style>
                body {
                background-color: #1f2122;
                }
            </style>
        @endif
    @else
        <style>
            body {
            background-color: #1f2122;
            }
        </style>
    @endif
    @if (Auth::check())
        @include('partials.sidebar')
    @endif
    <div class="active-main-content" id="main-content">
        @include('partials.navbar')
        <script>
            // dropdown profile
            let profileDropdownList = document.querySelector(".profile-dropdown-list");
            let btn = document.querySelector(".profile-dropdown-btn");

            let classList = profileDropdownList.classList;

            const toggle = () => classList.toggle("active");

            window.addEventListener("click", function(e) {
                if (!btn.contains(e.target)) classList.remove("active");
            });
        </script>
        <div class="active-container" id="main-container">
            @yield('body')
        </div>
        <footer>
            @yield('footer')
        </footer>
    </div>
</body>
</html>