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

Route::group(['prefix' => 'moving'], function () {
  Route::post('verify', 'Auth\VerifyPhoneController');

  Route::post('forgot-password', 'Auth\ResetPasswordController@forgot');
  Route::post('reset-password', 'Auth\ResetPasswordController@reset');

  Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::post('signin', 'SignInController');
    Route::post('signup', 'SignUpController');
  }); //,'middleware'=>'verified'
  Route::group(['middleware' => 'auth:api', 'middleware' => 'status'], function () {
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
      Route::get('me', 'MeController');
      Route::post('signout', 'SignOutController');
      Route::get('read-notification/{id}', 'NotificationController@read');
    });
    Route::group(['namespace' => 'Carrier', 'prefix' => 'carrier'], function () {
      Route::resource('details', 'CarrierDetailsController');
      Route::resource('rate', 'CarrierRateController');
      Route::resource('account', 'CarrierAccountController');
      Route::resource('payments', 'BankController');

      Route::resource('jobs', 'JobController');
      Route::resource('earnings', 'EarningController');
      Route::get('job-status', 'JobController@jobStatus');
      Route::post('rate-carrier', 'CarrierDetailsController@rate');

      Route::resource('calendar', 'CalendarController');
      Route::resource('dashboard', 'DashboardController');
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
    });
    Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'role'], function () {
      Route::resource('about', 'Pages\AboutController');
      Route::resource('terms', 'Pages\TermsController');
      Route::resource('privacy', 'Pages\PrivacyController');
      Route::resource('carrier-page', 'Pages\CarrierController');
      Route::resource('shipper-page', 'Pages\ShipperController');
      Route::resource('help', 'Pages\FAQController');
      Route::resource('carrier-faq', 'Pages\CarrierFAQController');
      Route::resource('shipper-faq', 'Pages\ShipperFAQController');

      Route::resource('addresses', 'AddressController');
      Route::get('search-address', 'AddressController@search');
      Route::resource('contacts', 'ContactController');
      Route::get('search-contact', 'ContactController@search');

      Route::resource('earnings', 'Finance\EarningController');
      Route::get('search-earning', 'Finance\EarningController@search');

      Route::resource('users', 'UserController');
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
      Route::resource('orders', 'Shippers\OrderController');
      Route::get('search-order', 'Shippers\OrderController@search');

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
    });
    Route::group(['namespace' => 'Order'], function () {
      Route::post('charge-customer', 'CheckoutController@chargeCustomer');
    });
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

  Route::get("stripe-key", function () {
    return env("STRIPE_KEY");
  });
  Route::get("unauthorized", function () {
    return response()->json(['message' => 'You are unauthorized!'], 401);
  })->name('unauthorized');

  Route::resource('tests', 'TestController');

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
