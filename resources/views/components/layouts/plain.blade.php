<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @livewireStyles
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Cours en ligne - Inspire Academy' }}</title>

    <link rel="shortcut icon" href="{{ URL::to('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/css/style.css') }}">
    <style>
        body { background-color: #f8f9fc; }
        .navbar { box-shadow: 0 2px 6px rgba(0,0,0,0.05); }
        .user-avatar { width: 36px; height: 36px; border-radius: 50%; border: 1px solid #ddd; cursor: pointer; }
        .dropdown-menu { border-radius: 8px; border: 1px solid #eee; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
        footer { margin-top: 50px; text-align: center; font-size: 14px; color: #777; }
    </style>
</head>

<body>
    {{-- ✅ En-tête simplifiée --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 py-3 mb-4">
        <div class="d-flex justify-content-between align-items-center w-100">

            {{-- ✅ Inspire Academy cliquable (sans logo) --}}
            <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center text-decoration-none">
                <h5 class="m-0 fw-bold text-dark">Inspire Academy</h5>
            </a>


            <div class="d-flex align-items-center gap-3">
                {{-- ✅ Bouton plein écran --}}
                <button id="fullscreen-btn" class="btn btn-light border-0" title="Plein écran">
                    <i class="fas fa-expand text-secondary"></i>
                </button>

                {{-- ✅ Menu utilisateur avec Logout --}}
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle d-flex align-items-center" id="userMenu" data-bs-toggle="dropdown">
                        <img src="{{ Storage::url('student-photos/default.png') }}" alt="user" class="user-avatar">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

{{-- ✅ Titre principal avec lien de retour --}}
<div class="container mb-4">
    <div class="d-flex align-items-center justify-content-start">
        {{-- 🌐 Titre principal --}}
        @if(auth()->user()->user_type_id == 3)
            {{-- Étudiant : simple titre à gauche --}}
            <h3 class="fw-bold text-primary m-0">
                🌐 Online courses
            </h3>
        @elseif(auth()->user()->user_type_id == 2)
            {{-- Étudiant : simple titre à gauche --}}
            <h3 class="fw-bold text-primary m-0">
                🌐 Online courses
            </h3>
        @else 
            {{-- Admin/Prof : lien cliquable --}}
            <h3 class="fw-bold m-0">
                <a href="{{ route('online_courses.index') }}" class="text-primary text-decoration-none">
                    🌐 Online courses
                </a>
            </h3>
        @endif
    </div>
</div>




    {{-- ✅ Contenu principal --}}
    <div class="container">
        {{ $slot }}
    </div>

    {{-- ✅ Pied de page --}}
    <footer>
        Copyright © {{ date('Y') }} The Inspire Academy.
    </footer>

    @livewireScripts
    <script src="{{ URL::to('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    {{-- ✅ Script pour le plein écran --}}
    <script>
        document.getElementById('fullscreen-btn').addEventListener('click', () => {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        });
    </script>
</body>
</html>
