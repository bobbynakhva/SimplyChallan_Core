<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Inward\InwardController;
use App\Http\Controllers\Inward\InwardPurposeController;
use App\Http\Controllers\Inward\InwardCompanyController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ChallanController;
use App\Http\Controllers\FinancialYearController;
use App\Http\Middleware\EnsureCompanySelected;
use App\Http\Controllers\ReturnItemController;
use App\Http\Controllers\PurposeController;
use App\Http\Controllers\UrCompanyController;
use App\Http\Controllers\FlowTabController;
use App\Http\Controllers\LicenseController;

/*Route::get('/', function () {
    return view('front/index');
});
*/
Auth::routes();

Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/registerdata', [RegisterController::class, 'registerdata'])->name('registerdata');
Route::get('/login', [LoginController::class, 'showOtpLogin'])->name('login');
Route::post('/loginpost', [LoginController::class, 'loginpost'])->name('loginpost');
Route::get('/loginpost', function() { return redirect()->route('login'); });
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/activate-license', [LicenseController::class, 'activate'])->name('license.activate');

use App\Http\Controllers\SystemUpdateController;

Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/privacypolicy', [App\Http\Controllers\HomeController::class, 'privacypolicy'])->name('privacypolicy');
    Route::get('/termscondition', [App\Http\Controllers\HomeController::class, 'termscondition'])->name('termscondition');

    Route::get('/urcompanies', [UrCompanyController::class, 'index'])->name('urcompanies.index'); // List companies
    Route::post('/urcompanies/store', [UrCompanyController::class, 'store'])->name('urcompanies.store'); // Store new company
    Route::resource('urcompanies', UrCompanyController::class);

    // License Management
    Route::get('/admin/license', [LicenseController::class, 'index'])->name('admin.license.index');
    Route::post('/admin/license/reset', [LicenseController::class, 'resetBinding'])->name('admin.license.reset');

    // Backup & Restore
    Route::get('/settings/backup', [App\Http\Controllers\BackupController::class, 'index'])->name('backup.index');
    Route::post('/settings/backup/export', [App\Http\Controllers\BackupController::class, 'export'])->name('backup.export');
    Route::post('/settings/backup/restore', [App\Http\Controllers\BackupController::class, 'restore'])->name('backup.restore');

    // One-Click System Update
    Route::post('/system/update', [SystemUpdateController::class, 'update'])->name('system.update');
});


Route::get('companies/selections', [CompanyController::class, 'selections'])->name('companies.selections');
Route::resource('companies', CompanyController::class);


Route::get('/company/select', [CompanyController::class, 'selectForm'])->name('company.select');
Route::post('/company/select', [CompanyController::class, 'storeSelection']);
Route::post('/financial-years/store', [FinancialYearController::class, 'store'])->name('financial-years.store');
Route::post('/financial-years/switch', [FinancialYearController::class, 'switch'])->name('financial-years.switch');
Route::get('/company/search', [CompanyController::class, 'search'])->name('company.search');
Route::get('/company', [CompanyController::class, 'index'])->name('companies.view');
Route::get('/companies/edit/{id}', [CompanyController::class, 'edit'])->name('companies.edit');
Route::get('/get-company-details', [CompanyController::class, 'getCompanyDetails'])->name('get.company.details');


Route::middleware([EnsureCompanySelected::class])->group(function () {
    Route::get('/flow-tab', [FlowTabController::class, 'show'])->name('flow-tab');
    Route::post('/flow-tab/select', [FlowTabController::class, 'selectFlow'])->name('flow-tab.select');
});

