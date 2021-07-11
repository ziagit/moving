<?php

use App\Events\NewMessage;
use App\PrivacyPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\GoogleCalendar\Event;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Auth::routes(['verify' => true]);
/* Route::get('/moving/auth/facebook', 'Auth\Social\FacebookController@redirect');
Route::get('/moving/auth/facebook/callback', 'Auth\Social\FacebookController@callback'); */

Route::group(['prefix' => 'moving'], function () {
  Route::post('password/forget', 'Auth\ResetPasswordController@forget');
  Route::post('password/verify', 'Auth\ResetPasswordController@verify');
  Route::post('password/reset', 'Auth\ResetPasswordController@reset');
  Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::group(['namespace' => 'Social'], function () {
      Route::get('google', 'GoogleController@redirect');
      Route::get('google/callback', 'GoogleController@callback');
      Route::get('facebook', 'FacebookController@redirect');
      Route::get('facebook/callback', 'FacebookController@callback');
      Route::get('twitter', 'TwitterController@redirect');
      Route::get('twitter/callback', 'TwitterController@callback');
      Route::post('mobile/signin','MobileSocialLoginController@login');
    });
    Route::post('verify', 'VerifyPhoneController');
    Route::post('verify-email', 'VerifyEmailController');
    Route::post('signin', 'SignInController');
    Route::post('check-email', 'SigninEmailController');
  }); //,'middleware'=>'verified'
  Route::group(['middleware' => 'auth:api', 'middleware' => 'status'], function () {
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
      Route::get('me', 'MeController');
      Route::post('signout', 'SignOutController');
      Route::get('read-notification/{id}', 'NotificationController@read');
      Route::get("notifications", "NotificationController@index");
    });
    Route::group(['namespace' => 'Carrier', 'prefix' => 'carrier'], function () {
      Route::resource('details', 'CarrierDetailsController');
      Route::resource('account', 'CarrierAccountController');
      Route::post('change-avatar/{id}', 'CarrierAccountController@changeAvatar');
      Route::resource('bank-info', 'BankController');
      Route::get('payments', 'BankController@payments');
      Route::resource('jobs', 'JobController');
      Route::get('search-job', 'JobController@search');
      Route::get('unpaid', 'EarningController@unpaid');
      Route::get('paid', 'EarningController@paid');
      Route::get('earning/{id}', 'EarningController@show');
      Route::get('job-status', 'JobController@jobStatus');
      Route::post('rate-carrier', 'CarrierDetailsController@rate');
      Route::resource('calendar', 'CalendarController');
      Route::get('dashboard/pie-chart', 'DashboardController@pieChart');
      Route::get('dashboard/line-chart', 'DashboardController@lineChart');
      Route::get('dashboard/column-chart', 'DashboardController@columnChart');
      Route::get('notifications', 'DashboardController@columnChart');
    });
    Route::group(['namespace' => 'Shipper', 'prefix' => 'shipper'], function () {
      Route::resource('details', 'ShipperDetailsController');
      Route::resource('account', 'ShipperAccountController');
      Route::resource('orders', 'ShipperOrderController');
      Route::get('order-status', 'ShipperOrderController@status');
      Route::post('create-customer', 'BillingController@createCustomer');
      Route::get("card-details", 'BillingController@getCustomer');
      Route::get("charge-details", 'BillingController@getCharges');
      Route::get('shipper-address', "ShipperAccountController@shipperAddress");
      Route::resource('rating', 'RatingController');
      Route::post('change-avatar/{id}', 'ShipperAccountController@changeAvatar');
    });
    Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    });
    Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'role'], function () {
      Route::resource('accounts', 'Supports\AccountController');
      Route::post('accounts/avatar', 'Supports\AccountController@avatar');
      Route::get('dashboard/daily-projections', 'DashboardController@dailyProjections');
      Route::get('dashboard/sales', 'DashboardController@sales');
      Route::get('dashboard/customers', 'DashboardController@customers');
      Route::get('dashboard/movers', 'DashboardController@movers');
      Route::get('dashboard/performance', 'DashboardController@performance');
      Route::resource('notifications', 'NotificationController');
      Route::resource('earnings', 'Finance\EarningController');
      Route::get('revenue', 'Finance\EarningController@revenue');
      Route::get('paid-jobs', 'Finance\EarningController@paidJobs');
      Route::get('unpaid-jobs', 'Finance\EarningController@unpaidJobs');
      Route::get('search-earning', 'Finance\EarningController@search');
      Route::resource('payouts', 'Finance\PayoutController');
      Route::get('search-payout', 'Finance\PayoutController@search');
      Route::get('carrier-list', 'Finance\PayoutController@carriers');
      Route::get('carrier-earnings/{id}', 'Finance\PayoutController@earnings');
      Route::resource('refunds', 'Finance\RefundController');
      Route::get('search-refund', 'Finance\RefundController@search');
      Route::resource('users', 'UserController');
      Route::get('roles', 'UserController@roles');
      Route::put('users/lock/{id}', 'UserController@lock');
      Route::get('search-user', 'UserController@search');
      Route::resource('carriers', 'Carriers\CarrierController');
      Route::resource('carriers-account', 'Carriers\AccountController');
      Route::put('carriers-account/lock/{id}', 'Carriers\AccountController@lock');
      Route::get('search-carrier', 'Carriers\CarrierController@search');
      Route::get('search-carrier-account', 'Carriers\AccountController@search');
      Route::resource('rates', 'Carriers\RateController');
      Route::get('search-rate', 'Carriers\RateController@search');
      Route::resource('jobs', 'Carriers\JobController');
      Route::get('search-job', 'Carriers\JobController@search');
      Route::resource('shippers', 'Shippers\ShipperController');
      Route::resource('shippers-account', 'Shippers\AccountController');
      Route::put('shippers-account/lock/{id}', 'Shippers\AccountController@lock');
      Route::get('search-shipper', 'Shippers\ShipperController@search');
      Route::get('search-shipper-account', 'Shippers\AccountController@search');
      Route::resource('orders', 'OrderController');
      Route::get('search-order', 'OrderController@search');
      Route::resource('card-details', 'Shippers\PaymentController');
      Route::resource('countries', 'Lookups\CountryController');
      Route::get('search-country', 'Lookups\CountryController@search');
      Route::resource('states', 'Lookups\StateController');
      Route::get('search-state', 'Lookups\StateController@search');
      Route::resource('cities', 'Lookups\CityController');
      Route::get('search-city', 'Lookups\CityController@search');
      Route::resource('location-type', 'Lookups\LocationtypeController');
      Route::resource('mover-number', 'Lookups\MovernumberController');
      Route::resource('moving-size', 'Lookups\MovingsizeController');
      Route::resource('few-items', 'Lookups\ItemController');
      Route::get('search-item', 'Lookups\ItemController@search');
      Route::resource('moving-types', 'Lookups\MovingtypeController');
      Route::resource('office-sizes', 'Lookups\OfficesizeController');
      Route::resource('supply', 'Lookups\SupplyController');
      Route::resource('vehicle', 'Lookups\VehicleController');
      Route::resource('constans', 'Lookups\ConstantController');
      Route::resource('times', 'TimeController');
      Route::get('search-time', 'TimeController@search');
      Route::resource('financial-reports', 'Reports\FinancialReportsController');
      Route::post('filter-financial-report', 'Reports\FinancialReportsController@filter');
      Route::resource('sales-reports', 'Reports\SalesReportsController');
      Route::post('filter-sales-report', 'Reports\SalesReportsController@filter');
      Route::resource('about', 'Pages\AboutController');
      Route::resource('terms', 'Pages\TermsController');
      Route::resource('privacy', 'Pages\PrivacyController');
      Route::resource('how-it-works', 'Pages\FAQController');
      Route::resource('carrier-faq', 'Pages\CarrierFAQController');
      Route::resource('shipper-faq', 'Pages\ShipperFAQController');
      Route::resource('shipper-faq', 'Pages\ShipperFAQController');
    });
    Route::group(['namespace' => 'Order'], function () {
      Route::post('charge-customer', 'CheckoutController@chargeCustomer');
    });
    Route::post("upload", "UploadFileController@upload");
  });

  Route::group(['namespace' => 'Order'], function () {
    Route::post('create-customer', 'CheckoutController@store');
    Route::get('payment-status/{orderId}', 'CheckoutController@checkPayment');
    Route::get("check-payment/{id}", 'CheckoutController@checkPayment');

    Route::get('location-types', 'OrderController@locationType');
    Route::get('vehicles', 'OrderController@vehicles');
    Route::get('mover-numbers', 'OrderController@moverNumbers');
    Route::get('moving-sizes', 'OrderController@movingSizes');
    Route::get('office-sizes', 'OrderController@officeSizes');
    Route::get('moving-types', 'OrderController@movingTypes');
    Route::get('moving-supplies', 'OrderController@movingSupplies');
    Route::get('search-item', 'OrderController@searchItem');
    Route::post('carriers-rate', 'CalculatorController@calculator');
    Route::post('confirm', 'ShipmentController@store');
    Route::get('shipment-details/{id}', 'ShipmentController@show');
    Route::get('carrier-contacts/{id}', 'ShipmentController@carrierContacts');
  });
  Route::group(['namespace' => 'Location'], function () {
    Route::get('countries', 'AddressController@countries');
    Route::get('countries-full', 'AddressController@countriesFull');
    Route::get('states', 'AddressController@states');
    Route::get('state-cities', 'AddressController@statesCities');
    Route::get('cities', 'AddressController@cities');
    Route::get('addresses', 'AddressController@index');
    Route::get('search-state/{country}', 'AddressController@searchState');
    Route::get('search-city/{state}', 'AddressController@searchCity');
    Route::get('times/{id}', 'TimeController@show');
  });
  Route::post("about-form", "PageController@aboutForm");
  Route::get("get-terms", "PageController@terms");
  Route::get("get-privacy", "PageController@privacy");
  Route::get("get-faq", "PageController@faq");
  Route::get("get-carrier-faq", "PageController@carrierFaq");
  Route::get("get-shipper-faq", "PageController@shipperFaq");
  Route::get("get-about", "PageController@about");
  Route::get("get-shipper-page", "PageController@carrierPage");
  Route::get("get-carrier-page", "PageController@shipperPage");
  Route::get("get-legals", "PageController@legalsPage");

  Route::get("stripe-key", function () {
    return env("STRIPE_KEY");
  });
  Route::get("unauthorized", function () {
    return response()->json(['message' => 'You are unauthorized!'], 401);
  })->name('unauthorized');

  Route::post('test', 'TestController@index');

  Route::get('pages/privacy', function () {
    $page = PrivacyPage::first();
    return response()->json($page);
  });

  Route::get("test-event", function () {
    //return auth()->user()->roles[0]->name;
    event(new NewMessage('Hi from from Vuejs'));
    return;
  });
});
