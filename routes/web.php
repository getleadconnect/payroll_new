<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AdminUserController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProjectTypeController;
use App\Http\Controllers\Admin\PaymentTypeController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\FloorController;

use App\Http\Controllers\Admin\MiscCategoryController;
use App\Http\Controllers\Admin\MiscExpenseController;
use App\Http\Controllers\Admin\MiscSiteExpenseController;
use App\Http\Controllers\Admin\MiscVendorController;
use App\Http\Controllers\Admin\MiscWorkController;

use App\Http\Controllers\Admin\StaffRoleController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StaffBonusController;
use App\Http\Controllers\Admin\SalaryIncrementController;
use App\Http\Controllers\Admin\StaffTAController;
use App\Http\Controllers\Admin\StaffSalaryController;
use App\Http\Controllers\Admin\StaffOverTimeController;

use App\Http\Controllers\Admin\MaterialUnitController;
use App\Http\Controllers\Admin\MaterialGstController;
use App\Http\Controllers\Admin\MaterialTypeController;
use App\Http\Controllers\Admin\MaterialSubTypeController;

use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\SubcontractorController;
use App\Http\Controllers\Admin\MaterialPriceController;
use App\Http\Controllers\Admin\MaterialSupplyController;
use App\Http\Controllers\Admin\MainCostItemController;
use App\Http\Controllers\Admin\MainCostCenterController;

use App\Http\Controllers\Admin\LabourController;
use App\Http\Controllers\Admin\LabourWageController;
use App\Http\Controllers\Admin\LabourWorkCostController;
use App\Http\Controllers\Admin\LabourDailyWageController;

use App\Http\Controllers\Admin\ProjectLabourController;
use App\Http\Controllers\Admin\ProjectStaffAssignController;


use App\Http\Controllers\Admin\AssetCategoryController;
use App\Http\Controllers\Admin\AssetSubCategoryController;
use App\Http\Controllers\Admin\AssetItemController;
use App\Http\Controllers\Admin\ProjectAssetController;
use App\Http\Controllers\Admin\SubcontractorItemController;
use App\Http\Controllers\Admin\SubcontractorRateController;
use App\Http\Controllers\Admin\SubcontractorWorkController;

use App\Http\Controllers\Admin\RevenueController;

use App\Http\Controllers\Admin\LabourReportController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReportViewController;
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
    return view('admin.login.login-page');
});

