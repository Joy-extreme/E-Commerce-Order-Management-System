<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\OrderController;
use Illuminate\Foundation\Auth\EmailVerificationRequest; 
use App\Http\Controllers\CartController;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


Route::get('/verify-email/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);

    // Check that the link is still valid
    if (! $request->hasValidSignature()) {
        abort(401, 'Invalid or expired verification link.');
    }

    // Check the hash matches the expected value
    if (! hash_equals($hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Invalid verification hash.');
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    // Log in as address is verified
    Auth::login($user);

    return redirect('/dashboard')->with('status', 'E‑mail verified! Welcome aboard.');
})->middleware('signed')->name('verification.verify');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('guest')->name('verification.notice');


Route::get('/', function () {
    return view('welcome');
});

// Registration routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes (Authenticated users only)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // One shared dashboard route; controller decides what to show
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Product listing for normal users
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    
    //cart routes
    Route::post('/cart/add/{product}',   [CartController::class, 'add'   ])->name('cart.add');
    Route::get ('/cart',                 [CartController::class, 'index' ])->name('cart.index');
    Route::post('/cart/update/{id}',     [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}',     [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/empty',           [CartController::class, 'empty' ])->name('cart.empty');

    // Checkout stays in OrderController
    Route::post('/cart/checkout', [OrderController::class, 'checkout'])->name('cart.checkout');
    /*
    |--------------------------------------------------------------------------
    | Super Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:super-admin')->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('outlets', OutletController::class);
        Route::resource('products', ProductController::class);

        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::post('orders/{order}/accept', [OrderController::class, 'accept'])->name('orders.accept');
        Route::post('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
        Route::post('orders/{order}/transfer', [OrderController::class, 'transfer'])->name('orders.transfer');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        //order management routes (accept, cancel, transfer to different outlets)
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::post('orders/{order}/accept', [OrderController::class, 'accept'])->name('orders.accept');
        Route::post('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
        Route::post('orders/{order}/transfer', [OrderController::class, 'transfer'])->name('orders.transfer');
    });

    /*
    |--------------------------------------------------------------------------
    | Outlet In Charge Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:outlet-in-charge')->prefix('outlet')->name('outlet.')->group(function () {
        Route::get('orders', [OrderController::class, 'myOutletOrders'])->name('orders.index');
        Route::post('orders/{order}/accept', [OrderController::class, 'accept'])->name('orders.accept');
        Route::post('orders/{order}/transfer', [OrderController::class, 'transfer'])->name('orders.transfer');
    });
});