Route::middleware([EnsureCompanySelected::class])->prefix('inward')->group(function () {
        Route::post('/companies/import', [InwardCompanyController::class, 'import'])->name('companies.import');
        Route::resource('companies', InwardCompanyController::class);
        Route::get('/companies/edit/{id}', [InwardCompanyController::class, 'edit'])->name('inward.companies.edit');
    Route::get('/challan', [InwardController::class, 'index'])->name('inward.dashboard');
    Route::get('/challan/create', [InwardController::class, 'create'])->name('inward.challan.create');
    Route::post('/challan/store', [InwardController::class, 'store'])->name('inward.challan.store');
    Route::get('/challan/edit/{id}', [InwardController::class, 'edit'])->name('inward.challan.edit');
    Route::put('/challan/update/{id}', [InwardController::class, 'update'])->name('inward.challan.update');
    Route::get('/challan/view/{id}', [InwardController::class, 'show'])->name('inward.challan.view');
    Route::delete('/challans/{id}/soft-delete', [InwardController::class, 'softDelete'])->name('inward.challan.softDelete');
    Route::get('/challan/reports', [InwardController::class, 'reports'])->name('inward.challan.reports');
    Route::get('/challan/export', [InwardController::class, 'exportReports'])->name('inward.challan.export');
    Route::get('/challan/items/{id}', [InwardController::class, 'challanItems'])->name('inward.challan.items');
    Route::post('/return-items/store', [InwardController::class, 'ReturnPraparedItem'])->name('inward.return-items.store');
    Route::get('/challan/reportsview/{id}', [InwardController::class, 'reportsshow'])->name('inward.challan.reportsview');
    Route::get('/challan/print/{id}', [InwardController::class, 'printChallan'])->name('inward.challan.print');
    Route::get('/challan/singleprint/{id}', [InwardController::class, 'singleprintChallan'])->name('inward.challan.invoice');
    Route::get('/inward-challan/export-report/{id}', [InwardController::class, 'exportInwardReport'])->name('inward.challan.export_report');
    Route::get('/inward-challan/download/{id}', [InwardController::class, 'downloadPdf'])->name('inward.challan.download');
    Route::post('/challan/import', [InwardController::class, 'bulkImport'])->name('inward.challan.bulkImport');
    Route::get('/challan/sample-download', [InwardController::class, 'downloadSample'])->name('inward.challan.sampleDownload');
    Route::get('/purposes', [InwardPurposeController::class, 'index'])->name('inward.purposes.index');
    Route::get('/purposes/create', [InwardPurposeController::class, 'create'])->name('inward.purposes.create');
    Route::post('/purposes/store', [InwardPurposeController::class, 'store'])->name('inward.purposes.store');
    Route::get('/purposes/edit/{id}', [InwardPurposeController::class, 'edit'])->name('inward.purposes.edit');
    Route::put('/purposes/update/{id}', [InwardPurposeController::class, 'update'])->name('inward.purposes.update');
    Route::delete('/purposess/{id}/soft-delete', [InwardPurposeController::class, 'destroy'])->name('inward.purposes.destroy');
});



Route::middleware([EnsureCompanySelected::class])->prefix('outward')->group(function () {
    Route::get('/challan', [ChallanController::class, 'index'])->name('dashboard');
    Route::get('/challan/new', [ChallanController::class, 'create'])->name('challan.create');
    Route::get('/challan/create', [ChallanController::class, 'create'])->name('challan.create');
    Route::post('/challan/store', [ChallanController::class, 'store'])->name('challan.store');
    Route::get('/challan/edit/{id}', [ChallanController::class, 'edit'])->name('challan.edit');
    Route::put('/challan/update/{id}', [ChallanController::class, 'update'])->name('challan.update');
    Route::delete('/challans/{id}/soft-delete', [ChallanController::class, 'softDelete'])->name('challan.softDelete');
    Route::get('/challans/deleted', [ChallanController::class, 'deleted'])->name('challan.deleted');
    Route::patch('/challans/{id}/restore', [ChallanController::class, 'restore'])->name('challan.restore');
    Route::get('/challan/view/{id}', [ChallanController::class, 'show'])->name('challan.view');
    Route::get('/challan/inward', [ChallanController::class, 'inward'])->name('challan.inward');
    Route::get('/challan/reports', [ChallanController::class, 'reports'])->name('challan.reports');
    Route::get('/challan/reportsview/{id}', [ChallanController::class, 'reportsshow'])->name('challan.reportsview');
    Route::get('/challan/export', [ChallanController::class, 'exportReports'])->name('challan.export');
    Route::get('/challan/print/{id}', [ChallanController::class, 'printChallan'])->name('challan.print');
    Route::get('/challan/items/{id}', [ChallanController::class, 'challanItems'])->name('challan.items');
    Route::post('/return-items/store', [ReturnItemController::class, 'store'])->name('return-items.store');
    Route::get('/challans/{id}/report', [ChallanController::class, 'showReport'])->name('challan.returnreportsview');
    Route::get('/challans/{id}/export-report', [ChallanController::class, 'exportReturnReport'])->name('challan.export_return_report');
    Route::get('/challan/download/{id}', [ChallanController::class, 'downloadPdf'])->name('challan.download');
    Route::post('/challan/import', [ChallanController::class, 'bulkImport'])->name('challan.bulkImport');
    Route::get('/challan/sample-download', [ChallanController::class, 'downloadSample'])->name('challan.sampleDownload');
    Route::resource('purposes', PurposeController::class);

});
