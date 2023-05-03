<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1','namespace' => 'API\v1' ], function () {
    Route::group(['prefix' => 'customer'], function (){
        Route::post('registercustomer','UserController@registerCustomer');
        Route::post('searchdriver','SearchController@searchDriverAvailablity');
        Route::post('driversearch1','SearchController@driversearch');
        Route::post('updatelatlong','SearchController@updatelatlong');
        Route::post('bookdriver','BookingController@BookDriver');
        Route::post('book','BookingController@sendcustomerBookingNotification');
        
        Route::post('future_booking','BookingController@booking_future_request');
        Route::post('delete_availablity','BookingController@delete_availablity');
        Route::post('myrides','RidesController@customerRides');
        Route::post('customerdetail','UserController@CustomerDetail');
        Route::post('custbooking','SearchController@custbookings');
        Route::get('paytmchecksum','PaytmController@index');
        Route::post('paytmchecksum','PaytmController@index');
        Route::get('validateChecksum','PaytmController@validateChecksum');
        Route::post('validateChecksum','PaytmController@validateChecksum');
        Route::post('get_myintrest','BookingController@get_myintrest');
        Route::post('assign_driver','BookingController@assign_driver');
        Route::post('notification','BookingController@sendDriverBookingNotification');
    });
    Route::group(['prefix' => 'driver'], function (){
        Route::post('registerdriver','DriverController@driverRegistration');
        Route::post('myrides','RidesController@driverRideHistory');
        Route::post('deletevehicle','DriverController@deleteVehicle');
        Route::post('uploadlicense','DriverController@uploadLicense');
        Route::post('updateprofilephoto','DriverController@uploadProfilePhoto');
        Route::post('start_journey','BookingController@startjourney');
         Route::post('complete_journey','BookingController@complete_journey');
        Route::post('addvehicle','DriverController@registerVehicle');
        Route::post('updatevehicle','DriverController@updateVehicle');
        Route::post('myvehicles','DriverController@myvehicles');
        Route::post('addmyavailability','BookingController@adddriverBookingAvailability');
        Route::post('changeonlinestatus','BookingController@changeBookingAvailability'); 
        Route::post('myinfo','DriverController@mydetail'); 
        Route::get('getvehicletype','DriverController@vehicletype'); 
        Route::post('driverstatus','DriverController@onlinestatus'); 
        Route::post('VehicleDelete','DriverController@vehicledelete');
        Route::post('getbooking','getbookingController@index');
        Route::post('get_driver_future_request','BookingController@get_driver_future_request');
        Route::post('show_intrest','BookingController@show_intrest');
        Route::post('cancel-ride-by-driver','BookingController@cancel_ride_by_driver');
        Route::post('cancel-notification','BookingController@cancel_notification');
      
    });
        Route::post("getuserdetail",'UserController@mydetails');
        Route::post("registerphone",'UserController@checkContact');
        Route::post("otpverification",'UserController@otpvalidation');
        Route::post('registerdevice','DeviceController@registerDevice');
        Route::get('users','UserController@index');
        
        Route::get("stateotp",'UserController@stateotpverification');
        Route::post("cityotp",'UserController@cityotpverification');
        //vehicletypes
        Route::get('vehicletypes','VehicleController@vehicletypelist');
        //customers
        Route::get('locations','SearchController@locationSearch');
            //bookings
        
            // Route::get('users',[API\v1\UserController::class,'index']);
            //   Route::apiResource('projects', 'ProjectsApiController');
          });
        // Route::get('users',[UserController::class,'index']);