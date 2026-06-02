<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SparePartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\RepairRequestController as CustomerRepairRequestController;
use App\Http\Controllers\Admin\RepairRequestController as AdminRepairRequestController;
use App\Http\Controllers\Technician\RepairTaskController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Customer\InvoiceController as CustomerInvoiceController;
use App\Http\Controllers\Customer\PaymentController as CustomerPaymentController;
use App\Http\Controllers\Customer\ReceiptController as CustomerReceiptController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\TechnicianController as AdminTechnicianController;
use App\Http\Controllers\Admin\DeviceController as AdminDeviceController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;




Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::resource('spare-parts', SparePartController::class);

        Route::get('/reports', [AdminReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/devices', [AdminDeviceController::class, 'index'])
            ->name('devices.index');

        Route::get('/devices/{device}', [AdminDeviceController::class, 'show'])
            ->name('devices.show');

        Route::get('/customers', [AdminCustomerController::class, 'index'])
            ->name('customers.index');

        Route::get('/customers/{customer}', [AdminCustomerController::class, 'show'])
            ->name('customers.show');

        Route::get('/repair-requests', [AdminRepairRequestController::class, 'index'])
            ->name('repair-requests.index');

        Route::get('/repair-requests/{repairRequest}', [AdminRepairRequestController::class, 'show'])
            ->name('repair-requests.show');

        Route::get('/payments', [AdminPaymentController::class, 'index'])
            ->name('payments.index');

        Route::get('/payments/{payment}', [AdminPaymentController::class, 'show'])
            ->name('payments.show');

        Route::patch('/repair-requests/{repairRequest}/approve', [AdminRepairRequestController::class, 'approve'])
            ->name('repair-requests.approve');

        Route::patch('/repair-requests/{repairRequest}/reject', [AdminRepairRequestController::class, 'reject'])
            ->name('repair-requests.reject');

        Route::get('/repair-requests/{repairRequest}/assign', [AdminRepairRequestController::class, 'assignForm'])
            ->name('repair-requests.assign-form');

        Route::patch('/repair-requests/{repairRequest}/assign', [AdminRepairRequestController::class, 'assign'])
            ->name('repair-requests.assign');

        Route::get('/invoices', [AdminInvoiceController::class, 'index'])
            ->name('invoices.index');

        Route::get('/invoices/{invoice}', [AdminInvoiceController::class, 'show'])
            ->name('invoices.show');

        Route::get('/repair-requests/{repairRequest}/invoice/create', [AdminInvoiceController::class, 'create'])
            ->name('invoices.create');

        Route::post('/repair-requests/{repairRequest}/invoice', [AdminInvoiceController::class, 'store'])
            ->name('invoices.store');

        Route::get('/technicians', [AdminTechnicianController::class, 'index'])
            ->name('technicians.index');

        Route::get('/technicians/create', [AdminTechnicianController::class, 'create'])
            ->name('technicians.create');

        Route::post('/technicians', [AdminTechnicianController::class, 'store'])
            ->name('technicians.store');

        Route::get('/technicians/{technician}/edit', [AdminTechnicianController::class, 'edit'])
            ->name('technicians.edit');

        Route::get('/technicians/{technician}/reset-password', [AdminTechnicianController::class, 'editPassword'])
            ->name('technicians.reset-password');

        Route::patch('/technicians/{technician}/reset-password', [AdminTechnicianController::class, 'updatePassword'])
            ->name('technicians.update-password');

        Route::patch('/technicians/{technician}', [AdminTechnicianController::class, 'update'])
            ->name('technicians.update');

        Route::delete('/technicians/{technician}', [AdminTechnicianController::class, 'destroy'])
            ->name('technicians.destroy');

        Route::get('/technicians/{technician}', [AdminTechnicianController::class, 'show'])
            ->name('technicians.show');
    });

Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function (): void {
        Route::get('/repair-requests', [CustomerRepairRequestController::class, 'index'])
            ->name('repair-requests.index');

        Route::get('/repair-requests/create', [CustomerRepairRequestController::class, 'create'])
            ->name('repair-requests.create');

        Route::post('/repair-requests', [CustomerRepairRequestController::class, 'store'])
            ->name('repair-requests.store');

        Route::get('/repair-requests/{repairRequest}', [CustomerRepairRequestController::class, 'show'])
            ->name('repair-requests.show');

        Route::get('/invoices/{invoice}', [CustomerInvoiceController::class, 'show'])
            ->name('invoices.show');

        Route::post('/invoices/{invoice}/pay', [CustomerPaymentController::class, 'pay'])
            ->name('invoices.pay');

        Route::get('/receipts/{payment}', [CustomerReceiptController::class, 'show'])
            ->name('receipts.show');

        Route::get('/receipts/{payment}/download', [CustomerReceiptController::class, 'download'])
            ->name('receipts.download');
    });

Route::middleware('auth')->group(function (): void {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/repair-requests/{repairRequest}/approve', [AdminRepairRequestController::class, 'approve'])
        ->name('repair-requests.approve');

    Route::patch('/repair-requests/{repairRequest}/reject', [AdminRepairRequestController::class, 'reject'])
        ->name('repair-requests.reject');

});

Route::middleware(['auth', 'role:technician'])
    ->prefix('technician')
    ->name('technician.')
    ->group(function (): void {

        Route::get('/repair-tasks', [RepairTaskController::class, 'index'])
            ->name('repair-tasks.index');

        Route::get('/repair-tasks/{repairRequest}', [RepairTaskController::class, 'show'])
            ->name('repair-tasks.show');

        Route::patch('/repair-tasks/{repairRequest}/diagnosis', [RepairTaskController::class, 'updateDiagnosis'])
            ->name('repair-tasks.update-diagnosis');

        Route::post('/repair-tasks/{repairRequest}/spare-parts', [RepairTaskController::class, 'storeSparePart'])
            ->name('repair-tasks.store-spare-part');

        Route::patch('/repair-tasks/{repairRequest}/complete', [RepairTaskController::class, 'markCompleted'])
            ->name('repair-tasks.complete');

    });

Route::middleware(['auth'])
    ->group(function (): void {
        Route::get('/notifications', [NotificationController::class, 'index'])
            ->name('notifications.index');

        Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
            ->name('notifications.mark-as-read');

        Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
            ->name('notifications.mark-all-as-read');
    });

require __DIR__ . '/auth.php';
