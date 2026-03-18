<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 bg-slate-900 fixed-start" id="sidenav-main">

    {{-- Header --}}
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand d-flex align-items-center m-0 py-3" href="{{ route('education.dashboard') }}">
            <div class="me-2 d-flex align-items-center justify-content-center"
                style="width:32px;height:32px;background:rgba(255,255,255,0.15);border-radius:8px;flex-shrink:0;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="white">
                    <path d="M11.7 2.805a.75.75 0 01.6 0A60.65 60.65 0 0122.83 8.72a.75.75 0 01-.231 1.337 49.949 49.949 0 00-9.902 3.912l-.003.002-.34.18a.75.75 0 01-.707 0A50.009 50.009 0 007.5 12.174v-.224c0-.131.067-.248.172-.311a54.614 54.614 0 014.653-2.52.75.75 0 00-.65-1.352 56.129 56.129 0 00-4.78 2.589 1.858 1.858 0 00-.859 1.228 49.803 49.803 0 00-4.634-1.527.75.75 0 01-.231-1.337A60.653 60.653 0 0111.7 2.805z"/>
                    <path d="M13.06 15.473a48.45 48.45 0 017.666-3.282c.134 1.414.22 2.843.255 4.285a.75.75 0 01-.46.71 47.878 47.878 0 00-8.105 4.342.75.75 0 01-.832 0 47.877 47.877 0 00-8.104-4.342.75.75 0 01-.461-.71c.035-1.442.121-2.87.255-4.286A48.4 48.4 0 016 13.18v1.27a1.5 1.5 0 00-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.661a6.729 6.729 0 00.551-1.608 1.5 1.5 0 00.14-2.67v-.645a48.549 48.549 0 013.44 1.668 2.25 2.25 0 002.12 0z"/>
                </svg>
            </div>
            <span class="font-weight-bold text-white" style="font-size:15px;letter-spacing:0.3px;">EduPlatform</span>
        </a>
    </div>

    <div class="collapse navbar-collapse px-4 w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">

            {{-- Dashboard --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('education.dashboard') ? 'active' : '' }}"
                    href="{{ route('education.dashboard') }}">
                    <div class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <svg width="28px" height="28px" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <g fill="#FFFFFF" fill-rule="nonzero">
                                <path class="color-foreground" d="M0,1.71 C0,0.768 0.768,0 1.714,0 L22.286,0 C23.232,0 24,0.768 24,1.714 L24,5.143 C24,6.09 23.232,6.857 22.286,6.857 L1.714,6.857 C0.768,6.857 0,6.09 0,5.143 Z"/>
                                <path class="color-background" d="M0,12 C0,11.053 0.768,10.286 1.714,10.286 L12,10.286 C12.947,10.286 13.714,11.053 13.714,12 L13.714,22.286 C13.714,23.232 12.947,24 12,24 L1.714,24 C0.768,24 0,23.232 0,22.286 Z"/>
                                <path class="color-background" d="M18.857,10.286 C17.91,10.286 17.143,11.053 17.143,12 L17.143,22.286 C17.143,23.232 17.91,24 18.857,24 L22.286,24 C23.232,24 24,23.232 24,22.286 L24,12 C24,11.053 23.232,10.286 22.286,10.286 Z"/>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            {{-- ── ACADÉMICO ─────────────────────────────────────────── --}}
            <li class="nav-item mt-3">
                <div class="nav-link ps-1 py-0">
                    <span class="text-uppercase text-xxs font-weight-bolder opacity-6 text-white letter-spacing-1">Académico</span>
                </div>
            </li>

            @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
            <li class="nav-item border-start my-0 pt-1">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ request()->routeIs('education.students.*') ? 'active' : '' }}"
                    href="{{ route('education.students.index') }}">
                    <i class="fas fa-user-graduate me-2 text-xs"></i>
                    <span class="nav-link-text">Estudiantes</span>
                </a>
            </li>
            @endif

            <li class="nav-item border-start my-0 pt-1">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ request()->routeIs('education.courses.*') ? 'active' : '' }}"
                    href="{{ route('education.courses.index') }}">
                    <i class="fas fa-book-open me-2 text-xs"></i>
                    <span class="nav-link-text">Cursos</span>
                </a>
            </li>

            <li class="nav-item border-start my-0 pt-1">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ request()->routeIs('education.grades.*') ? 'active' : '' }}"
                    href="{{ route('education.grades.index') }}">
                    <i class="fas fa-star-half-alt me-2 text-xs"></i>
                    <span class="nav-link-text">Calificaciones</span>
                </a>
            </li>

            @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
            <li class="nav-item border-start my-0 pt-1">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ request()->routeIs('education.attendance.*') ? 'active' : '' }}"
                    href="{{ route('education.attendance.index') }}">
                    <i class="fas fa-clipboard-check me-2 text-xs"></i>
                    <span class="nav-link-text">Asistencia</span>
                </a>
            </li>
            @endif

            {{-- ── ADMINISTRACIÓN (solo admin) ──────────────────── --}}
            @if(auth()->user()->isAdmin())
            <li class="nav-item mt-3">
                <div class="nav-link ps-1 py-0">
                    <span class="text-uppercase text-xxs font-weight-bolder opacity-6 text-white letter-spacing-1">Administración</span>
                </div>
            </li>
            <li class="nav-item border-start my-0 pt-1">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ request()->routeIs('education.teachers.*') ? 'active' : '' }}"
                    href="{{ route('education.teachers.index') }}">
                    <i class="fas fa-chalkboard-teacher me-2 text-xs"></i>
                    <span class="nav-link-text">Docentes</span>
                </a>
            </li>
            <li class="nav-item border-start my-0 pt-1">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ request()->routeIs('education.programs.*') ? 'active' : '' }}"
                    href="{{ route('education.programs.index') }}">
                    <i class="fas fa-university me-2 text-xs"></i>
                    <span class="nav-link-text">Programas</span>
                </a>
            </li>
            <li class="nav-item border-start my-0 pt-1">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('users-management') ? 'active' : '' }}"
                    href="{{ route('users-management') }}">
                    <i class="fas fa-users-cog me-2 text-xs"></i>
                    <span class="nav-link-text">Usuarios</span>
                </a>
            </li>
            @endif

            {{-- ── MI CUENTA ─────────────────────────────────────── --}}
            <li class="nav-item mt-3">
                <div class="nav-link ps-1 py-0">
                    <span class="text-uppercase text-xxs font-weight-bolder opacity-6 text-white letter-spacing-1">Mi Cuenta</span>
                </div>
            </li>
            <li class="nav-item border-start my-0 pt-1">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('users.profile') ? 'active' : '' }}"
                    href="{{ route('users.profile') }}">
                    <i class="fas fa-user-circle me-2 text-xs"></i>
                    <span class="nav-link-text">Mi Perfil</span>
                </a>
            </li>
            <li class="nav-item border-start my-0 pt-1">
                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                    @csrf
                    <button type="submit" class="nav-link position-relative ms-0 ps-2 py-2 w-100 text-start bg-transparent border-0">
                        <i class="fas fa-sign-out-alt me-2 text-xs" style="color:#f87171;"></i>
                        <span class="nav-link-text" style="color:#f87171;">Cerrar Sesión</span>
                    </button>
                </form>
            </li>

        </ul>
    </div>

    {{-- Footer con badge de usuario --}}
    <div class="sidenav-footer mx-3 mb-3">
        <div class="card border-radius-md" id="sidenavCard" style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-2 text-white fw-bold d-flex align-items-center justify-content-center"
                        style="width:38px;height:38px;background:rgba(255,255,255,0.2);border-radius:10px;font-size:13px;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div style="min-width:0">
                        <p class="mb-0 text-white text-sm font-weight-bold text-truncate" style="max-width:130px;">
                            {{ auth()->user()->name }}
                        </p>
                        <span class="badge text-white px-2 py-1 mt-1"
                            style="font-size:9px;background:{{ auth()->user()->isAdmin() ? '#ef4444' : (auth()->user()->isTeacher() ? '#f59e0b' : '#10b981') }};border-radius:6px;">
                            {{ auth()->user()->role_label }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</aside>
