<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Leave\LeaveRequestController as AdminLeaveRequestController;
use App\Http\Controllers\Admin\Performance\PerformanceReviewController as AdminPerformanceReviewController;
use App\Http\Controllers\Admin\Employee\EmployeeDocumentController;
use App\Http\Controllers\Admin\Shift\ShiftScheduleController as AdminShiftScheduleController;
use App\Http\Controllers\Koordinator\Leave\LeaveApprovalController;
use App\Http\Controllers\Koordinator\Performance\PerformanceReviewController as KoordinatorPerformanceReviewController;
use App\Http\Controllers\CS\Leave\LeaveRequestController as CSLeaveRequestController;
use App\Http\Controllers\CS\Performance\PerformanceViewController;
use App\Http\Controllers\CS\Profile\ProfileController;
use App\Http\Controllers\CS\Profile\DocumentUploadController;
use App\Http\Controllers\CS\Shift\ShiftViewController;
use App\Http\Controllers\CS\Shift\ShiftRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes - HRIS Modules
|--------------------------------------------------------------------------
|
| Here are the routes for HRIS modules:
| - Leave Management
| - Performance Review
| - Employee Self-Service
| - Shift Management
|
*/

// ============================================================================
// ADMIN ROUTES
// ============================================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // ----------------------------------------------------------------------
    // LEAVE MANAGEMENT
    // ----------------------------------------------------------------------
    Route::prefix('leave')->name('leave.')->group(function () {
        Route::get('/', [AdminLeaveRequestController::class, 'index'])->name('index');
        Route::get('create', [AdminLeaveRequestController::class, 'create'])->name('create');
        Route::post('/', [AdminLeaveRequestController::class, 'store'])->name('store');
        Route::get('{id}', [AdminLeaveRequestController::class, 'show'])->name('show');

        // Approval routes
        Route::get('approval/pending', [AdminLeaveRequestController::class, 'approval'])->name('approval');
        Route::post('{id}/approve', [AdminLeaveRequestController::class, 'approve'])->name('approve');
        Route::post('{id}/reject', [AdminLeaveRequestController::class, 'reject'])->name('reject');
        Route::post('{id}/cancel', [AdminLeaveRequestController::class, 'cancel'])->name('cancel');

        // History & Balance
        Route::get('history/all', [AdminLeaveRequestController::class, 'history'])->name('history');
        Route::get('balance/{csProfileId}', [AdminLeaveRequestController::class, 'balanceDetail'])->name('balance-detail');
    });

    // ----------------------------------------------------------------------
    // PERFORMANCE REVIEW
    // ----------------------------------------------------------------------
    Route::prefix('performance')->name('performance.')->group(function () {
        Route::get('/', [AdminPerformanceReviewController::class, 'index'])->name('index');
        Route::get('create', [AdminPerformanceReviewController::class, 'create'])->name('create');
        Route::post('/', [AdminPerformanceReviewController::class, 'store'])->name('store');
        Route::get('{id}', [AdminPerformanceReviewController::class, 'show'])->name('show');
        Route::get('{id}/edit', [AdminPerformanceReviewController::class, 'edit'])->name('edit');
        Route::put('{id}', [AdminPerformanceReviewController::class, 'update'])->name('update');
        Route::delete('{id}', [AdminPerformanceReviewController::class, 'destroy'])->name('destroy');

        // Special actions
        Route::post('{id}/finalize', [AdminPerformanceReviewController::class, 'finalize'])->name('finalize');
        Route::post('generate', [AdminPerformanceReviewController::class, 'generate'])->name('generate');
        Route::get('report/analytics', [AdminPerformanceReviewController::class, 'report'])->name('report');
    });

    // ----------------------------------------------------------------------
    // EMPLOYEE DOCUMENTS
    // ----------------------------------------------------------------------
    Route::prefix('employee/documents')->name('employee.documents.')->group(function () {
        Route::get('/', [EmployeeDocumentController::class, 'index'])->name('index');
        Route::get('cs/{csProfileId}', [EmployeeDocumentController::class, 'showByCs'])->name('by-cs');
        Route::get('{id}', [EmployeeDocumentController::class, 'show'])->name('show');
        Route::post('{id}/verify', [EmployeeDocumentController::class, 'verify'])->name('verify');
        Route::post('{id}/unverify', [EmployeeDocumentController::class, 'unverify'])->name('unverify');
        Route::delete('{id}', [EmployeeDocumentController::class, 'destroy'])->name('destroy');
        Route::get('{id}/download', [EmployeeDocumentController::class, 'download'])->name('download');
        Route::get('report/completion', [EmployeeDocumentController::class, 'completionReport'])->name('completion-report');
    });

    // ----------------------------------------------------------------------
    // SHIFT MANAGEMENT
    // ----------------------------------------------------------------------
    Route::prefix('shift')->name('shift.')->group(function () {
        Route::get('/', [AdminShiftScheduleController::class, 'index'])->name('index');
        Route::get('create', [AdminShiftScheduleController::class, 'create'])->name('create');
        Route::post('generate', [AdminShiftScheduleController::class, 'generate'])->name('generate');
        Route::get('{id}/edit', [AdminShiftScheduleController::class, 'edit'])->name('edit');
        Route::put('{id}', [AdminShiftScheduleController::class, 'update'])->name('update');
        Route::delete('delete', [AdminShiftScheduleController::class, 'destroy'])->name('destroy');

        // Request management
        Route::get('requests', [AdminShiftScheduleController::class, 'requests'])->name('requests');
        Route::post('requests/{id}/approve', [AdminShiftScheduleController::class, 'approveRequest'])->name('requests.approve');
        Route::post('requests/{id}/reject', [AdminShiftScheduleController::class, 'rejectRequest'])->name('requests.reject');

        // Publishing & Reports
        Route::post('publish', [AdminShiftScheduleController::class, 'publish'])->name('publish');
        Route::get('summary', [AdminShiftScheduleController::class, 'summary'])->name('summary');
    });
});

