<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
// Thêm các model khác nếu cần

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Đếm số lượng users
        $usersCount = User::count();

        // Thêm các dữ liệu khác mà bạn cần hiển thị trong dashboard

        return view('admin.dashboard', compact('usersCount'));
    }
}
