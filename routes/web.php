<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Front\HomePageController;
use App\Http\Controllers\Front\FrontCmsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UniqueCheckController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Booking\BookingAvailabilityController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\TravelAgentController;
use App\Http\Controllers\UserDisplayController;
use App\Http\Controllers\DriverBookingController;
use App\Http\Controllers\CmsPageController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DriverAgencyBookingAvailability;
use App\Http\Controllers\Front\DriverRegisterController;
use App\Http\Controllers\BookingRequestController;
use App\Http\Controllers\PaytmController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PrivacyPolicyController;

use Auth as userauth;



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

Route::get('/', function () {
    return view('front.index');
});

 Route::get('paytm-payment',[PaytmController::Class, 'paytmPayment'])->name('paytm.payment');
 Route::post('paytm-payment',[PaytmController::Class, 'paytmPayment'])->name('paytm.payment');
//  Route::post('paytm-callback',[PaytmController::Class, 'paytmCallback'])->name('paytm.callback');
 Route::get('paytm-purchase',[PaytmController::Class, 'paytmPurchase'])->name('paytm.purchase');

    
Route::post('/payment-status/{bookingId}',  [BookingRequestController::class, 'paymentCallback'])->name('payment_status');
Route::get('/calculateDistanceByLocation', [BookingAvailabilityController::class, 'calculateDistanceByLocation']);
Route::get('/', [HomePageController::class, 'index'])->name('front_homepage');
Route::get('available-lift-in-your-location', [HomePageController::class, 'availableLift'])->name('viewMoreAvailability');
Route::post('getViewMoreLeftSearch', [HomePageController::class, 'getViewMoreLeftSearch'])->name('getViewMoreLeftSearch');
Route::post('search-available-lifts', [HomePageController::class, 'searchAvailableLift']);
// Route::get('/', [HomePageController::class, 'contactus']);
Route::get('search-city', [HomeController::class, 'searchCity'])->name('searchcity');
Route::get('about-us', [FrontCmsController::class, 'aboutus']);
Route::get('mission-vission', [FrontCmsController::class, 'mission']);
Route::get('how-its-work', [FrontCmsController::class, 'howItWork']);
Route::get('services', [FrontCmsController::class, 'services']);
Route::get('terms-conditions', [FrontCmsController::class, 'terms']);
Route::get('privacy-policy', [FrontCmsController::class, 'privacy']);
Route::get('refund-policy', [FrontCmsController::class, 'refund']);
Route::get('data-protection', [FrontCmsController::class, 'dataprotection']);
Route::get('disclaimer', [FrontCmsController::class, 'disclaimer']);

Route::post('fetch-location', [HomePageController::class, 'fetchLocation']);
Route::post('booking-cancel', [HomePageController::class, 'cancelBooking'])->name('cancelBooking');
Route::get('search-location', [TravelAgentController::class, 'searchLocation'])->name('searchlocation');
Route::get('admin/login', [HomePageController::class, 'adminlogin'])->name('admin.login');



Route::get('login', [HomePageController::class, 'userlogin'])->name('user-login');
Route::post('checkLoginMobile',[HomePageController::class,'MobileNoValidate'])->name('MobileNoValidate');
Route::post('mobile-login-otp', [HomePageController::class, 'Mobilelogin'])->name('mobile-login-otp');


Route::get('cancel-booking' , function () {
    return view('front.cancel-booking');
});


Route::get('travel-agency-registration', function () {
    return view('front.travelagent.travel_agency');
});



// Route::get('search', function () {
//     return view('front.search');
// });

Route::post('checkUserMobile',[BookingRequestController::class,'checkUserMobile'])->name('checkUserMobile');
Route::post('verify-otp',[BookingRequestController::class,'verifyOtp'])->name('verifyOtp');
Route::post('add-customer-data',[BookingRequestController::class,'addCustomerData'])->name('addCustomerData');
Route::post('add-payment-booking',[BookingRequestController::class,'addPayment'])->name('addPayment');
Auth::routes();


// Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('verify-mobile', [HomeController::class, 'verifyMobile'])->name('verifyMobile');
Route::get('agency-driver-info', [TravelAgentController::class, 'index']);
Route::get('travel-agency-booking-history', [TravelAgentController::class, 'travelAgencyBookingHistory']);
Route::post('search-agency-booking-history', [TravelAgentController::class, 'searchAgencyBookingHistory'])->name('searchAgencyBookingHistory');

// Change-Password
Route::get('change-password', [ChangePasswordController::class, 'index']);
Route::post('change-password', [ChangePasswordController::class, 'store'])->name('change.password');
Route::get('admin-change-password', [ChangePasswordController::class, 'adminPassword']);
Route::post('admin-change-password', [ChangePasswordController::class, 'storeNewPassword'])->name('admin.change.password');

//forgot password
Route::get('forgot-password', [ForgetPasswordController::class, 'index']);
Route::post('checkOtp', [ForgetPasswordController::class, 'otp']);
Route::post('forget-password', [ForgetPasswordController::class, 'forgotPassword']);

//Driver
// Route::get('edit-driver-dashbord', [DriverController::class, 'EditDriverProfile'])->name('EditDriverProfile');
// Route::post('update-driver-dashbord', [DriverController::class, 'update'])->name('drivr_update');

//For Vehicle Type Droup Down
Route::get('driver-registration', [DriverRegisterController::class, 'index']);

//Travel-Agent
// Route::get('edit-travel-dashbord', [TravelAgentController::class, 'EditTravelProfile'])->name('EditTravelProfile');
// Route::post('update-travel-dashbord', [TravelAgentController::class, 'update'])->name('travel_update');

//Unique Mobile Number & Driver-Travelar Register
Route::post('/unique-mobile-number', [UniqueCheckController::class, 'uniqueMobileNumber'])->name('uniqueMobileNumber');
Route::post('/unique-email-number', [UniqueCheckController::class, 'uniqueEmailNumber'])->name('uniqueEmailNumber');
Route::post('/unique-license-number', [UniqueCheckController::class, 'uniqueLicenseNumber'])->name('uniqueLicenseNumber');
Route::post('/unique-car-number', [UniqueCheckController::class, 'uniqueCarNumber'])->name('uniqueCarNumber');
Route::post('/unique-reg-number', [UniqueCheckController::class, 'uniqueRegNumber'])->name('uniqueRegNumber');

Route::post('dashboard', [RegisterController::class, 'DriverTravelReg'])->name('driver.travel.reg');

//Admin
// Route::get('location', [LocationController::class, 'index']);
// Route::get('location-form', [LocationController::class, 'create']);
// Route::get('location-form/{id}', [LocationController::class, 'create']);
// Route::post('add_location', [LocationController::class, 'store']);
// Route::post('delete_location', [LocationController::class, 'destroy']);

// Route::get('vehicle', [VehicleTypeController::class, 'index']);
// Route::get('vehicle-form', [VehicleTypeController::class, 'create']);
// Route::get('vehicle-form/{id}', [VehicleTypeController::class, 'create']);
// Route::post('add_vehicle', [VehicleTypeController::class, 'store']);
// Route::post('delete_vehicle', [VehicleTypeController::class, 'destroy']);

// Route::post('Add-booking', [BookingAvailabilityController::class, 'store'])->name('driver.booking');
// Route::get('my-availability-history', [BookingAvailabilityController::class, 'viewBookingHistory'])->name('mybooking');

// Route::get('driver-availability', [DriverAgencyBookingAvailability::class, 'ShowDriverForm']);
// Route::post('add-admin-driver-booking', [DriverAgencyBookingAvailability::class, 'addAdminDriver']);
// Route::get('agency-availability', [DriverAgencyBookingAvailability::class, 'ShowAgencyForm']);
// Route::post('add-admin-agency-booking', [DriverAgencyBookingAvailability::class, 'addAgencyDriver']);

//Driver add booking availability
// Route::get('driver-availability-booking', [BookingAvailabilityController::class, 'AddData'])->name('add.booking.availability');
// Route::get('driverside-availability-booking', [BookingAvailabilityController::class, 'showBookingForm']);