// ============================================================================
// KOORDINATOR ROUTES
// ============================================================================
Route::middleware(['auth', 'role:koordinator'])->prefix('koordinator')->name('koordinator.')->group(function () {

    // ----------------------------------------------------------------------
    // LEAVE APPROVAL
    // ----------------------------------------------------------------------
    Route::prefix('leave')->name('leave.')->group(function () {
        Route::get('approval', [LeaveApprovalController::class, 'index'])->name('approval');
        Route::get('{id}', [LeaveApprovalController::class, 'show'])->name('show');
        Route::post('{id}/approve', [LeaveApprovalController::class, 'approve'])->name('approve');
        Route::post('{id}/reject', [LeaveApprovalController::class, 'reject'])->name('reject');
        Route::get('history/all', [LeaveApprovalController::class, 'history'])->name('history');
        Route::get('summary/team', [LeaveApprovalController::class, 'summary'])->name('summary');
    });

    // ----------------------------------------------------------------------
    // PERFORMANCE REVIEW
    // ----------------------------------------------------------------------
    Route::prefix('performance')->name('performance.')->group(function () {
        Route::get('/', [KoordinatorPerformanceReviewController::class, 'index'])->name('index');
        Route::get('create', [KoordinatorPerformanceReviewController::class, 'create'])->name('create');
        Route::post('/', [KoordinatorPerformanceReviewController::class, 'store'])->name('store');
        Route::get('{id}', [KoordinatorPerformanceReviewController::class, 'show'])->name('show');
        Route::get('{id}/edit', [KoordinatorPerformanceReviewController::class, 'edit'])->name('edit');
        Route::put('{id}', [KoordinatorPerformanceReviewController::class, 'update'])->name('update');
        Route::post('{id}/auto-calculate', [KoordinatorPerformanceReviewController::class, 'autoCalculate'])->name('auto-calculate');
        Route::get('summary/team', [KoordinatorPerformanceReviewController::class, 'summary'])->name('summary');
    });
});

