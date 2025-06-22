<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>STARTIX</title>
    <!-- Tambahkan di header.blade.php atau layout utama -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <style>
    .custom-navbar {
        background-color: #000000;
        padding: 10px;
        color: #ffffff;
        text-align: center;
    }

    .custom-navbar a {
        color: #ffffff;
        margin: 0 15px;
        text-decoration: none;
        font-size: 18px;
        font-weight: 700;
        position: relative;
        transition: all 0.3s ease;
        font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    }

    .custom-navbar a::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 3px;
        bottom: -5px;
        left: 0;
        background-color: #ffffff;
        visibility: hidden;
        transform: scaleX(0);
        transition: all 0.3s ease-in-out;
    }

    .custom-navbar a:hover::before {
        visibility: visible;
        transform: scaleX(1);
    }

    /* Hamburger Menu */
    .hamburger {
        display: none;
        flex-direction: column;
        cursor: pointer;
        padding: 5px;
        background: none;
        border: none;
    }

    .hamburger span {
        width: 25px;
        height: 3px;
        background-color: white;
        margin: 3px 0;
        transition: 0.3s;
        border-radius: 2px;
    }

    .hamburger.active span:nth-child(1) {
        transform: rotate(-45deg) translate(-5px, 6px);
    }

    .hamburger.active span:nth-child(2) {
        opacity: 0;
    }

    .hamburger.active span:nth-child(3) {
        transform: rotate(45deg) translate(-5px, -6px);
    }

    /* Mobile Menu */
    .mobile-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background-color: #0d6efd;
        flex-direction: column;
        padding: 20px 0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 1000;
    }

    .mobile-menu.active {
        display: flex;
    }

    .mobile-menu a {
        padding: 15px 30px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        font-size: 16px;
        margin: 0;
    }

    .mobile-menu a:last-child {
        border-bottom: none;
    }

    .mobile-search {
        padding: 15px 30px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .mobile-search input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 4px;
        background-color: rgba(255,255,255,0.1);
        color: white;
    }

    .mobile-search input::placeholder {
        color: rgba(255,255,255,0.7);
    }

    /* Responsive Styles */
    @media (min-width: 992px) {
        .nav-links {
            display: flex !important;
        }
        
        .hamburger {
            display: none !important;
        }
        
        .mobile-menu {
            display: none !important;
        }
    }

    @media (max-width: 991px) {
        .nav-links {
            display: none;
        }
        
        .hamburger {
            display: flex;
        }
        
        .search-desktop {
            display: none;
        }

        .custom-navbar .container-fluid {
            justify-content: space-between;
        }

        .custom-navbar .container-fluid > div:nth-child(2) {
            position: static;
            transform: none;
        }
    }

    @media (max-width: 576px) {
        .custom-navbar img {
            width: 120px;
            height: 52px;
        }
    }
</style>
  </head>
  <body>

