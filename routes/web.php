<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\GroupController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

// プロフィール関連
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


// カテゴリ関連
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::resource('categories', CategoryController::class)->except(['create', 'store'])->middleware('auth');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');


// 活動（時間）関連
Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
Route::get('/activities',[ActivityController::class,'index'])->name('activities.index');
//統計
Route::get('/activities/index_show', [ActivityController::class, 'indexShow'])->name('activities.index_show');
Route::get('activities/week', [ActivityController::class, 'showWeek'])->name('activities.showWeek');
Route::get('activities/month', [ActivityController::class, 'showMonth'])->name('activities.showMonth');



//edit and update
Route::get('/activities/{id}', [ActivityController::class, 'show'])->name('activities.show');
Route::get('/activities/{id}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
Route::put('/activities/{id}', [ActivityController::class, 'update'])->name('activities.update');
Route::delete('/activities/{id}', [ActivityController::class, 'destroy'])->name('activities.destroy');

//グループ関連
Route::get('/groups/dashboard', [GroupController::class, 'dashboard'])->name('groups.dashboard');
Route::get('/groups/index', [GroupController::class, 'index'])->name('groups.index');
Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
Route::post('/groups/store', [GroupController::class, 'store'])->name('groups.store');

Route::get('/groups/search', [GroupController::class, 'search'])->name('groups.search');
Route::get('/groups/search-results',[GroupController::class, 'searchresults'] )->name('groups.searchresults');
Route::get('/groups/{group}/show', [GroupController::class, 'show'])->name('groups.show');
Route::post('/groups/{group}/join', [GroupController::class, 'join'])->name('groups.join');
Route::delete('/groups/{group}/leave', [GroupController::class, 'leave'])->name('groups.leave');
Route::delete('/groups/{group}', [GroupController::class, 'destroy'])->name('groups.destroy');
Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])->name('groups.edit');
Route::put('/groups/{group}/update', [GroupController::class, 'update'])->name('groups.update');

});

//グループメンバー機能関連


// 認証関連のルーティング
require __DIR__.'/auth.php';

