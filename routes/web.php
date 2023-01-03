<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\ExpenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StockManageController;
use App\Http\Controllers\Auth\EmployeeLoginController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

/**
 * Auth Routes
 */
Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

/**
 * User Routes
 */
Route::prefix('/user')->group(function () {
    Route::POST('/login', [EmployeeLoginController::class, 'login'])->name('user.login');
    Route::GET('/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::PUT('/profile/update/{id}', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::GET('/profile/password/reset', [ProfileController::class, 'passwordReset'])->name('user.password.reset');
    Route::PUT('/profile/password/chenge', [ProfileController::class, 'passwordChenge'])->name('user.password.chenge');
});

/**
 * Salse Management Routes
 */
Route::prefix('/sales')->group(function () {
    Route::GET('/card-sales', [SalesController::class, 'card'])->name('sales.card')->middleware(['can:কার্ড বিক্রয়']);
    Route::GET('/service-sales', [SalesController::class, 'package'])->name('sales.package')->middleware(['can:সার্ভিস বিক্রয়']);
    Route::GET('/card-sales-report', [SalesController::class, 'report'])->name('sales.report')->middleware(['can:কার্ড বিক্রয় প্রতিবেদন']);
    Route::GET('/sales-total-report', [SalesController::class, 'totalReport'])->name('sales.totalReport')->middleware(['can:সার্ভিস বিক্রয় প্রতিবেদন']);

    /**
     * Service Salse Route
     * Protected Routes
     */
    Route::middleware(['can:সার্ভিস বিক্রয়'])->group(function () {
        Route::GET('/service-sales/stock-list/{id}', [SalesController::class, 'stockList'])->name('salse.packge-sales.stock-list');
        Route::GET('/service-sales/product/{id}', [SalesController::class, 'product'])->name('salse.packge-sales.product');
        Route::POST('/service-sales/product/store', [SalesController::class, 'productStore'])->name('salse.packge-sales.store');
    });

    Route::DELETE('/service-sales/product/delete/{id}', [SalesController::class, 'productDelete'])->name('salse.packge-sales.delete')->middleware(['can:সার্ভিস ডিলিট']);
    Route::GET('/service-sales/product/edit/{id}', [SalesController::class, 'productEdit'])->name('salse.packge-sales.edit')->middleware(['can:সার্ভিস ইডিট']);
    Route::PUT('/service-sales/product/update/{id}', [SalesController::class, 'productUpdate'])->name('salse.packge-sales.update')->middleware(['can:সার্ভিস ইডিট']);

    // Card Sales Route
    Route::POST('/card-sales/store', [SalesController::class, 'cardStore'])->name('sales.card.store')->middleware(['can:কার্ড বিক্রয়']);
    Route::DELETE('/card-sales/delete/{id}', [SalesController::class, 'cardDelete'])->name('sales.card.delete');
    Route::GET('/card-sales/edit/{id}', [SalesController::class, 'cardEdit'])->name('sales.card.edit');
    Route::PUT('/card-sales/update/{id}', [SalesController::class, 'cardUpdate'])->name('sales.card.update');
    Route::POST('/card-sales/approve', [SalesController::class, 'cardApprove'])->name('sales.card.approve')->middleware(['can:কার্ড অনুমোদন']);
    Route::GET('/card-sales/tamadi', [SalesController::class, 'cardTamadi'])->name('sales.card.tamadi')->middleware(['can:কার্ড বিক্রয় তামাদি']);
});

/**
 * Salary Management Routes
 */
Route::prefix('/salary')->group(function () {
    Route::GET('/sales-report', [SalaryController::class, 'salesReport'])->name('salary.salesReport')->middleware(['can:কার্ড বিক্রয় রিপোর্ট']);
    /**
     * Protected Routes
     */
    Route::middleware(['can:বেতন ফরম'])->group(function () {
        Route::GET('/', [SalaryController::class, 'salaryForm'])->name('salary.form');
        Route::POST('/store', [SalaryController::class, 'store'])->name('salary.store');
        Route::POST('/store/value', [SalaryController::class, 'storeValue'])->name('salary.store.value');
        Route::DELETE('/store/delete/{id}', [SalaryController::class, 'delete'])->name('salary.delete');
        Route::GET('/store/edit/{id}', [SalaryController::class, 'edit'])->name('salary.edit');
        Route::PUT('/store/update/{id}', [SalaryController::class, 'update'])->name('salary.update');
    });
});

/**
 * Stock Management Routes
 */
Route::prefix('/stock')->group(function () {
    Route::GET('/management', [StockManageController::class, 'index'])->name('stock.management')->middleware(['can:স্টক']);
    Route::POST('/store', [StockManageController::class, 'store'])->name('stock.store')->middleware(['can:স্টক রেজিস্ট্রেশন']);
    Route::GET('/edit/{id}', [StockManageController::class, 'edit'])->name('stock.edit')->middleware(['can:স্টক ইডিট']);
    Route::PUT('/update/{id}', [StockManageController::class, 'update'])->name('stock.update')->middleware(['can:স্টক ইডিট']);
    Route::DELETE('/delete/{id}', [StockManageController::class, 'delete'])->name('stock.delete')->middleware(['can:স্টক ডিলিট']);
});

/**
 * Category Management Routes
 */
Route::prefix('/category')->group(function () {
    Route::GET('/management', [CategoryController::class, 'index'])->name('category.management')->middleware(['can:ক্যাটাগরি']);
    Route::POST('/store', [CategoryController::class, 'store'])->name('category.store')->middleware(['can:ক্যাটাগরি রেজিস্ট্রেশন']);
    Route::GET('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit')->middleware(['can:ক্যাটাগরি ইডিট']);
    Route::PUT('/update/{id}', [CategoryController::class, 'update'])->name('category.update')->middleware(['can:ক্যাটাগরি ইডিট']);
    Route::DELETE('/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete')->middleware(['can:ক্যাটাগরি ডিলিট']);
});

/**
 * Employee Management Routes
 */
Route::prefix('/employee')->group(function () {
    Route::GET('/', [EmployeeController::class, 'index'])->name('employee.all')->middleware(['can:অফিসার']);
    Route::POST('/registration', [EmployeeController::class, 'registration'])->name('employee.add')->middleware(['can:অফিসার রেজিস্ট্রেশন']);
    Route::POST('/status/{id}', [EmployeeController::class, 'status'])->name('employee.status')->middleware(['can:অফিসার স্ট্যাটাস পরিবর্তন']);
    Route::GET('/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit')->middleware(['can:অফিসার ইডিট']);
    Route::PUT('/update/{id}', [EmployeeController::class, 'update'])->name('employee.update')->middleware(['can:অফিসার ইডিট']);
});

/**
 * Expence Management Routes
 */
Route::prefix('/expence')->group(function () {
    Route::GET('/', [ExpenceController::class, 'index'])->name('expenece')->middleware(['can:ব্যয়']);
    Route::POST('/store', [ExpenceController::class, 'store'])->name('expenece.store')->middleware(['can:ব্যয় রেজিস্ট্রেশন']);
    Route::DELETE('/delete/{id}', [ExpenceController::class, 'delete'])->name('expenece.delete')->middleware(['can:ব্যয় ডিলিট']);
    Route::GET('/edit/{id}', [ExpenceController::class, 'edit'])->name('expenece.edit')->middleware(['can:ব্যয় ইডিট']);
    Route::PUT('/update/{id}', [ExpenceController::class, 'update'])->name('expenece.update')->middleware(['can:ব্যয় ইডিট']);

    /**
     * Officer Expence
     * Protected Routes
     */
    Route::middleware(['can:অফিসার দৈনিক ব্যয়'])->group(function () {
        Route::GET('/officer/expence', [ExpenceController::class, 'officerExpence'])->name('expenece.officer');
        Route::POST('/officer/expence/store', [ExpenceController::class, 'officerExpenceStore'])->name('expenece.officer.store');
        Route::DELETE('/officer/expence/delete/{id}', [ExpenceController::class, 'officerExpenceDelete'])->name('expenece.officer.delete');
        Route::GET('/officer/expence/edit/{id}', [ExpenceController::class, 'officerExpenceEdit'])->name('expenece.officer.edit');
        Route::PUT('/officer/expence/update/{id}', [ExpenceController::class, 'officerExpenceUpdate'])->name('expenece.officer.update');
    });
});

/**
 * settings Management Routes
 * Protected Routes
 */
Route::middleware(['can:সেটিংস'])->group(function () {
    Route::prefix('/settings')->group(function () {
        Route::GET('/', [SettingsController::class, 'index'])->name('settings');
        Route::PUT('/update/{id}', [SettingsController::class, 'Update'])->name('settings.update');
    });
});

/**
 * Role Management Routes
 */
Route::prefix('/roles')->group(function () {
    Route::GET('/', [RolesController::class, 'index'])->name('roles')->middleware(['can:পদবি এবং অনুমতি']);
    Route::POST('/store', [RolesController::class, 'store'])->name('roles.store')->middleware(['can:পদবি এবং অনুমতি রেজিস্ট্রেশন']);
    Route::GET('/edit/{id}', [RolesController::class, 'edit'])->name('roles.edit')->middleware(['can:পদবি এবং অনুমতি ইডিট']);
    Route::PUT('/update/{id}', [RolesController::class, 'update'])->name('roles.update')->middleware(['can:পদবি এবং অনুমতি ইডিট']);
});

/**
 * Accounts Calculations Routes
 */
Route::prefix('/accounts/calculations')->group(function () {
    Route::GET('/', [AccountsController::class, 'index'])->name('accounts.calculations')->middleware(['can:হিসাব']);
    Route::GET('/share', [AccountsController::class, 'shareAccounts'])->name('accounts.calculations.share')->middleware(['can:শেয়ার হিসাব']);
});

Route::prefix('/print')->group(function () {
    Route::GET('/card/sales/report/{daterange}/{officer_id}', [printController::class, 'salesReport'])->name('sales.report.print');
    Route::GET('/salary/report/{id}', [PrintController::class, 'salaryPrint'])->name('salary.print');
    Route::GET('/accounts/calculations/report/{month}', [PrintController::class, 'accCalculationsPrint'])->name('acc.calculations.print');
    Route::GET('/accounts/calculations/share/report/{month}', [PrintController::class, 'shareAccCalculationsPrint'])->name('acc.calculations.share.print');
});
