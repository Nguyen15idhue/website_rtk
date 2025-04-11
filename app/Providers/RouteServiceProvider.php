<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/user/dashboard'; // Hoặc '/admin' nếu bạn muốn admin là home

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // API Routes
            Route::middleware('api')
                ->prefix('api') // Tiền tố /api/ cho các API routes
                ->group(base_path('routes/api.php'));

            // Web Routes (User facing)
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // --- THÊM ĐOẠN NÀY ĐỂ ĐĂNG KÝ ADMIN ROUTES ---
            Route::middleware('web') // Sử dụng middleware 'web' (hoặc nhóm middleware tùy chỉnh cho admin sau này)
                ->prefix('admin') // Tự động thêm /admin/ vào trước URL
                ->as('admin.')    // Tự động thêm 'admin.' vào trước tên route (ví dụ: route('admin.dashboard'))
                ->group(base_path('routes/admin.php'));
            // --- KẾT THÚC PHẦN THÊM ---

        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
