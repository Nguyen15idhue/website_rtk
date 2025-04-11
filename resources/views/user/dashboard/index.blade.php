@extends('user.layouts.app') {{-- Kế thừa layout chính của user --}}

@section('title', 'Dashboard') {{-- Đặt tiêu đề trang --}}

@section('content')
    {{-- Copy cấu trúc từ user.html gốc cho phần dashboard --}}
    <div id="dashboard"> {{-- Giữ lại ID nếu JS cần dùng --}}
        <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-5 sm:mb-6">Dashboard</h2>

        {{-- Nội dung Placeholder (Bạn sẽ thay thế bằng nội dung thật sau) --}}
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <p>Chào mừng bạn đến với trang quản lý tài khoản đo đạc!</p>
            {{-- Thêm các Stat Card và Hoạt động gần đây vào đây sau --}}
            <p class="mt-4 text-gray-600">Nội dung chi tiết cho User Dashboard sẽ được hiển thị ở đây.</p>

            {{-- Ví dụ: Lấy thông tin người dùng (sẽ dùng Auth::user() sau) --}}
            {{-- <p class="mt-2">Email: {{ $user->email ?? 'N/A' }}</p> --}}
        </div>

         {{-- Phần Stat Cards (Lấy từ HTML gốc) - Thay số liệu bằng biến từ controller sau --}}
         <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8 mt-6">
            <div class="bg-white p-4 sm:p-5 rounded-lg shadow border border-gray-200 flex items-center gap-3 sm:gap-4"> <div class="p-3 rounded-full bg-primary-100 text-primary-600 shrink-0"><i class="fas fa-check-circle text-lg sm:text-xl"></i></div> <div> <p class="text-xs sm:text-sm text-gray-600">Tài khoản hoạt động</p> <h3 class="text-xl sm:text-2xl font-bold text-gray-900" id="dashboard-active-accounts">0</h3> </div> </div>
            <div class="bg-white p-4 sm:p-5 rounded-lg shadow border border-gray-200 flex items-center gap-3 sm:gap-4"> <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 shrink-0"><i class="fas fa-history text-lg sm:text-xl"></i></div> <div> <p class="text-xs sm:text-sm text-gray-600">Giao dịch chờ xử lý</p> <h3 class="text-xl sm:text-2xl font-bold text-gray-900" id="dashboard-pending-transactions">0</h3> </div> </div>
            <div class="bg-white p-4 sm:p-5 rounded-lg shadow border border-gray-200 flex items-center gap-3 sm:gap-4"> <div class="p-3 rounded-full bg-blue-100 text-blue-600 shrink-0"><i class="fas fa-users text-lg sm:text-xl"></i></div> <div> <p class="text-xs sm:text-sm text-gray-600">Người đã giới thiệu</p> <h3 class="text-xl sm:text-2xl font-bold text-gray-900" id="dashboard-referrals-count">0</h3> </div> </div>
         </div>

         {{-- Phần Hoạt động gần đây (Lấy từ HTML gốc) - Thay bằng dữ liệu động sau --}}
         <div class="bg-white p-4 sm:p-6 rounded-lg shadow border border-gray-200">
             <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-4">Hoạt động gần đây</h3>
             <div id="dashboard-recent-activity" class="space-y-4 sm:space-y-5">
                 <p class="text-gray-500 italic">Chưa có hoạt động nào.</p>
                 {{-- Dữ liệu động sẽ được thêm vào đây bằng JS hoặc loop trong Blade --}}
             </div>
         </div>

    </div>
@endsection

@section('scripts')
    {{-- Thêm JS cụ thể cho trang dashboard nếu cần --}}
    <script>
        console.log('User Dashboard JS loaded.');
        // function updateDashboardStats() { /* Cần định nghĩa lại ở đây hoặc trong file JS riêng */ }
        // Cập nhật số liệu demo nếu muốn
        // document.getElementById('dashboard-active-accounts').innerText = '1'; // Ví dụ
        // updateDashboardStats(); // Gọi hàm cập nhật nếu có
    </script>
@endsection
