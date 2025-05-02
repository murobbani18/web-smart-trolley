<?php 
// $currentUrl = str_replace('/index.php/', '', current_url(true)->getPath()); 
$currentUrl = str_replace('/index.php/', '', current_url(true)->getPath());  // Menghapus '/index.php/' jika ada
$currentUrl = explode('/', $currentUrl)[0];  // Mengambil bagian pertama setelah pemisahan berdasarkan '/'
?>
<header class="navbar navbar-expand-md d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbar-menu" aria-controls="navbar-menu"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a href="#" class="navbar-brand navbar-brand-autodark me-3">
            <!-- SVG Icon for Brand -->
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-shopping-cart">
                <path d="M6 6h15l1.2 7H6.8L5.8 2H2" />
                <path d="M6 6l1 10h12l1-10H6z" />
                <path d="M3 21a1 1 0 1 0 2 0h12a1 1 0 1 0 2 0" />
            </svg>
            <span class="ms-2 fs-4 text-primary">Smart Trolley</span>
        </a>
        <ul class="navbar-nav">
            <?php if (session()->get('role') == 'staff'): ?>
                <li class="nav-item <?php echo ($currentUrl == 'dashboard') ? 'active' : ''; ?>">
                    <a class="nav-link" href="/dashboard">
                        <span class="nav-link-icon">
                            <!-- SVG Icon for Home -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-1">
                                <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                            </svg>
                        </span>
                        <span class="nav-link-title">Home</span>
                    </a>
                </li>
                <li class="nav-item <?php echo ($currentUrl == 'products') ? 'active' : ''; ?>">
                    <a class="nav-link" href="/products">
                        <span class="nav-link-icon">
                            <!-- Tabler Icon for Products (using SVG) -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icon-tabler-tag">
                                <path d="M8 15l-5 5a2 2 0 0 1 0 2a2 2 0 0 1 2 2h12a2 2 0 0 1 2 -2a2 2 0 0 1 0 -2l-5 -5" />
                                <path d="M15 5l4 4" />
                                <path d="M16 7a2 2 0 1 0 -4 0a2 2 0 1 0 4 0" />
                            </svg>
                        </span>
                        <span class="nav-link-title">Products</span>
                    </a>
                </li>
            <?php endif; ?>
            <li class="nav-item <?php echo ($currentUrl == 'payments') ? 'active' : ''; ?>">
            <?php if (session()->get('role') == 'staff'): ?>
                <a class="nav-link" href="/payments/validation">
            <?php else: ?>
                <a class="nav-link" href="/payments">
            <?php endif; ?>
                    <span class="nav-link-icon">
                        <!-- SVG Icon for Payments -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-1">
                            <path d="M9 11l3 3l8 -8" />
                            <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" />
                        </svg>
                    </span>
                    <span class="nav-link-title">Pembayaran</span>
                </a>
            </li>
            <!-- Catalog Navbar Item -->
            <li class="nav-item <?php echo ($currentUrl == 'catalog') ? 'active' : ''; ?>">
                <a class="nav-link" href="/catalog">
                    <span class="nav-link-icon">
                        <!-- SVG Icon for Catalog -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-1">
                            <path d="M3 3h18v18H3V3z" />
                            <path d="M9 9l6 6" />
                            <path d="M9 15l6-6" />
                        </svg>
                    </span>
                    <span class="nav-link-title">Catalog</span>
                </a>
            </li>

            <li class="nav-item <?php echo ($currentUrl == 'cart') ? 'active' : ''; ?>">
                <a class="nav-link" href="/cart">
                    <span class="nav-link-icon">
                        <!-- SVG Icon for Catalog -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-cart">
                        <path d="M6 6h15l-1.5 9h-11z" />
                        <circle cx="9" cy="20" r="1" />
                        <circle cx="18" cy="20" r="1" />
                        <path d="M6 6L5 2H2" />
                        </svg>
                    </span>
                    <span class="nav-link-title">Cart</span>
                </a>
            </li>
        </ul>
        <div class="navbar-nav flex-row order-md-last ms-auto">
            <a href="/logout" class="btn btn-outline-danger d-flex align-items-center">
                <!-- SVG Icon for Logout -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon me-1">
                    <path d="M14 8l4 4l-4 4" />
                    <path d="M5 12h13" />
                    <path d="M9 16v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2 -2v-10a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v1" />
                </svg>
                Logout
            </a>
        </div>
    </div>
</header>