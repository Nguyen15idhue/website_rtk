<?php

namespace App\Http\Controllers\Admin; // Đảm bảo đúng namespace

use App\Http\Controllers\Controller; // Kế thừa Controller cơ sở
use Illuminate\Http\Request;
use Illuminate\View\View;          // Import View class

class DashboardController extends Controller // Đảm bảo đúng tên class và kế thừa
{
    /**
     * Hiển thị trang dashboard của quản trị viên.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View // Đây là phương thức mà route đang gọi
    {
        // Trong tương lai, bạn sẽ lấy dữ liệu tổng hợp ở đây
        // Ví dụ: $totalUsers = \App\Models\User::count();
        // $totalRevenue = \App\Models\Transaction::where('status','approved')->sum('amount');
        // $data = compact('totalUsers', 'totalRevenue');

        // Hiện tại chỉ trả về view
        return view('admin.dashboard.index'); // Trả về file view bạn đã tạo
    }
}