//search
Route::post('search', [SearchController::class, 'showSearch']);
Route::post('filterBy', [SearchController::class, 'filter']);
/*----leftsearch ------------------------*/
Route::post('getLeftSearch', [SearchController::class, 'getLeftSearch'])->name('getLeftSearch');

//User display
// Route::get('agency-details/{id}', [UserDisplayController::class, 'agencydetails']);
// Route::get('driver-details/{id}', [UserDisplayController::class, 'driverdetails']);
// Route::get('user-details/{id}', [UserDisplayController::class, 'details']);
// Route::get('users/status/{status}/{id}', [App\Http\Controllers\UserDisplayController::class, 'status']);

//Driver booking list
// Route::get('driver-availability-booking-list', [DriverBookingController::class, 'view']);

//Driver Car Info
// Route::get('driver-car-info', [DriverController::class, 'showDriverCarInfo']);
// Route::post('add-driver-car-info', [DriverController::class, 'addDriverCarInfo'])->name('driver.car.info');
// Route::get('driver-car-history', [DriverController::class, 'showDriverCarHistory']);
// Route::get('driver-car-registration', [DriverController::class, 'showDriverCarRegistration']);
// Route::get('driver-vehicle-info/delete/{id}', [DriverController::class, 'delete']);
// Route::get('edit-driver-car-info/{id}', [DriverController::class, 'edit']);
// Route::post('update-driver-car-info', [DriverController::class, 'vehicleUpdate']);
// Route::post('searchVehicle', [DriverController::class, 'search'])->name('search.data');

//Agency
// Route::get('travel-agency-availability-booking', [TravelAgentController::class, 'bookMyAvailability']);
// Route::get('search-location', [TravelAgentController::class, 'searchLocation'])->name('searchlocation');
// Route::post('fetch-mobile-number', [TravelAgentController::class, 'fetchMobile']);
// Route::post('Add-booking-agency', [TravelAgentController::class, 'addBooking'])->name("add.booking");
// Route::get('agency-availability-booking', [TravelAgentController::class, 'showBookMyAvailability']);
// Route::post('searchAgencyVehicle', [TravelAgentController::class, 'search']);
// Route::post('searchDriver', [TravelAgentController::class, 'searchAgencyDriver']);

//Agency Car and Driver Info
// Route::get('agency-car-registration', [TravelAgentController::class, 'showCar']);
// Route::get('agency-driver-registration', [TravelAgentController::class, 'showDriver']);
// Route::get('agency-car-info', [TravelAgentController::class, 'showAgencyCarInfo']);
// Route::post('add-agency-car-info', [TravelAgentController::class, 'storeAgencyCarInfo'])->name('agency.car.info');
// Route::get('agency-car-history', [TravelAgentController::class, 'viewAgencyCarHistory']);
// Route::post('add-agency-driver-info', [TravelAgentController::class, 'addAgencyDriverInfo'])->name('agency.driver.info');
// Route::get('agency-driver-history', [TravelAgentController::class, 'showAgencyDriverHistory']);
// Route::get('Agency-vehicle-info/delete/{id}', [TravelAgentController::class, 'delete']);
// Route::get('edit-agency-car-info/{id}', [TravelAgentController::class, 'edit']);
// Route::post('update-agency-car-info', [TravelAgentController::class, 'vehicleUpdate']);
// Route::get('agency-driver-info-delete/delete/{id}', [TravelAgentController::class, 'driverDelete']);
// Route::get('edit-agency-driver-info/{id}', [TravelAgentController::class, 'driverEdit']);
// Route::post('update-agency-driver-info', [TravelAgentController::class, 'driverUpdate']);

//CMS page list
// Route::get('cms-pages-list', [CmsPageController::class, 'view'])->name('cms-page-list');
// Route::get('edit-cms-page/{id}', [CmsPageController::class, 'edit']);
// Route::post('update-cms-page', [CmsPageController::class, 'update']);

