<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use App\Models\CartItem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gunakan styling Bootstrap 5 untuk Paginator Laravel
        Paginator::useBootstrapFive();

        // Bagikan variabel $cartCount ke komponen navigation secara otomatis
        View::composer('layouts.navigation', function ($view) {
            $cartCount = Auth::check() 
                ? CartItem::where('user_id', Auth::id())->sum('quantity') 
                : 0;

            $view->with('cartCount', $cartCount);
        });
    }
}