<nav class="custom-navbar" style="background-color: #0d6efd; position: relative;">
  <div class="container-fluid d-flex align-items-center justify-content-between position-relative">

    <!-- Kiri: Logo -->
    <div class="d-flex align-items-center">
      <img src="/images/logoo.png" alt="Logo" width="150" height="65" class="me-2">
    </div>

    <!-- Tengah: Hyperlink (Desktop) -->
    <div class="nav-links" style="position: absolute; left: 50%; transform: translateX(-50%);">
      <div class="d-flex gap-1">
        <a href="{{ route('user.dashboard') }}" class="text-decoration-none">
          <span class="navbar-brand mb-0 h1 text-white">Home</span>
        </a>
        <a href="{{ route('events.index') }}" class="text-decoration-none">
          <span class="navbar-brand mb-0 h1 text-white">Event</span>
        </a>
        <a href="https://www.instagram.com/startix.team?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="text-decoration-none" target="_blank">
          <span class="navbar-brand mb-0 h1 text-white">Hubungi Kami</span>
        </a>
      </div>
    </div>

    <!-- Kanan: Search + Login -->
    <div class="d-flex align-items-center gap-5">

      <!-- Search Form (Desktop) -->
      <div class="search-desktop">
        <form id="searchForm" action="{{ route('events.index') }}" method="GET" class="d-none" style="position: relative;">
          <input
            type="text"
            name="search"
            placeholder="Cari event..."
            class="form-control form-control-sm"
            style="width: 180px; padding-right: 25px;"
            autocomplete="off"
          />
          <button type="submit" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); border:none; background:none; color:#9a9a9b; cursor:pointer;">
            <i class="bi bi-search"></i>
          </button>
        </form>

        <button id="searchToggleBtn" class="btn btn-primary" type="button" title="Search">
          <i class="bi bi-search"></i>
        </button>
      </div>

      <!-- Login (Desktop) -->
      <a href="{{ route('login') }}" class="text-decoration-none d-none d-lg-inline">
        <span class="navbar-brand mb-0 h1 text-white">
          <i class="bi bi-box-arrow-in-right"></i> Login
        </span>
      </a>

      <!-- Hamburger Menu Button -->
      <button class="hamburger d-lg-none" id="hamburgerBtn" aria-label="Menu">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
      <!-- Mobile Search -->
      <div class="mobile-search">
        <form action="{{ route('events.index') }}" method="GET">
          <input
            type="text"
            name="search"
            placeholder="Cari event..."
            autocomplete="off"
          />
        </form>
      </div>
      
      <!-- Mobile Navigation Links -->
      <a href="{{ route('user.dashboard') }}" class="text-decoration-none">
        <span class="navbar-brand mb-0 h1 text-white">Home</span>
      </a>
      <a href="{{ route('events.index') }}" class="text-decoration-none">
        <span class="navbar-brand mb-0 h1 text-white">Event</span>
      </a>
      <a href="https://www.instagram.com/startix.team?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="text-decoration-none" target="_blank">
        <span class="navbar-brand mb-0 h1 text-white">Hubungi Kami</span>
      </a>
      <a href="{{ route('login') }}" class="text-decoration-none">
        <span class="navbar-brand mb-0 h1 text-white">
          <i class="bi bi-box-arrow-in-right"></i> Login
        </span>
      </a>
    </div>

  </div>
</nav>

<script>
  // Toggle search input visibility saat icon search diklik
  const searchToggleBtn = document.getElementById('searchToggleBtn');
  const searchForm = document.getElementById('searchForm');

  if (searchToggleBtn && searchForm) {
    searchToggleBtn.addEventListener('click', () => {
      if (searchForm.classList.contains('d-none')) {
        searchForm.classList.remove('d-none');
        searchForm.querySelector('input[name="search"]').focus();
      } else {
        searchForm.classList.add('d-none');
      }
    });
  }

  // Hamburger Menu Toggle
  const hamburgerBtn = document.getElementById('hamburgerBtn');
  const mobileMenu = document.getElementById('mobileMenu');

  if (hamburgerBtn && mobileMenu) {
    hamburgerBtn.addEventListener('click', () => {
      hamburgerBtn.classList.toggle('active');
      mobileMenu.classList.toggle('active');
    });
  }

  // Close mobile menu when clicking outside
  document.addEventListener('click', (e) => {
    if (mobileMenu && hamburgerBtn) {
      if (!hamburgerBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
        hamburgerBtn.classList.remove('active');
        mobileMenu.classList.remove('active');
      }
    }
  });

  // Close mobile menu when window is resized to desktop
  window.addEventListener('resize', () => {
    if (window.innerWidth >= 992) {
      if (hamburgerBtn && mobileMenu) {
        hamburgerBtn.classList.remove('active');
        mobileMenu.classList.remove('active');
      }
    }
  });
</script>

    <!-- Tambahkan container dan row di sini -->
    
    <div class="container my-4">
      <div class="row">
        <div class="col-12">
          @yield('content')
        </div>
      </div>
    </div>
    @extends('user.layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  @stack('scripts')
  </body>
</html>