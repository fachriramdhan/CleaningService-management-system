<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Koordinator\DashboardController as KoordinatorDashboardController;
use App\Http\Controllers\CS\DashboardController as CSDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CS Management
    Route::resource('cs', \App\Http\Controllers\Admin\CsController::class);
    Route::post('cs/{id}/toggle-status', [\App\Http\Controllers\Admin\CsController::class, 'toggleStatus'])->name('cs.toggle-status');

    // Area Management
    Route::resource('area', \App\Http\Controllers\Admin\AreaController::class);

    // ATM Management
    Route::resource('atm', \App\Http\Controllers\Admin\AtmController::class);

    // Monitoring
    Route::get('/monitoring/absensi', [\App\Http\Controllers\Admin\MonitoringController::class, 'absensi'])->name('monitoring.absensi');
    Route::get('/monitoring/laporan', [\App\Http\Controllers\Admin\MonitoringController::class, 'laporan'])->name('monitoring.laporan');
    Route::get('/monitoring/laporan/{id}', [\App\Http\Controllers\Admin\MonitoringController::class, 'detailLaporan'])->name('monitoring.detail-laporan');
    Route::get('/monitoring/laporan-harian', [\App\Http\Controllers\Admin\MonitoringController::class, 'laporanHarian'])->name('monitoring.laporan-harian');

    // Inventory Management
    Route::resource('inventory', \App\Http\Controllers\Admin\InventoryController::class);
    Route::post('inventory/{id}/tambah-stok', [\App\Http\Controllers\Admin\InventoryController::class, 'tambahStok'])->name('inventory.tambah-stok');
    Route::post('inventory/{id}/kurangi-stok', [\App\Http\Controllers\Admin\InventoryController::class, 'kurangiStok'])->name('inventory.kurangi-stok');

    // Permintaan Inventory
    Route::get('/permintaan', [\App\Http\Controllers\Admin\PermintaanInventoryController::class, 'index'])->name('permintaan.index');
    Route::get('/permintaan/{id}', [\App\Http\Controllers\Admin\PermintaanInventoryController::class, 'show'])->name('permintaan.show');
    Route::post('/permintaan/{id}/approve', [\App\Http\Controllers\Admin\PermintaanInventoryController::class, 'approve'])->name('permintaan.approve');
    Route::post('/permintaan/{id}/reject', [\App\Http\Controllers\Admin\PermintaanInventoryController::class, 'reject'])->name('permintaan.reject');
});

// Koordinator Routes
Route::middleware(['auth', 'role:koordinator'])->prefix('koordinator')->name('koordinator.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Koordinator\DashboardController::class, 'index'])->name('dashboard');

    // Monitoring Routes (TAMBAHKAN INI)
    Route::get('/monitoring/absensi', [\App\Http\Controllers\Koordinator\MonitoringController::class, 'absensi'])->name('monitoring.absensi');
    Route::get('/monitoring/laporan', [\App\Http\Controllers\Koordinator\MonitoringController::class, 'laporan'])->name('monitoring.laporan');
    Route::get('/monitoring/laporan/{id}', [\App\Http\Controllers\Koordinator\MonitoringController::class, 'detailLaporan'])->name('monitoring.detail-laporan');

    // View Permintaan (Read Only) - TAMBAHKAN INI
    Route::get('/permintaan', [\App\Http\Controllers\Koordinator\PermintaanController::class, 'index'])->name('permintaan.index');
    Route::get('/permintaan/{id}', [\App\Http\Controllers\Koordinator\PermintaanController::class, 'show'])->name('permintaan.show');

});

// CS Routes
Route::middleware(['auth', 'role:cs'])->prefix('cs')->name('cs.')->group(function () {
    Route::get('/dashboard', [CSDashboardController::class, 'index'])->name('dashboard');

    // Absensi
    Route::resource('absensi', \App\Http\Controllers\CS\AbsensiController::class)->only(['index', 'create', 'store', 'show']);

    // Laporan ATM
    Route::resource('laporan', \App\Http\Controllers\CS\LaporanAtmController::class)->only(['index', 'create', 'store', 'show']);

    // Monitoring
    Route::get('/monitoring/absensi', [\App\Http\Controllers\Koordinator\MonitoringController::class, 'absensi'])->name('monitoring.absensi');
    Route::get('/monitoring/laporan', [\App\Http\Controllers\Koordinator\MonitoringController::class, 'laporan'])->name('monitoring.laporan');
    Route::get('/monitoring/laporan/{id}', [\App\Http\Controllers\Koordinator\MonitoringController::class, 'detailLaporan'])->name('monitoring.detail-laporan');

    // Permintaan Inventory
    Route::resource('permintaan', \App\Http\Controllers\CS\PermintaanInventoryController::class)->only(['index', 'create', 'store', 'show']);
});

// HRIS Module Routes
require __DIR__.'/hris-routes.php';

require __DIR__.'/auth.php';