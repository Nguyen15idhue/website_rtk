<?php

namespace App\Http\Controllers\User; // Đảm bảo đúng namespace

use App\Http\Controllers\Controller; // Kế thừa Controller cơ sở
use Illuminate\Http\Request;
use Illuminate\View\View;          // Import View class

class DashboardController extends Controller // Đảm bảo đúng tên class và kế thừa
{
    /**
     * Hiển thị trang dashboard của người dùng.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View // Đây là phương thức mà route đang gọi
    {
        // Trong tương lai, bạn sẽ lấy dữ liệu từ database hoặc service ở đây
        // Ví dụ: $activeAccounts = Auth::user()->activeSurveyAccounts()->count();
        // $pendingTransactions = Auth::user()->pendingTransactions()->count();
        // $data = compact('activeAccounts', 'pendingTransactions');

        // Hiện tại chỉ trả về view
        return view('user.dashboard.index'); // Trả về file view bạn đã tạo
    }
}
