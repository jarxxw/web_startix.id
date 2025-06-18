<?php

namespace App\Providers;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
       public function boot()
{

    // Tambahkan ini jika ingin menambahkan api.php
    $this->mapApiRoutes();
}

protected function mapApiRoutes()
{
    Route::prefix('api')
        ->middleware('api')
        ->namespace($this->namespace)
        ->group(base_path('routes/api.php'));
}

}

    /**
     * Bootstrap any application services.
     */
    // public function boot(): void
    // {
       
    //     ->group(base_path('routes/api.php'));
    //     Gate::define('isAdmin', function (User $user) {
    //         return $user->role === 'Admin';
    //     });

    //     Gate::define('isMahasiswa', function (User $user) {
    //         return $user->role === 'Mahasiswa';
    //     });

    //     Gate::define('isDosen', function (User $user) {
    //         return $user->role === 'Dosen';
    //     });

    //     Gate::define('isKetuaprodi', function (User $user) {
    //         return $user->role === 'Ketua Prodi';
    //     });
    // }


