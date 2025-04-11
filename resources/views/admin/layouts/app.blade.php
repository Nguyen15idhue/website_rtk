
*   **`resources/views/admin/layouts/app.blade.php`**
    ```blade
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Trang Quản Trị') - {{ config('app.name', 'Website RTK') }}</title>

        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        {{-- Tailwind Config --}}
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: { 50: '#f0fdf4', 100: '#dcfce7', 200: '#bbf7d0', 300: '#86efac', 400: '#4ade80', 500: '#22c55e', 600: '#16a34a', 700: '#15803d', 800: '#166534', 900: '#14532d' },
                            admin: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a' }
                        }
                    }
                }
            }
        </script>

        {{-- Custom Inline Styles (Keep relevant styles from admin.html) --}}
        <style>
            /* Basic layout helpers */
            /* .content-section { display: none; } */ /* Controlled by routing */
            /* .content-section.active { display: block; } */

            /* Sidebar Active State */
            .nav-item.active { background-color: theme('colors.primary.100'); border-left: 4px solid theme('colors.primary.500'); color: theme('colors.primary.700'); font-weight: 600; }
            .nav-item.active i { color: theme('colors.primary.600'); }
            .nav-item { transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out; }

            /* --- Inputs, Buttons, Tables --- */
            input[type="text"], input[type="email"], input[type="tel"], input[type="date"], input[type="number"], input[type="password"], input[type="search"], textarea, select { @apply w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-300 focus:border-primary-500 transition duration-150 ease-in-out shadow-sm text-sm; }
            input[type="file"] { @apply block w-full text-sm text-gray-500 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-300 file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100; }
            button, .btn { @apply transition duration-150 ease-in-out; }
            .btn { @apply py-2 px-3 rounded-lg font-medium text-xs inline-flex items-center justify-center gap-1; }
            .btn-primary { @apply btn bg-primary-500 hover:bg-primary-600 text-white shadow; }
            .btn-secondary { @apply btn bg-gray-200 hover:bg-gray-300 text-gray-800; }
            .btn-danger { @apply btn bg-red-500 hover:bg-red-600 text-white; }
            /* ... other btn styles ... */
            .btn-icon { @apply p-2 rounded hover:bg-gray-200 text-gray-600; }
            button:disabled, .btn:disabled { @apply opacity-50 cursor-not-allowed; }

            tbody tr:nth-child(odd) { background-color: theme('colors.gray.50'); }
            tbody tr:hover { background-color: theme('colors.primary.50'); }
            th, td { @apply px-2 py-1 text-xs; }
            thead th { @apply text-left font-semibold text-gray-600 uppercase tracking-wider bg-gray-100; }

            /* Badges */
            .badge { @apply px-2 py-0.5 inline-flex leading-4 font-semibold rounded-full text-xs; }
            .badge-green { @apply bg-green-100 text-green-800; } .badge-red { @apply bg-red-100 text-red-800; } .badge-yellow { @apply bg-yellow-100 text-yellow-800; } /* ... other badge styles ... */

            /* Modal Styling */
            .modal { display: none; position: fixed; z-index: 100; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); align-items: center; justify-content: center; }
            .modal.active { display: flex; }
            .modal-content { background-color: #fefefe; margin: auto; padding: 20px; border: 1px solid #888; width: 90%; max-width: 600px; border-radius: 8px; position: relative; box-shadow: 0 4px 20px rgba(0,0,0,0.15); }
            .modal-close { color: #aaa; position: absolute; top: 10px; right: 15px; font-size: 28px; font-weight: bold; cursor: pointer; line-height: 1; }
            .modal-close:hover, .modal-close:focus { color: black; text-decoration: none; }

            /* --- Responsive Sidebar specific styles --- */
            .sidebar { transition: transform 0.3s ease-in-out, width 0.3s ease-in-out; position: fixed; top: 0; left: 0; height: 100%; z-index: 40; transform: translateX(-100%); width: 256px; }
            .sidebar.open { transform: translateX(0); }
            @media (min-width: 768px) { .sidebar { position: static; transform: translateX(0); height: auto; z-index: auto; } }
            .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 30; }
            .sidebar-overlay.active { display: block; }
            @media (min-width: 768px) { .sidebar-overlay { display: none !important; } }
        </style>
        @yield('styles')
    </head>
    {{-- Adjust body classes as needed --}}
    <body class="bg-gray-100 text-gray-800 text-sm md:text-xs">

        {{-- Overlay for mobile sidebar --}}
        <div id="sidebar-overlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>

        <div class="flex min-h-screen">

            {{-- Sidebar --}}
            <div id="admin-sidebar" class="sidebar w-64 bg-white shadow-lg flex flex-col shrink-0 overflow-y-auto md:shadow-md">
                {{-- Logo/Title and close button --}}
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h1 class="text-lg font-bold text-primary-700 flex items-center gap-2">
                        <i class="fas fa-user-shield"></i>
                        <span>Trang Quản Trị</span>
                    </h1>
                    <button class="md:hidden text-gray-500 hover:text-gray-700" onclick="toggleSidebar()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                {{-- Menu Area --}}
                <div class="flex-grow p-4">
                    {{-- Admin User Info (Simulated) --}}
                    <div class="flex items-center mb-6 p-2 rounded-lg bg-gray-50 border border-gray-200">
                        <div class="w-10 h-10 rounded-full bg-admin-500 flex items-center justify-center text-white shrink-0">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="ml-3 overflow-hidden">
                            {{-- Replace with Auth::user()->name etc. later --}}
                            <p id="admin-user-name" class="font-semibold text-sm text-gray-900 truncate">Admin Name</p>
                            <p id="admin-user-role" class="text-xs text-gray-500">Super Admin</p>
                        </div>
                    </div>

                    {{-- Main Menu --}}
                    {{-- Use Route::is() for active state --}}
                    <nav class="space-y-1" id="admin-main-menu">
                        <a href="{{ route('admin.dashboard') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer {{ Route::is('admin.dashboard') ? 'active' : '' }}"> <i class="fas fa-tachometer-alt w-5 h-5 mr-3 text-primary-600"></i> Dashboard </a>
                        <a href="{{ route('admin.users.index') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer {{ Route::is('admin.users.*') ? 'active' : '' }}"> <i class="fas fa-users w-5 h-5 mr-3 text-primary-600"></i> QL người dùng </a>
                        <a href="{{ route('admin.survey-accounts.index') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer {{ Route::is('admin.survey-accounts.*') ? 'active' : '' }}"> <i class="fas fa-ruler-combined w-5 h-5 mr-3 text-primary-600"></i> QL TK đo đạc </a>
                        <a href="{{ route('admin.transactions.index') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer {{ Route::is('admin.transactions.*') ? 'active' : '' }}"> <i class="fas fa-file-invoice-dollar w-5 h-5 mr-3 text-primary-600"></i> QL hóa đơn/GD </a>
                        <a href="{{ route('admin.referrals.index') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer {{ Route::is('admin.referrals.*') ? 'active' : '' }}"> <i class="fas fa-network-wired w-5 h-5 mr-3 text-primary-600"></i> QL người giới thiệu </a>
                        <a href="{{ route('admin.reports.index') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer {{ Route::is('admin.reports.*') ? 'active' : '' }}"> <i class="fas fa-chart-line w-5 h-5 mr-3 text-primary-600"></i> Báo cáo </a>
                        <a href="{{ route('admin.permissions.index') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer {{ Route::is('admin.permissions.*') ? 'active' : '' }}"> <i class="fas fa-user-lock w-5 h-5 mr-3 text-primary-600"></i> QL phân quyền </a>

                        {{-- Settings Section --}}
                        <div class="pt-4 mt-4 border-t border-gray-200">
                            <p class="text-xs font-semibold text-gray-500 uppercase px-3 mb-2">Cài đặt</p>
                            <nav class="space-y-1">
                                <a href="{{ route('admin.profile') }}" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-primary-50 cursor-pointer {{ Route::is('admin.profile') ? 'active' : '' }}"> <i class="fas fa-id-card w-5 h-5 mr-3 text-primary-600"></i> Thông tin tài khoản </a>
                                 {{-- Logout Form --}}
                                <form method="POST" action="{{ route('admin.logout') }}" id="logout-form-admin" class="inline">
                                     @csrf
                                     <a href="{{ route('admin.logout') }}"
                                        onclick="event.preventDefault(); if(confirm('Bạn chắc chắn muốn đăng xuất?')) { document.getElementById('logout-form-admin').submit(); }"
                                        class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-red-50 cursor-pointer">
                                         <i class="fas fa-sign-out-alt w-5 h-5 mr-3 text-red-600"></i> Đăng xuất
                                     </a>
                                 </form>
                            </nav>
                        </div>
                    </nav>
                </div>
            </div>
            {{-- End Sidebar --}}

            {{-- Main content --}}
            <div id="main-content" class="flex-1 overflow-y-auto bg-gray-100 md:ml-0 transition-all duration-300 ease-in-out">
                {{-- Header for mobile --}}
                <div class="sticky top-0 z-20 bg-white shadow-sm p-3 flex items-center justify-between md:hidden">
                    <button id="hamburger-button" class="text-gray-600 hover:text-primary-600" onclick="toggleSidebar()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h2 id="current-page-title" class="text-sm font-semibold text-gray-700">@yield('title', 'Dashboard')</h2>
                    <div></div> {{-- Placeholder --}}
                </div>

                {{-- Padding for main content --}}
                <div class="p-3 sm:p-4 md:p-6 lg:p-8">
                     {{-- Dynamic Content Goes Here --}}
                     @yield('content')
                </div> {{-- End content padding --}}
            </div>
            {{-- End Main content --}}

        </div> {{-- End flex container --}}

        {{-- Modals (Define components or include partials later) --}}
        {{-- Example: @include('admin.components.modal-view-proof') --}}

        {{-- JavaScript --}}
        <script>
            // --- State Variables ---
            const sidebar = document.getElementById('admin-sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            // --- GIẢ LẬP VAI TRÒ SUPER ADMIN (REMOVE LATER) ---
            const currentUser = {
                name: "Super Admin Demo", role: 'SuperAdmin', email: 'super.admin.demo@system.com'
            };
             // --- Fill simulated user info ---
             if (currentUser) {
                 document.getElementById('admin-user-name').innerText = currentUser.name || 'Admin';
                 document.getElementById('admin-user-role').innerText = currentUser.role || 'Role';
             }

            // --- Sidebar Toggle Function ---
            function toggleSidebar() {
                sidebar.classList.toggle('open');
                sidebarOverlay.classList.toggle('active');
            }

            // --- Toast Function (Same as user layout or use a library) ---
            function showToast(message, type = 'success') {
                 const toastId = 'toast-' + Date.now();
                 const toast = document.createElement('div');
                 toast.id = toastId;
                 let iconHtml = '';
                 if (type === 'success') iconHtml = '<i class="fas fa-check-circle mr-2"></i>';
                 else if (type === 'error') iconHtml = '<i class="fas fa-times-circle mr-2"></i>';
                 else if (type === 'warning') iconHtml = '<i class="fas fa-exclamation-triangle mr-2"></i>';
                 else iconHtml = '<i class="fas fa-info-circle mr-2"></i>';
                 toast.innerHTML = iconHtml + message;

                 // Create container if it doesn't exist
                 let toastContainer = document.getElementById('toast-container');
                 if (!toastContainer) {
                     toastContainer = document.createElement('div');
                     toastContainer.id = 'toast-container';
                     toastContainer.style.position = 'fixed';
                     toastContainer.style.top = '20px';
                     toastContainer.style.right = '20px';
                     toastContainer.style.zIndex = '1050';
                     toastContainer.style.display = 'flex';
                     toastContainer.style.flexDirection = 'column';
                     toastContainer.style.alignItems = 'flex-end';
                     toastContainer.style.gap = '10px';
                     document.body.appendChild(toastContainer);

                     // Add styles for toasts
                     const style = document.createElement('style');
                     style.textContent = `
                         #toast-container .toast {
                             padding: 10px 15px; border-radius: 6px; color: white; font-size: 14px;
                             display: inline-flex; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.15);
                             opacity: 1; transition: opacity 0.3s ease-out; max-width: 300px; word-break: break-word;
                             animation: fade-in-down 0.3s ease-out;
                         }
                         #toast-container .toast-success { background-color: rgba(34, 197, 94, 0.95); }
                         #toast-container .toast-error { background-color: rgba(239, 68, 68, 0.95); }
                         #toast-container .toast-warning { background-color: rgba(245, 158, 11, 0.95); }
                         #toast-container .toast-info { background-color: rgba(59, 130, 246, 0.95); }
                         @keyframes fade-in-down {
                             from { opacity: 0; transform: translateY(-10px); }
                             to { opacity: 1; transform: translateY(0); }
                         }
                     `;
                     document.head.appendChild(style);
                 }

                 toast.className = `toast toast-${type}`;
                 toastContainer.appendChild(toast);

                 setTimeout(() => {
                     toast.style.opacity = '0';
                     setTimeout(() => {
                         if (toast.parentNode === toastContainer) {
                             toastContainer.removeChild(toast);
                             if (toastContainer.childElementCount === 0 && document.body.contains(toastContainer)) {
                                 // Optionally remove container if empty, depends on preference
                                 // document.body.removeChild(toastContainer);
                             }
                         }
                     }, 300);
                 }, 3500);
             }

            // --- Modal Handling ---
            function openModal(modalId) {
                const modal = document.getElementById(modalId);
                if(modal) modal.classList.add('active');
            }
            function closeModal(modalId) {
                const modal = document.getElementById(modalId);
                if(modal) modal.classList.remove('active');
            }
             // Close modal on overlay click
             window.onclick = function(event) {
                 document.querySelectorAll('.modal.active').forEach(modal => {
                     if (event.target == modal) closeModal(modal.id);
                 });
             }

            // --- Add other JS functions from admin.html as needed ---
            // Placeholder for Permission check (replace with real logic)
             function hasPermission(permissionKey) {
                 console.warn(`Permission check for '${permissionKey}' called (Simulated: Allowed for SuperAdmin)`);
                 return currentUser?.role === 'SuperAdmin';
             }
             // Apply permissions (basic simulation - hides menu items if no permission)
             function applyPermissions() {
                 document.querySelectorAll('#admin-main-menu .nav-item[data-permission]').forEach(item => {
                     const permission = item.getAttribute('data-permission');
                     if (permission && !hasPermission(permission)) {
                        // item.style.display = 'none'; // Hide inaccessible items
                        // Or disable them
                        item.setAttribute('disabled', true);
                        item.classList.add('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
                         item.classList.remove('hover:bg-primary-50');
                         item.onclick = (e) => { e.preventDefault(); showToast('Không có quyền!', 'error'); };
                     }
                 });
                 // Add logic for buttons etc. later using data-permission attributes
             }

             document.addEventListener('DOMContentLoaded', () => {
                 // Apply simulated permissions on load
                 // applyPermissions(); // Uncomment when adding data-permission attributes to links
                 console.log('Admin layout initialized.');
             });

        </script>
        @yield('scripts')
    </body>
    </html>
    ```