//Contact-Us
Route::get('contactus', [ContactUsController::class, 'index']);
Route::post('contactus', [ContactUsController::class, 'store'])->name('contact.store');
Route::post('delete_contact', [ContactUsController::class, 'destroy']);

Route::get('right-contact', [ContactUsController::class, 'rightcontact']);
Route::get('edit-right-contact/{id}', [ContactUsController::class, 'edit']);
Route::post('update-right-contact', [ContactUsController::class, 'update']);
Route::get('contact-us', [ContactUsController::class, 'show']);
Route::get('driver-policy',[PrivacyPolicyController::class,'index']);


// for admin routes
Route::group(['middleware' => ['auth', 'admin']], function () {
    
   
    Route::get('paytm-details', [PaytmController::class, 'index'])->name('paytm.details');
    Route::post('paytm-details-insert', [PaytmController::class, 'store']);
    Route::get('booking-requests/{status}', [BookingRequestController::class, 'bookingDetails'])->name("Booking.request");
    Route::get('driver-customer-details/{id}', [BookingRequestController::class, 'driverCustomerDetails'])->name('driverCustomerDetails');
    Route::get('confirm-payment/{bookingRequestId}',[BookingRequestController::class,'confirmPayment'])->name('confirmPayment');
    Route::get('cancel-payment/{bookingRequestId}',[BookingRequestController::class,'cancelPayment'])->name('cancelPayment');
    Route::get('adminHomePage', [UserDisplayController::class, 'adminHomePage'])->name('adminHomePage');
    Route::get('users-list', [UserDisplayController::class, 'view']);
    Route::get('customer-list', [UserDisplayController::class, 'customerList']);
    Route::get('payment-pending', [BookingRequestController::class, 'paymentPending']);
    Route::get('collect-pending-payment/{bookingId}', [BookingRequestController::class, 'collectPendingPayment']);

    // Route::get('/home', [HomeController::class, 'index'])->name('home');

    //Admin
    Route::get('location', [LocationController::class, 'index']);
    Route::get('location-form', [LocationController::class, 'create']);
    Route::get('location-form/{id}', [LocationController::class, 'create']);
    Route::post('add_location', [LocationController::class, 'store']);
    Route::post('delete_location', [LocationController::class, 'destroy']);

    Route::get('vehicle', [VehicleTypeController::class, 'index']);
    Route::get('vehicle-form', [VehicleTypeController::class, 'create']);
    Route::get('vehicle-form/{id}', [VehicleTypeController::class, 'create']);
    Route::post('add_vehicle', [VehicleTypeController::class, 'store']);
    Route::post('delete_vehicle', [VehicleTypeController::class, 'destroy']);

    Route::post('Add-booking', [BookingAvailabilityController::class, 'store'])->name('driver.booking');
    Route::get('my-availability-history', [BookingAvailabilityController::class, 'viewBookingHistory'])->name('mybooking');

    Route::get('driver-availability/{id}', [DriverAgencyBookingAvailability::class, 'ShowDriverForm']);
    Route::post('add-admin-driver-booking', [DriverAgencyBookingAvailability::class, 'addAdminDriver']);
    Route::get('agency-availability/{id}', [DriverAgencyBookingAvailability::class, 'ShowAgencyForm']);
    Route::post('add-admin-agency-booking', [DriverAgencyBookingAvailability::class, 'addAgencyDriver']);
    Route::post('fetch-mobile-number-agency', [DriverAgencyBookingAvailability::class, 'fetchMobile']);
    
    

    //User display
    Route::get('driver-details/{id}', [UserDisplayController::class, 'driverdetails']);
    Route::get('agency-driver-details/{id}', [UserDisplayController::class, 'agencyDriverDetails']);
    Route::get('agency-details/{id}', [UserDisplayController::class, 'agencydetails']);
    Route::get('user-details/{id}', [UserDisplayController::class, 'details']);
    Route::get('users/status/{status}/{id}', [App\Http\Controllers\UserDisplayController::class, 'status']);
    Route::get('delete-user/{id}', [UserDisplayController::class, 'deleteUser']);
    


    // Route::get('admin-change-password', [ChangePasswordController::class, 'adminPassword']);
    // Route::post('admin-change-password', [ChangePasswordController::class, 'storeNewPassword'])->name('admin.change.password');
    //Driver booking list
    Route::get('driver-availability-booking-list', [DriverBookingController::class, 'view']);

    //  //Driver booking list
    //  Route::get('driver-availability-booking-list', [DriverBookingController::class, 'view']);

    //CMS page list


    Route::get('cms-pages-list', [CmsPageController::class, 'view'])->name('cms-page-list');
    Route::get('edit-cms-page/{id}', [CmsPageController::class, 'edit']);
    Route::post('update-cms-page', [CmsPageController::class, 'update']);

//app dash route start
Route::get('app/drivers', [DriverController::class, 'driverAppList']);

 //Route::get('/admin/app/drivers', [DriverController::class, 'driverAppList']);
Route::get('/admin/app/delete-user/{id}', [UserDisplayController::class, 'deleteUser']);
// Route::get('delete-user/{id}', [UserDisplayController::class, 'deleteUser']);

Route::get('/admin/app/driver-details/{id}', [UserDisplayController::class, 'driverdetailsapp']);
Route::get('/admin/app/driver/approve-profile/{driver_id}', [DriverController::class, 'approveprofile']);
Route::get('/admin/app/driver/approve-docs/{driver_id}', [DriverController::class, 'approvedocs']);
Route::get('/admin/app/driver/approve-vehicle/{vehicle_id}', [DriverController::class, 'approvevehicle']);
Route::get('/admin/app/driver-policy',[PrivacyPolicyController::class,'edit']);
Route::get('/admin/app/blockeduser',[UserDisplayController::class,'blockeduserlist']);
Route::get('/admin/app/aproveuser/{uid}',[UserDisplayController::class,'reactivateuser']);

Route::post('/admin/updatepolicy',[PrivacyPolicyController::class,'update']);









//app dash route end

// http://127.0.0.1:8000/admin/app/drivers








    
});

