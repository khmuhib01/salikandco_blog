<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\admin\CategoriesController;
use App\Http\Controllers\admin\ContentController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\frontend\FrontendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [FrontendController::class, 'index']);
Route::get('/login', [LoginController::class, 'show']);
Auth::routes(['register' => false, 'verify' => false]);

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'admin', 'middleware' => ['auth', 'admin']], function(){
    //Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Categories
    Route::get('/categories/show',[CategoriesController::class, 'show'])->name('categories.show');
    Route::post('/categories/store', [CategoriesController::class, 'store'])->name('categories.store');
    Route::post('/categories/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/update', [CategoriesController::class, 'update'])->name('categories.update');
    Route::post('/categories/destroy', [CategoriesController::class, 'destroy'])->name('categories.destroy');
    Route::post('/categories/sort', [CategoriesController::class, 'sort'])->name('categories.sort');

    //Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('update');
    Route::get('/change-password', [ProfileController::class, 'change_password'])->name('change_password');
    Route::put('/update-password/{id}/update', [ProfileController::class, 'update_password'])->name('update_password');

    //content
    Route::get('/content',[ContentController::class, 'index'])->name('content');
    Route::post('/content/store',[ContentController::class, 'store'])->name('content.store');
    Route::get('/content/show',[ContentController::class, 'show'])->name('content.show');
    Route::get('/content/{id}/edit', [ContentController::class, 'edit'])->name('content.edit');
    Route::post('/content/update', [ContentController::class, 'update'])->name('content.update');
    Route::post('/content/destroy', [ContentController::class, 'destroy'])->name('content.destroy');
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/category/{category}', [FrontendController::class, 'getCategoriesList']);
Route::get('/{slug}', [FrontendController::class, 'getContentDetails']);
