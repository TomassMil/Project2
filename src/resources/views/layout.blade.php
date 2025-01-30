<!doctype html>
<html lang="lv">
    <head>
    <meta charset="utf-8">
        <title>Project 2 - {{ $title }}</title>
        <meta name="description" content="Web Technologies Project 2">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap 5 -->
        <link 
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
            rel="stylesheet" 
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
            crossorigin="anonymous">
    </head>

    <body class="d-flex flex-column min-vh-100">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="/">Project 2</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @if(Auth::check())
                            <li class="nav-item">
                                <a class="nav-link" href="/authors">Authors</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/books">Books</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/categories">Categories</a>
                            </li>

                            <!-- LOG OUT -->
                            <li class="nav-item">
                                <a class="nav-link text-danger fw-bold" href="/logout">Log out</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link text-white" href="/login">Authenticate</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        
       <!-- Main Content -->
        <main class="container flex-grow-1 py-4">
            <div class="text-muted mb-3">Toms Millers, VeA, 2025-01</div>
            <div class="row">
                <div class="col">
                    @yield('content')
                </div>
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="bg-dark text-light py-3 mt-4">
            <div class="container text-center">
                <small>&copy; T. Millers, 2025</small>
            </div>
        </footer>

        <!-- Bootstrap & Custom Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="/js/admin.js"></script>    
    </body>
</html>