Route::controller(LoginController::class)->group(function() {
    Route::get('/login', 'index')->name('admin.login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('admin.logout');
});

Route::controller(DashboardController::class)->group(function() {
    Route::get('/dashboard', 'index')->name('dashboard');
});


Route::controller(AdminUserController::class)->group(function()
{
Route::get('/admin-users', 'index');
Route::post('/save-admin-user', 'store');
Route::get('/edit-admin-user/{id}', 'edit');
Route::post('/update-admin-user', 'update_admin_user');
Route::get('/view-admin-users', 'view_data');
Route::get('/delete-admin-user/{id}', 'destroy');
Route::get('/admin-activate-deactivate/{id}/{op}', 'activate_deactivate');
Route::get('/get-staff/{id}', 'get_staff');
Route::post('/update-admin-password', 'update_admin_password');

});


Route::controller(CompanyController::class)->group(function()
{
Route::get('/company', 'index');
Route::post('/save-company', 'store');
Route::get('/edit-company/{id}', 'edit');
Route::post('/update-company', 'update_company');
Route::get('/view-company', 'view_data');
Route::get('/delete-company/{id}', 'destroy');
Route::get('/company_activate_deactivate/{id}/{op}', 'activate_deactivate');
});

Route::controller(ClientController::class)->group(function()
{
Route::get('/clients', 'index');
Route::post('/save-client', 'store');
Route::get('/edit-client/{id}', 'edit');
Route::post('/update-client', 'update_client');
Route::get('/view-clients', 'view_data');
Route::get('/delete-client/{id}', 'destroy');
Route::get('/client_activate_deactivate/{id}/{op}', 'activate_deactivate');

});

Route::controller(ProjectController::class)->group(function()
{
Route::get('/projects', 'index');
Route::post('/save-project', 'store');
Route::get('/edit-project/{id}', 'edit');
Route::post('/update-project', 'update_project');
Route::get('/view-projects', 'view_data');
Route::get('/delete-project/{id}', 'destroy');
Route::get('/change_project_status/{id}/{op}', 'change_project_status');
Route::get('/project_activate_deactivate/{id}/{op}', 'activate_deactivate');
});

Route::controller(ProjectTypeController::class)->group(function()
{
Route::get('/project-types', 'index');
Route::post('/save-project-type', 'store');
Route::post('/update-project-type', 'update_project_type');
Route::get('/view-project-types', 'view_data');
Route::get('/delete-project-type/{id}', 'destroy');
});

Route::controller(PaymentTypeController::class)->group(function()
{
Route::get('/payment-types', 'index');
Route::post('/save-payment-type', 'store');
Route::post('/update-payment-type', 'update_payment_type');
Route::get('/view-payment-types', 'view_data');
Route::get('/delete-payment-type/{id}', 'destroy');
});



Route::controller(AssetCategoryController::class)->group(function()
{
Route::get('/asset-category', 'index');
Route::post('/save-asset-category', 'store');
Route::post('/update-asset-category', 'update_asset_category');
Route::get('/view-asset-categories', 'view_data');
Route::get('/delete-asset-category/{id}', 'destroy');
});

Route::controller(AssetSubCategoryController::class)->group(function()
{
Route::get('/asset-sub-category', 'index');
Route::post('/save-asset-sub-category', 'store');
Route::get('/edit-asset-sub-category/{id}', 'edit');
Route::post('/update-asset-sub-category', 'update_asset_sub_category');
Route::get('/view-asset-sub-categories', 'view_data');
Route::get('/delete-asset-sub-category/{id}', 'destroy');
});

Route::controller(AssetItemController::class)->group(function()
{
Route::get('/asset-items', 'index');
Route::post('/save-asset-item', 'store');
Route::get('/edit-asset-item/{id}', 'edit');
Route::post('/update-asset-item', 'update_asset_item');
Route::get('/view-asset-items', 'view_data');
Route::get('/delete-asset-item/{id}', 'destroy');
Route::get('/get-projects-by-company-id/{id}', 'get_projects_by_company_id');

Route::get('/assign-project-assets', 'assign_project_assets');
Route::get('/view-asset-datas', 'view_asset_data'); //assign asset items
Route::get('/assign-asset-item/{id}', 'assign_asset_item');
Route::post('/save-item-to-project', 'save_item_to_project');
});

Route::controller(ProjectAssetController::class)->group(function()
{
Route::get('/project-assets', 'index');
Route::get('/edit-project-asset/{id}', 'edit');
Route::post('/update-project-asset','update_project_asset');
Route::get('/view-project-assets', 'view_data');
Route::get('/delete-project-asset-item/{id}', 'destroy');
Route::get('/return-project-asset-item/{id}', 'return_project_asset_item');
Route::post('/update-return-project-asset', 'update_return_project_asset');
});

Route::controller(MaterialUnitController::class)->group(function()
{
Route::get('/material-units', 'index');
Route::post('/save-material-unit', 'store');
Route::post('/update-material-unit', 'update_material_unit');
Route::get('/view-material-units', 'view_data');
Route::get('/delete-material-unit/{id}', 'destroy');
});

Route::controller(MaterialGstController::class)->group(function()
{
Route::get('/material-gst', 'index');
Route::post('/save-material-gst', 'store');
Route::get('/edit-material-gst/{id}', 'edit');
Route::post('/update-material-gst', 'update_material_gst');
Route::get('/view-material-gst', 'view_data');
Route::get('/delete-material-gst/{id}', 'destroy');
});


Route::controller(SkillController::class)->group(function()
{
Route::get('/skill-types', 'index');
Route::post('/save-skill-type', 'store');
Route::get('/edit-skill-type/{id}', 'edit');
Route::post('/update-skill-type', 'update_skill_type');
Route::get('/view-skill-types', 'view_data');
Route::get('/delete-skill-type/{id}', 'destroy');
});

Route::controller(FloorController::class)->group(function()
{
Route::get('/floors', 'index');
Route::post('/save-floor-nos', 'store');
Route::get('/edit-floor-no/{id}', 'edit');
Route::post('/update-floor-no', 'update_floor_no');
Route::get('/view-floor-nos', 'view_data');
Route::get('/delete-floor-no/{id}', 'destroy');
});


Route::controller(MiscVendorController::class)->group(function()
{
Route::get('/misc-vendors', 'index');
Route::post('/save-misc-vendor', 'store');
Route::get('/edit-misc-vendor/{id}', 'edit');
Route::post('/update-misc-vendor', 'update_misc_vendor');
Route::get('/view-misc-vendors', 'view_data');
Route::get('/delete-misc-vendor/{id}', 'destroy');
});


Route::controller(MiscWorkController::class)->group(function()
{
Route::get('/misc-works', 'index');
Route::post('/save-misc-work', 'store');
Route::get('/edit-misc-work/{id}', 'edit');
Route::post('/update-misc-work', 'update_misc_work');
Route::get('/view-misc-works', 'view_data');
Route::get('/delete-misc-work/{id}', 'destroy');
});


Route::controller(StaffRoleController::class)->group(function()
{
Route::get('/staff-roles', 'index');
Route::post('/save-staff-role', 'store');
Route::get('/edit-staff-role/{id}', 'edit');
Route::post('/update-staff-role', 'update_staff_role');
Route::get('/view-staff-roles', 'view_data');
Route::get('/delete-staff-role/{id}', 'destroy');
});

Route::controller(StaffController::class)->group(function()
{
Route::get('/staffs', 'index');
Route::get('/add-staffs', 'add_staff');
Route::post('/save-staff', 'store');
Route::get('/edit-staff/{id}', 'edit');
Route::post('/update-staff', 'update_staff');
Route::get('/view-staffs', 'view_data');
Route::get('/get-staff-details/{id}', 'get_staff_details');
Route::get('/delete-staff/{id}', 'destroy');
Route::get('/staff_activate_deactivate/{id}/{op}', 'activate_deactivate');
});

Route::controller(SalaryIncrementController::class)->group(function()
{
Route::get('/salary-increments', 'index');
Route::get('/add-salary-increment', 'add_salary_increment');
Route::post('/save-salary-increment', 'store');
Route::get('/edit-salary-increment/{id}', 'edit');
Route::post('/update-salary-increment', 'update_salary_increment');
Route::get('/view-salary-increments', 'view_data');
Route::get('/delete-salary-incrment/{id}/{sid}', 'destroy');
});

Route::controller(StaffSalaryController::class)->group(function()
{
Route::get('/staff-salary', 'index');
Route::post('/save-staff-salary', 'store');
Route::get('/edit-staff-salary/{id}', 'edit');
Route::post('/update-staff-salary', 'update_staff_salary');
Route::get('/view-staff-salary', 'view_data');
Route::get('/delete-staff-salary/{id}', 'destroy');
Route::get('/get-project-staffs/{id}', 'get_project_staffs');
Route::get('/get-staff-salary/{sid}/{mon}/{yr}', 'get_staff_salary');
//Route::get('/get-staff-salary-allowance/{sid}/{mon}/{yr}', 'get_staff_salary_allowance');
Route::get('/salary-slip/{id}', 'salary_slip');
});

Route::controller(StaffOverTimeController::class)->group(function()
{
Route::get('/staff-over-times', 'index');
Route::post('/save-over-time', 'store');
Route::get('/view-staff-over-times', 'view_data');
Route::get('/edit-staff-over-time/{id}', 'edit');
Route::post('/update-staff-over-time', 'update_staff_over_time');
Route::get('/delete-staff-over-time/{id}', 'destroy');
});

Route::controller(MaterialTypeController::class)->group(function()
{
Route::get('/material-types', 'index');
Route::post('/save-material-type', 'store');
Route::post('/update-material-type', 'update_material_type');
Route::get('/view-material-types', 'view_data');
Route::get('/delete-material-type/{id}', 'destroy');
});


Route::controller(MaterialSubTypeController::class)->group(function()
{
Route::get('/material-sub-types', 'index');
Route::post('/save-material-sub-type', 'store');
Route::get('/edit-material-sub-type/{id}', 'edit');
Route::post('/update-material-sub-type', 'update_material_sub_type');
Route::get('/view-material-sub-types', 'view_data');
Route::get('/delete-material-sub-type/{id}', 'destroy');
});

Route::controller(SupplierController::class)->group(function()
{
Route::get('/suppliers', 'index');
Route::post('/save-supplier', 'store');
Route::get('/edit-supplier/{id}', 'edit');
Route::post('/update-supplier', 'update_supplier');
Route::get('/view-suppliers', 'view_data');
Route::get('/delete-supplier/{id}', 'destroy');
Route::get('/supplier_activate_deactivate/{id}/{op}', 'activate_deactivate');
});

Route::controller(SubcontractorController::class)->group(function()
{
Route::get('/sub-contractors', 'index');
Route::get('/add-sub-contractors', 'add_subcontractor');
Route::post('/save-subcontractor', 'store');
Route::get('/edit-subcontractor/{id}', 'edit');
Route::post('/update-subcontractor', 'update_subcontractor');
Route::get('/view-subcontractors', 'view_data');
Route::get('/delete-subcontractor/{id}', 'destroy');
Route::get('/subcontractor_activate_deactivate/{id}/{op}', 'activate_deactivate');
});

Route::controller(SubcontractorItemController::class)->group(function()
{
Route::get('/sub-contractor-items', 'index');
Route::post('/save-subcontractor-item', 'store');
Route::get('/edit-subcontractor-item/{id}', 'edit');
Route::post('/update-subcontractor-item', 'update_subcontractor_item');
Route::get('/view-subcontractor-items', 'view_data');
Route::get('/delete-subcontractor-item/{id}', 'destroy');
});

Route::controller(SubcontractorRateController::class)->group(function()
{
Route::get('/sub-contractor-rates', 'index');
Route::post('/save-subcontractor-rate', 'store');
Route::get('/edit-subcontractor-rate/{id}', 'edit');
Route::post('/update-subcontractor-rate', 'update_subcontractor_rate');
Route::get('/view-subcontractor-rates', 'view_data');
Route::get('/delete-subcontractor-rate/{id}', 'destroy');
Route::get('/get-items-by-subcontractor-id/{id}', 'get_items_by_subcontractor_id');
Route::get('/get-subcontractor-item-unit-name/{id}', 'get_subcontractor_item_unit_name');
});

Route::controller(SubcontractorWorkController::class)->group(function()
{
Route::get('/sub-contractor-works', 'index');
Route::get('/add-subcontractor-works', 'add_subcontractor_works');

Route::post('/save-subcontractor-work', 'store');
Route::get('/edit-subcontractor-work/{id}', 'edit');
Route::post('/update-subcontractor-work', 'update_subcontractor_work');
Route::get('/view-subcontractor-works', 'view_data');
Route::get('/delete-subcontractor-work/{id}', 'destroy');
Route::get('/get-subcontractor-rate-items/{id}/{pid}/{op}', 'get_subcontractor_rate_items');
Route::get('/get-sub-contractor-itemunit-rate/{id}', 'get_sub_contractor_itemunit_rate');

Route::get('/get-subcontractors-by-project/{id}', 'get_subcontractors_by_project');
Route::get('/get-main-cost-center-by-project-floor-id/{id}/{fid}', 'get_main_cost_center_by_project_floor_id');

});


Route::controller(MaterialPriceController::class)->group(function()
{
Route::get('/material-prices', 'index');
Route::post('/save-material-price', 'store');
Route::get('/edit-material-price/{id}', 'edit');
Route::post('/update-material-price', 'update_material_price');
Route::get('/view-material-prices', 'view_data');
Route::get('/delete-material-price/{id}', 'destroy');
Route::get('/price_activate_deactivate/{id}/{op}', 'activate_deactivate');
Route::get('/get-material-sub-types/{id}', 'get_material_sub_types');

});


Route::controller(MaterialSupplyController::class)->group(function()
{
Route::get('/material-supply', 'index');
Route::get('/add-material-supply', 'add_material_supply');
Route::post('/save-material-supply', 'store');
Route::get('/edit-material-supply/{id}', 'edit');
Route::post('/update-material-supply', 'update_material_supply');
Route::get('/view-material-supply', 'view_data');
Route::get('/delete-material-supply/{id}', 'destroy');
Route::get('/get-material-suppliers/{id}', 'get_material_suppliers');
//Route::get('/get-material-price/{id}', 'get_material_prices');
//Route::get('/get-material-gst-value/{id}', 'get_material_gst_value');
Route::get('/get-material-types/{id}/{pid}', 'get_material_types');
Route::get('/get-supply-material-sub-types/{id}', 'get_supply_material_sub_types');
Route::get('/get-material-price-details/{id}/{pid}/{sid}', 'get_material_price_details');

});


Route::controller(MainCostItemController::class)->group(function()
{
Route::get('/main-cost-items', 'index');
Route::post('/save-cost-item', 'store');
Route::get('/edit-cost-item/{id}', 'edit');
Route::post('/update-cost-item', 'update_cost_item');
Route::get('/view-cost-items', 'view_data');
Route::get('/delete-cost-item/{id}', 'destroy');
});

Route::controller(MainCostCenterController::class)->group(function()
{
Route::get('/main-cost-centers', 'index');
Route::post('/main-cost-centers', 'index');
Route::post('/save-cost-center', 'store');
Route::get('/edit-cost-center/{id}', 'edit');
Route::post('/update-cost-center', 'update_main_cost_center');
Route::get('/view-cost-centers', 'view_data');
Route::get('/delete-cost-center/{id}', 'destroy');
});


Route::controller(LabourController::class)->group(function()
{
Route::get('/labours', 'index');
Route::get('/add-labour', 'add_labour');
Route::post('/save-labour', 'store');
Route::get('/edit-labour/{id}', 'edit');
Route::post('/update-labour', 'update_labour');
Route::get('/view-labours', 'view_data');
Route::get('/delete-labour/{id}', 'destroy');
Route::get('/labour_activate_deactivate/{id}/{op}', 'activate_deactivate');
Route::get('/get-districts/{id}', 'get_districts');

});

Route::controller(LabourWageController::class)->group(function()
{
Route::get('/labour-wages', 'index');
Route::get('/set-labour-wage/{id}', 'set_labour_wage');
Route::post('/save-labour-wage', 'store');
Route::get('/edit-labour-wage/{id}', 'edit');
Route::post('/update-labour-wage', 'update_labour_wage');
Route::get('/view-labour-data/{id}', 'view_labour_data');
Route::get('/view-labour-wages', 'view_labour_wages');
Route::get('/delete-labour-wage/{id}', 'destroy');
});

/*Route::controller(LabourWorkCostController::class)->group(function()
{
Route::get('/labour-work-costs', 'index');

Route::get('/set-labour-wage/{id}', 'set_labour_wage');
Route::post('/save-labour-wage', 'store');
Route::get('/edit-labour-wage/{id}', 'edit');
Route::post('/update-labour-wage', 'update_labour_wage');
Route::get('/view-labour-data', 'view_labour_data');
Route::get('/view-labour-wages', 'view_labour_wages');
Route::get('/delete-labour-wage/{id}', 'destroy');
});*/

Route::controller(LabourDailyWageController::class)->group(function()
{
Route::get('/labour-daily-wages', 'index');
Route::post('/save-daily-wage', 'store');
Route::get('/edit-daily-wage/{id}', 'edit');
Route::post('/update-daily-wage', 'update_daily_wage');
Route::get('/view-labour-daily-wages', 'view_data');
Route::get('/delete-daily-wage/{id}', 'destroy');
Route::get('/get-labours-by-project-id/{id}', 'get_labours_by_project_id');
Route::get('/get-main-cost-center-by-project-id/{id}/{fid}', 'get_main_cost_center_by_project_id');
Route::get('/get-labour-wage-by-labour-id/{id}', 'get_labour_wage_by_labour_id');


Route::get('/all-labour-wages', 'all_labour_wages'); //disabled
Route::get('/edit-all-daily-wage/{id}', 'all_edit'); //disabled
Route::post('/update-all-daily-wage', 'update_all_daily_wage'); //disabled
Route::get('/delete-all-daily-wage/{id}', 'all_destroy'); //disabled
Route::get('/view-all-labour-wages', 'view_all_data');  //3 months details (//disabled)

});


Route::controller(ProjectLabourController::class)->group(function()
{
Route::get('/project-labours', 'index');
Route::get('/assign-labours', 'assign_labours');
Route::post('/set-labours-to-project', 'set_labour_to_project');
Route::post('/save-labours-to-project', 'store');
Route::get('/view-labour-details', 'view_labour_details');
Route::get('/view-project-labours', 'view_project_labours');
Route::get('/delete-project-labour/{id}', 'destroy');
//Route::get('/clear_assigned_labour_status/{id}', 'clear_assigned_labour_status');

Route::get('/release-project-labour/{id}', 'release_project_labour');
Route::post('/release-assigned-labour', 'release_assigned_labour');
});

Route::controller(ProjectStaffAssignController::class)->group(function()
{
Route::get('/project-staffs', 'index');
Route::post('/assign-project-staff', 'store');
Route::get('/view-project-staffs', 'view_data');
Route::get('/release-staff/{id}', 'release_staff');
Route::get('/delete-project-staff/{id}', 'destroy');
});


Route::controller(MiscCategoryController::class)->group(function()
{
Route::get('/misc-category', 'index');
Route::post('/save-misc-category', 'store');
Route::get('/edit-misc-category/{id}', 'edit');
Route::post('/update-misc-category', 'update_misc_category');
Route::get('/view-misc-category', 'view_data');
Route::get('/delete-misc-category/{id}', 'destroy');
});

Route::controller(MiscSiteExpenseController::class)->group(function()
{
Route::get('/misc-site-expenses', 'index');
Route::post('/save-misc-site-expense', 'store');
Route::get('/edit-misc-site-expense/{id}', 'edit');
Route::post('/update-misc-site-expense', 'update_misc_site_expense');
Route::get('/view-misc-site-expenses', 'view_data');
Route::get('/delete-misc-site-expense/{id}', 'destroy');
});

Route::controller(RevenueController::class)->group(function()
{
Route::get('/revenues', 'index');
Route::post('/save-revenue', 'store');
Route::get('/edit-revenue/{id}', 'edit');
Route::post('/update-revenue', 'update_revenue');
Route::get('/view-revenues', 'view_data');
Route::get('/delete-revenue/{id}', 'destroy');
});

Route::controller(LabourReportController::class)->group(function()
{
Route::get('/weekly-work-reports', 'index');
Route::post('/weekly-work-reports', 'weekly_report');
Route::get('/view-weekly-labour-work-reports', 'view_data');

//Route::get('/edit-revenue/{id}', 'edit');
//Route::post('/update-revenue', 'update_revenue');
//Route::get('/view-revenues', 'view_data');
//Route::get('/delete-revenue/{id}', 'destroy');
});

//views details--------------------------------------------------------------------------------

Route::controller(ReportViewController::class)->group(function()
{
Route::get('/view-summation-report', 'view_project_summation');
Route::post('/view-summation-report', 'view_project_summation');

Route::get('/material-supplier-analysis', 'material_supplier_analysis');
Route::post('/material-supplier-analysis', 'material_supplier_analysis');

Route::get('/project-supplier-analysis', 'project_supplier_analysis');
Route::post('/project-supplier-analysis', 'project_supplier_analysis');

Route::get('/vendor-project-analysis', 'vendor_project_analysis');
Route::post('/vendor-project-analysis', 'vendor_project_analysis');

Route::get('/project-vendor-analysis', 'project_vendor_analysis');
Route::post('/project-vendor-analysis', 'project_vendor_analysis');

Route::get('/project-misc-analysis', 'project_misc_analysis');
Route::post('/project-misc-analysis', 'project_misc_analysis');

Route::get('/category-misc-analysis', 'category_misc_analysis');
Route::post('/category-misc-analysis', 'category_misc_analysis');

Route::get('/work-category-labours', 'work_category_labours');
Route::post('/work-category-labours', 'work_category_labours');

Route::get('/project-labours-details', 'project_labours_details');
Route::post('/project-labours-details', 'project_labours_details');



});

//reports

Route::controller(ReportController::class)->group(function()
{
Route::get('/labour-details-report', 'index');
Route::get('/get-labour-detail-report/{id}', 'get_labour_detail_report');

Route::get('/project-reports', 'project_reports');
Route::get('/miscellaneous-report', 'miscellaneous_report');
Route::post('/miscellaneous-report', 'miscellaneous_report');

Route::get('/miscellaneous-gst-report', 'miscellaneous_gst_report');
Route::post('/miscellaneous-gst-report', 'miscellaneous_gst_report');

Route::get('/subcontractor-work-report', 'subcontractor_work_report');
Route::post('/subcontractor-work-report', 'subcontractor_work_report');

Route::get('/misc-non-gst-office-payment', 'misc_non_gst_office_payment');
Route::post('/misc-non-gst-office-payment', 'misc_non_gst_office_payment');

Route::get('/misc-gst-office-payment', 'misc_gst_office_payment');
Route::post('/misc-gst-office-payment', 'misc_gst_office_payment');

Route::get('/material-gst-office-payment', 'material_gst_office_payment');
Route::post('/material-gst-office-payment', 'material_gst_office_payment');

Route::get('/staff-salary-report', 'staff_salary_report');
Route::post('/staff-salary-report', 'staff_salary_report');

Route::get('/summation-report', 'project_summation_report');
Route::post('/summation-report', 'project_summation_report');

});