Route::group(['middleware' => ['auth', 'users']], function () {
    Route::get('/my-account', [HomeController::class, 'myAccount'])->name('my_account');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Route::get('/my-account', [HomeController::class, 'myAccount'])->name('my_account');

    //Change-Password
    // Route::get('change-password', [ChangePasswordController::class, 'index']);
    // Route::post('change-password', [ChangePasswordController::class, 'store'])->name('change.password');

    Route::post('Add-booking', [BookingAvailabilityController::class, 'store'])->name('driver.booking');
    Route::get('my-availability-history', [BookingAvailabilityController::class, 'viewBookingHistory'])->name('mybooking');

    Route::post('Add-booking', [BookingAvailabilityController::class, 'store'])->name('driver.booking');
    Route::get('my-availability-history', [BookingAvailabilityController::class, 'viewBookingHistory'])->name('mybooking');

    //Driver
    Route::get('edit-driver-dashbord', [DriverController::class, 'EditDriverProfile'])->name('EditDriverProfile');
    Route::post('update-driver-dashbord', [DriverController::class, 'update'])->name('drivr_update');

    //For Vehicle Type Droup Down
    // Route::get('driver-registration', [DriverRegisterController::class, 'index']);

    //Travel-Agent
    Route::get('edit-travel-dashbord', [TravelAgentController::class, 'EditTravelProfile'])->name('EditTravelProfile');
    Route::post('update-travel-dashbord', [TravelAgentController::class, 'update'])->name('travel_update');

    //Driver add booking availability
    Route::get('driver-availability-booking', [BookingAvailabilityController::class, 'AddData'])->name('add.booking.availability');
    Route::any('search-driver-availability-booking', [BookingAvailabilityController::class, 'searchDriverBooking'])->name('search.booking.availability');
    Route::get('driverside-availability-booking', [BookingAvailabilityController::class, 'showBookingForm']);




    //Driver Car Info
    Route::get('driver-car-info', [DriverController::class, 'showDriverCarInfo']);
    Route::post('add-driver-car-info', [DriverController::class, 'addDriverCarInfo'])->name('driver.car.info');
    Route::get('driver-car-history', [DriverController::class, 'showDriverCarHistory']);
    Route::get('driver-car-registration', [DriverController::class, 'showDriverCarRegistration']);
    Route::get('driver-vehicle-info/delete/{id}', [DriverController::class, 'delete']);
    Route::get('edit-driver-car-info/{id}', [DriverController::class, 'edit']);
    Route::post('update-driver-car-info', [DriverController::class, 'vehicleUpdate']);
    Route::get('driver-book-availability/delete/{id}', [DriverController::class, 'deleteBookAvailability']);
    Route::get('edit-driver-book-availability/{id}', [DriverController::class, 'editBookAvailability']);
    Route::post('update-booking', [DriverController::class, 'updateBooking']);
    Route::any('searchVehicle', [DriverController::class, 'search'])->name('search.data');
    Route::post('search-booking-history', [DriverController::class, 'searchBookingHistory'])->name('searchBookingHistory');

        Route::get('driver-booking-history',[DriverController::class, 'driverBookingHistory'])->name('driverBookingHistory');
    //Agency
    Route::get('travel-agency-availability-booking', [TravelAgentController::class, 'bookMyAvailability']);
    Route::any('search-agency-availability-booking', [TravelAgentController::class, 'searchBookMyAvailability']);
    Route::post('fetch-mobile-number', [TravelAgentController::class, 'fetchMobile']);
    Route::post('Add-booking-agency', [TravelAgentController::class, 'addBooking'])->name("add.booking");
    Route::get('agency-availability-booking', [TravelAgentController::class, 'showBookMyAvailability']);
    Route::any('searchAgencyVehicle', [TravelAgentController::class, 'search']);
    Route::get('agency-book-availability/delete/{id}', [TravelAgentController::class, 'deleteAgencyBookAvailability']);
    Route::get('edit-travel-agent-availability-booking/{id}', [TravelAgentController::class, 'editAgencyBookAvailability']);
    Route::post('edit-booking-agency', [TravelAgentController::class, 'updateAgencyBookAvailability']);
    Route::any('searchDriver', [TravelAgentController::class, 'searchAgencyDriver']);

    //Agency Car and Driver Info
    Route::get('agency-car-registration', [TravelAgentController::class, 'showCar']);
    Route::get('agency-driver-registration', [TravelAgentController::class, 'showDriver']);
    Route::get('agency-car-info', [TravelAgentController::class, 'showAgencyCarInfo']);
    Route::post('add-agency-car-info', [TravelAgentController::class, 'storeAgencyCarInfo'])->name('agency.car.info');
    Route::get('agency-car-history', [TravelAgentController::class, 'viewAgencyCarHistory']);
    Route::post('add-agency-driver-info', [TravelAgentController::class, 'addAgencyDriverInfo'])->name('agency.driver.info');
    Route::get('agency-driver-history', [TravelAgentController::class, 'showAgencyDriverHistory']);
    Route::get('Agency-vehicle-info/delete/{id}', [TravelAgentController::class, 'delete']);
    Route::get('edit-agency-car-info/{id}', [TravelAgentController::class, 'edit']);
    Route::post('update-agency-car-info', [TravelAgentController::class, 'vehicleUpdate']);
    Route::get('agency-driver-info-delete/delete/{id}', [TravelAgentController::class, 'driverDelete']);
    Route::get('edit-agency-driver-info/{id}', [TravelAgentController::class, 'driverEdit']);
    Route::post('update-agency-driver-info', [TravelAgentController::class, 'driverUpdate']);
});


//inquiry
Route::post('store-inquiry', [InquiryController::class, 'store']);
Route::get('inquiry-list', [InquiryController::class, 'index']);
//search home page store user list
Route::get('search-users-list', [InquiryController::class, 'searchuser']);
Route::get('search-users/status/{status}/{id}', [InquiryController::class, 'status']);
Route::get('delete-searchuser/{id}', [InquiryController::class, 'deleteUser']);