// ============================================================================
// CS (CLEANING SERVICE) ROUTES
// ============================================================================
Route::middleware(['auth', 'role:cs'])->prefix('cs')->name('cs.')->group(function () {

    // ----------------------------------------------------------------------
    // LEAVE REQUESTS
    // ----------------------------------------------------------------------
    Route::prefix('leave')->name('leave.')->group(function () {
        Route::get('/', [CSLeaveRequestController::class, 'index'])->name('index');
        Route::get('create', [CSLeaveRequestController::class, 'create'])->name('create');
        Route::post('/', [CSLeaveRequestController::class, 'store'])->name('store');
        Route::get('{id}', [CSLeaveRequestController::class, 'show'])->name('show');
        Route::post('{id}/cancel', [CSLeaveRequestController::class, 'cancel'])->name('cancel');
        Route::get('balance/history', [CSLeaveRequestController::class, 'balance'])->name('balance');
    });

    // ----------------------------------------------------------------------
    // PERFORMANCE VIEW
    // ----------------------------------------------------------------------
    Route::prefix('performance')->name('performance.')->group(function () {
        Route::get('/', [PerformanceViewController::class, 'index'])->name('index');
        Route::get('{id}', [PerformanceViewController::class, 'show'])->name('show');
        Route::get('history/trend', [PerformanceViewController::class, 'history'])->name('history');
        Route::get('current/month', [PerformanceViewController::class, 'current'])->name('current');
    });

    // ----------------------------------------------------------------------
    // PROFILE (ESS)
    // ----------------------------------------------------------------------
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('update', [ProfileController::class, 'update'])->name('update');
        Route::put('account', [ProfileController::class, 'updateAccount'])->name('update-account');
        Route::get('completion-guide', [ProfileController::class, 'completionGuide'])->name('completion-guide');

        // Documents
        Route::get('documents', [DocumentUploadController::class, 'index'])->name('documents');
        Route::get('documents/create', [DocumentUploadController::class, 'create'])->name('documents.create');
        Route::post('documents', [DocumentUploadController::class, 'store'])->name('documents.store');
        Route::get('documents/{id}', [DocumentUploadController::class, 'show'])->name('documents.show');
        Route::delete('documents/{id}', [DocumentUploadController::class, 'destroy'])->name('documents.destroy');
        Route::get('documents/{id}/download', [DocumentUploadController::class, 'download'])->name('documents.download');
    });

    // ----------------------------------------------------------------------
    // SHIFT SCHEDULE
    // ----------------------------------------------------------------------
    Route::prefix('shift')->name('shift.')->group(function () {
        Route::get('/', [ShiftViewController::class, 'index'])->name('index');
        Route::get('calendar', [ShiftViewController::class, 'calendar'])->name('calendar');
        Route::get('preview', [ShiftViewController::class, 'preview'])->name('preview');
        Route::get('history', [ShiftViewController::class, 'history'])->name('history');

        // Shift Requests
        Route::get('requests', [ShiftRequestController::class, 'index'])->name('requests.index');
        Route::get('requests/create', [ShiftRequestController::class, 'create'])->name('requests.create');
        Route::post('requests', [ShiftRequestController::class, 'store'])->name('requests.store');
        Route::get('requests/{id}', [ShiftRequestController::class, 'show'])->name('requests.show');
        Route::post('requests/{id}/cancel', [ShiftRequestController::class, 'cancel'])->name('requests.cancel');
        Route::get('requests/guide/info', [ShiftRequestController::class, 'guide'])->name('requests.guide');
    });
});

// ============================================================================
// SHARED ROUTES (Accessible by multiple roles)
// ============================================================================
Route::middleware(['auth'])->group(function () {

    // Dashboard redirects based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'koordinator' => redirect()->route('koordinator.dashboard'),
            'cs' => redirect()->route('cs.dashboard'),
            default => redirect()->route('login'),
        };
    })->name('dashboard');

    // HRIS Module Landing (if needed)
    Route::get('/hris', function () {
        $user = auth()->user();

        return match($user->role) {
            'admin' => redirect()->route('admin.leave.index'),
            'koordinator' => redirect()->route('koordinator.leave.approval'),
            'cs' => redirect()->route('cs.profile.index'),
            default => redirect()->route('login'),
        };
    })->name('hris.index');
});

// ============================================================================
// API ROUTES (Optional - for future mobile app)
// ============================================================================
Route::middleware(['auth:sanctum'])->prefix('api/v1')->name('api.')->group(function () {

    // Leave API
    Route::prefix('leave')->name('leave.')->group(function () {
        Route::get('balance', [CSLeaveRequestController::class, 'balance'])->name('balance');
        Route::get('requests', [CSLeaveRequestController::class, 'index'])->name('requests');
        Route::post('requests', [CSLeaveRequestController::class, 'store'])->name('requests.store');
    });

    // Performance API
    Route::prefix('performance')->name('performance.')->group(function () {
        Route::get('reviews', [PerformanceViewController::class, 'index'])->name('reviews');
        Route::get('current', [PerformanceViewController::class, 'current'])->name('current');
    });

    // Shift API
    Route::prefix('shift')->name('shift.')->group(function () {
        Route::get('schedule', [ShiftViewController::class, 'index'])->name('schedule');
        Route::post('requests', [ShiftRequestController::class, 'store'])->name('requests.store');
    });
});
