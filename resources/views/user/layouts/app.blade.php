<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Required for JS interactions later --}}

    {{-- Dynamically set title --}}
    <title>@yield('title', 'Tài khoản đo đạc') - {{ config('app.name', 'Website RTK') }}</title>

    {{-- Stylesheets & Fonts --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Tailwind Config --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#f0fdf4', 100: '#dcfce7', 200: '#bbf7d0', 300: '#86efac', 400: '#4ade80', 500: '#22c55e', 600: '#16a34a', 700: '#15803d', 800: '#166534', 900: '#14532d' }
                    }
                }
            },
            variants: { extend: { backgroundColor: ['odd', 'even'] } }
        }
    </script>

    {{-- Custom Inline Styles (Keep relevant styles from original HTML) --}}
    <style>
        .map-container { height: 400px; width: 100%; }
        @media (min-width: 768px) { .map-container { height: 500px; } }
        /* .content-section { display: none; }  We will control this via routing now */
        /* .content-section.active { display: block; } */
        .nav-item.active { background-color: theme('colors.primary.100'); border-left: 4px solid theme('colors.primary.500'); color: theme('colors.primary.700'); font-weight: 600; }
        .nav-item.active i { color: theme('colors.primary.600'); }
        .badge { display: inline-block; padding: 0.25em 0.6em; font-size: 75%; font-weight: 700; line-height: 1; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: 0.375rem; transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out; }
        .badge-green { color: #065f46; background-color: #d1fae5; }
        .badge-yellow { color: #92400e; background-color: #fef3c7; }
        .badge-red { color: #991b1b; background-color: #fee2e2; }
        .badge-blue { color: #1e40af; background-color: #dbeafe; }
        .badge-gray { color: #374151; background-color: #f3f4f6; }

        /* Sidebar transition */
         #sidebar { transition: transform 0.3s ease-in-out; }
         #sidebar-overlay { transition: opacity 0.3s ease-in-out; }
    </style>

    {{-- Yield for page-specific styles --}}
    @yield('styles')
</head>
<body class="bg-gray-100 text-gray-800 text-sm font-sans">

    <div class="relative min-h-screen lg:flex">

        {{-- Overlay for Mobile Sidebar --}}
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>

        {{-- Sidebar --}}
        <div id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-white shadow-md flex flex-col shrink-0 z-30 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto lg:z-auto transition-transform duration-300 ease-in-out">
            {{-- Sidebar Header --}}
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h1 class="text-xl font-bold text-primary-700 flex items-center gap-2">
                    <i class="fas fa-ruler-combined"></i> <span>Đo đạc</span>
                </h1>
                <button class="text-gray-500 hover:text-gray-700 lg:hidden" onclick="toggleSidebar()">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            {{-- Sidebar User Info --}}
            <div class="p-4">
                {{-- Use @auth later to show real user info --}}
                <div class="flex items-center p-2 rounded-lg bg-gray-50 border border-gray-200">
                    <div class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white shrink-0"> <i class="fas fa-user"></i> </div>
                    <div class="ml-3 overflow-hidden">
                        {{-- Replace with Auth::user()->name etc. later --}}
                        <p id="user-sidebar-name" class="font-semibold text-gray-900 truncate text-base">Người dùng Demo</p>
                        <p class="text-xs text-gray-500">Khách hàng</p>
                    </div>
                </div>
            </div>
            {{-- Sidebar Navigation --}}
            <div class="flex-grow overflow-y-auto p-4 pt-0">
                <nav class="space-y-1">
                    <a href="{{ route('user.dashboard') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer transition duration-150 ease-in-out {{ Route::is('user.dashboard') ? 'active' : '' }}"> <i class="fas fa-tachometer-alt w-5 h-5 mr-3 text-primary-600"></i> Dashboard </a>
                    <a href="{{ route('user.map') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer transition duration-150 ease-in-out {{ Route::is('user.map') ? 'active' : '' }}"> <i class="fas fa-map-marked-alt w-5 h-5 mr-3 text-primary-600"></i> Map hiển thị </a>
                    <a href="{{ route('user.packages') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer transition duration-150 ease-in-out {{ Route::is('user.packages*') ? 'active' : '' }}"> <i class="fas fa-shopping-cart w-5 h-5 mr-3 text-primary-600"></i> Mua tài khoản </a>
                    <a href="{{ route('user.accounts') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer transition duration-150 ease-in-out {{ Route::is('user.accounts') ? 'active' : '' }}"> <i class="fas fa-tasks w-5 h-5 mr-3 text-primary-600"></i> Quản lý tài khoản </a>
                    <a href="{{ route('user.transactions') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer transition duration-150 ease-in-out {{ Route::is('user.transactions') ? 'active' : '' }}"> <i class="fas fa-file-invoice-dollar w-5 h-5 mr-3 text-primary-600"></i> Quản lý giao dịch </a>
                    <a href="{{ route('user.referrals') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer transition duration-150 ease-in-out {{ Route::is('user.referrals') ? 'active' : '' }}"> <i class="fas fa-users w-5 h-5 mr-3 text-primary-600"></i> Chương trình giới thiệu </a>

                    {{-- Trợ giúp --}}
                    <div class="pt-4 mt-4 border-t border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase px-3 mb-2">Trợ giúp</p>
                        <nav class="space-y-1">
                            <a href="{{ route('user.guide') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer transition duration-150 ease-in-out {{ Route::is('user.guide') ? 'active' : '' }}"> <i class="fas fa-book-open w-5 h-5 mr-3 text-primary-600"></i> Hướng dẫn sử dụng </a>
                            <a href="{{ route('user.support') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer transition duration-150 ease-in-out {{ Route::is('user.support') ? 'active' : '' }}"> <i class="fas fa-headset w-5 h-5 mr-3 text-primary-600"></i> Hỗ trợ </a>
                        </nav>
                    </div>

                    {{-- Cài đặt --}}
                    <div class="pt-4 mt-4 border-t border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase px-3 mb-2">Cài đặt</p>
                        <nav class="space-y-1">
                            <a href="{{ route('user.profile') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer transition duration-150 ease-in-out {{ Route::is('user.profile') ? 'active' : '' }}"> <i class="fas fa-user-circle w-5 h-5 mr-3 text-primary-600"></i> Thông tin cá nhân </a>
                            <a href="{{ route('user.payment-info') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer transition duration-150 ease-in-out {{ Route::is('user.payment-info') ? 'active' : '' }}"> <i class="fas fa-credit-card w-5 h-5 mr-3 text-primary-600"></i> Thông tin thanh toán </a>
                            <a href="{{ route('user.invoice-info') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer transition duration-150 ease-in-out {{ Route::is('user.invoice-info') ? 'active' : '' }}"> <i class="fas fa-file-alt w-5 h-5 mr-3 text-primary-600"></i> Thông tin xuất hóa đơn </a>
                            {{-- Logout Form --}}
                            <form method="POST" action="{{ route('user.logout') }}" id="logout-form-user" class="inline">
                                @csrf
                                <a href="{{ route('user.logout') }}"
                                   onclick="event.preventDefault(); if(confirm('Bạn chắc chắn muốn đăng xuất?')) { document.getElementById('logout-form-user').submit(); }"
                                   class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-red-50 cursor-pointer transition duration-150 ease-in-out">
                                    <i class="fas fa-sign-out-alt w-5 h-5 mr-3 text-red-600"></i> Đăng xuất
                                </a>
                            </form>
                        </nav>
                    </div>
                </nav>
            </div>
        </div>
        {{-- End Sidebar --}}

        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Mobile/Tablet Header --}}
            <header class="lg:hidden sticky top-0 z-10 bg-white shadow-md">
                <div class="container mx-auto px-4 py-3 flex items-center justify-between">
                    <button class="text-primary-700 hover:text-primary-900" onclick="toggleSidebar()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-lg font-bold text-primary-700">
                        <i class="fas fa-ruler-combined mr-2"></i> Tài khoản đo đạc
                    </h1>
                    <div class="w-6"></div> {{-- Placeholder --}}
                </div>
            </header>

            {{-- Main Content Scrollable Area --}}
            <main class="flex-1 overflow-y-auto bg-gray-100 p-4 sm:p-6 lg:p-8">
                {{-- Dynamic Content Goes Here --}}
                @yield('content')
            </main>
        </div>
        {{-- End Main Content Area --}}

    </div>

    {{-- JavaScript --}}
    {{-- Keep essential JS for sidebar toggle and toast notifications --}}
    <script>
         let isSidebarOpen = false;
         const sidebar = document.getElementById('sidebar');
         const overlay = document.getElementById('sidebar-overlay');

         function toggleSidebar() {
             isSidebarOpen = !isSidebarOpen;
             if (isSidebarOpen) {
                 sidebar.classList.remove('-translate-x-full');
                 sidebar.classList.add('translate-x-0');
                 overlay.classList.remove('hidden');
                 // Trigger reflow to ensure transition plays
                 void overlay.offsetWidth;
                 overlay.style.opacity = '1';
             } else {
                 sidebar.classList.add('-translate-x-full');
                 sidebar.classList.remove('translate-x-0');
                 overlay.style.opacity = '0';
                 // Wait for transition before hiding
                 setTimeout(() => {
                     overlay.classList.add('hidden');
                 }, 300); // Match transition duration
             }
         }

        // Simplified Toast Function (Adapt as needed)
        function showToast(message, type = 'success') {
            const toastId = 'toast-' + Date.now();
            const toast = document.createElement('div');
            toast.id = toastId;
            toast.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-times-circle'} mr-2"></i> ${message}`;
            toast.className = `fixed bottom-5 right-5 px-4 py-2 rounded-md text-white text-sm shadow-lg z-[1000] flex items-center transition-all duration-300 transform translate-y-full opacity-0 ${
                type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            }`;
            document.body.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-full', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            });

            setTimeout(() => {
                if (document.body.contains(toast)) {
                    toast.classList.remove('opacity-100');
                    toast.classList.add('opacity-0');
                    setTimeout(() => {
                        if (document.body.contains(toast)) document.body.removeChild(toast);
                    }, 300);
                }
            }, 3000);
        }

         // --- Add other JS functions from user.html here as needed ---
         // e.g., formatCurrency, copyToClipboard, renderPackages (if called directly)
         // Note: Functions like showSection, loadData are now less relevant as
         // Laravel routing handles page loading. Keep only essential UI helpers.

    </script>

    {{-- Yield for page-specific scripts --}}
    @yield('scripts')

</body>
</html>