*   **`resources/views/user/dashboard/index.blade.php`**
    ```blade
    @extends('user.layouts.app')

    @section('title', 'Dashboard') {{-- Sets the page title --}}

    @section('content')
        {{-- Use the structure from the original user.html Dashboard section --}}
        <div id="dashboard"> {{-- Keep the ID if JS targets it --}}
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-5 sm:mb-6">Dashboard</h2>

            {{-- Placeholder Content --}}
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <p>Chào mừng bạn đến với trang quản lý tài khoản đo đạc!</p>
                {{-- Add Stat Cards and Recent Activity sections here later --}}
                <p class="mt-4 text-gray-600">Nội dung chi tiết cho User Dashboard sẽ được hiển thị ở đây.</p>
            </div>
        </div>
    @endsection

    @section('scripts')
        {{-- Add dashboard-specific JS if needed --}}
        <script>
            console.log('User Dashboard JS loaded.');
            // function updateDashboardStats() { ... } // Define or load specific JS here
        </script>
    @endsection
    ```

*   **`resources/views/admin/dashboard/index.blade.php`**
    ```blade
    @extends('admin.layouts.app')

    @section('title', 'Admin Dashboard')

    @section('content')
        {{-- Use the structure from the original admin.html Dashboard section --}}
        <div id="admin-dashboard"> {{-- Keep the ID if JS targets it --}}
             <h2 class="text-lg md:text-xl font-semibold text-gray-900 mb-4 md:mb-6">Admin Dashboard</h2>

             {{-- Placeholder Content --}}
             <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                 <p>Chào mừng quản trị viên!</p>
                 {{-- Add Stat Cards, Charts, Recent Activity sections here later --}}
                 <p class="mt-4 text-gray-600">Nội dung chi tiết cho Admin Dashboard sẽ được hiển thị ở đây.</p>

                 {{-- Example: Adding a Button that requires permission --}}
                 {{-- <button class="btn-primary mt-4" data-permission="some_action" onclick="handleAction()">Thực hiện Action (Test Quyền)</button> --}}
             </div>
        </div>
    @endsection

    @section('scripts')
         {{-- Add dashboard-specific JS if needed --}}
         <script>
             console.log('Admin Dashboard JS loaded.');
             // function initDashboardCharts() { ... } // Define or load specific JS here

             // Example action handling
             function handleAction() {
                 if (hasPermission('some_action')) {
                     alert('Action allowed!');
                 } else {
                     showToast('Bạn không có quyền thực hiện hành động này!', 'error');
                 }
             }
         </script>
    @endsection
