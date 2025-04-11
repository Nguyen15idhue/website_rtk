@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('header', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Người dùng</div>
            <div class="card-body">
                <h5 class="card-title">{{ $usersCount }}</h5>
                <p class="card-text">Tổng số người dùng trong hệ thống</p>
            </div>
        </div>
    </div>

    <!-- Thêm các card thống kê khác -->
</div>
@endsection
