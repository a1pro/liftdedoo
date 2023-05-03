<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\driver;
use App\Models\User;
use App\Models\travel_agent;
use App\Models\Booking\BookingAvailabilty;
use App\Models\booking_request;
use App\Models\vehicle;
use Auth;

class UserDisplayController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * View Users List.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        $auth = Auth::user();
        $users = User::where('role', '!=', 0)->orderby('users.id', 'DESC')
        ->get();

        $userInfo=[];
        foreach($users as $user)
        {

            if($user->role == '1')
            {
                $driver=driver::where('user_id',$user->id)->first();
                if($driver != "")
                {
                    if($driver ->travel_agent_id == "")
                    {
                        $userData['name'] =$driver->name;
                        $userData['mobile'] =$user->mobile;
                        $userData['gender'] =$driver->gender;
                        $userData['role'] =$user->role;
                        $userData['email'] =$user ->email;
                        $userData['id'] =$user->id;
                        $userData['status'] =$user->status;
                        $userData['mobile_verify_status'] =$user->mobile_verify_status;
                        $userData['tarvelAgent'] =$driver ->travel_agent_id;
                        array_push($userInfo, $userData);
                    }
                }
            }
            else
            {
                $agency=travel_agent::where('user_id',$user->id)->first();
                if($agency != "")
                {
                    $userData['name'] =$agency->agency_name;
                    $userData['mobile'] =$user->mobile;
                    $userData['gender'] ="";
                    $userData['role'] =$user->role;
                    $userData['email'] =$user ->email;
                    $userData['id'] =$user->id;
                    $userData['status'] =$user->status;
                    $userData['mobile_verify_status'] =$user->mobile_verify_status;
                    $userData['tarvelAgent'] = "";
                    array_push($userInfo, $userData);
                }
            }
        }
        return view('admin.users.userlist',compact('userInfo','auth'));
    }
    
    /**
     * View Travel Agent details.
     *
     * @param  \App\Models\travel_agent  $travel_agent
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agencydetails(Request $request, $id = '')
    {
        $role = User::where('id', $id)->first();
        $users = travel_agent::where(['user_id' => $role->id])->first();
        $vehicles = vehicle::leftJoin('users', function ($join) {
            $join->on('vehicles.user_id', '=', 'users.id');
        })->join('vehicle_types', function ($join) {
            $join->on('vehicles.vehicle_type_id', '=', 'vehicle_types.id');
        })->where('users.id', $role->id)->get();
        return view('admin.users.agency-details', compact('users', 'role','vehicles'));
    }

    /**
     * View Driver Details.
     *
     * @param  \App\Models\driver  $driver
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function driverdetails(Request $request, $id = '')
    {
        $role = User::where('id', $id)->first();
        $users = driver::where(['user_id' => $role->id])->first();
        $vehicles = vehicle::leftJoin('users', function ($join) {
            $join->on('vehicles.user_id', '=', 'users.id');
        })->join('vehicle_types', function ($join) {
            $join->on('vehicles.vehicle_type_id', '=', 'vehicle_types.id');
        })->where('users.id', $role->id)->get();
        return view('admin.users.driver-details', compact('users', 'role','vehicles'));
    }

    public function adminHomePage()
    {
        $booking = booking_request::Join('locations as two', function ($join) {
            $join->on('booking_requests.booking_start_location_id', '=', 'two.id');
            })->Join('locations as one', function ($join) {
                $join->on('booking_requests.booking_end_location_id', '=', 'one.id');
            })->Join('booking_availabilties', function ($join) {
                $join->on('booking_requests.booking_availability_id', '=', 'booking_availabilties.id');
            })->select([
                'booking_requests.*',
                'two.location as startLocation',
                'one.location as endLocation',
                'booking_availabilties.driver_id as driverId'
            ])->where('booking_requests.status','0')->orderBy('booking_requests.id','DESC')->count();
        return view('admin.index');
    }

    /**
     * Active/Deactive Status.
     *
     * @param  \App\Models\driver  $driver
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request, $status, $id)
    {
        $model = User::find($id);
        $model->status = $status;
        $model->save();
        return redirect()->back();
    }

    public function deleteUser($id)
    {
        try{        
            $userRole = User::where('id',$id)->first();
            if($userRole->role == "1" || $userRole->role == "3")
            {
                $userDriver = driver::where('user_id',$userRole->id)->first();
                $userDriverBook = BookingAvailabilty::where('driver_id',$userDriver->id)->get();
                if(count($userDriverBook) > 0)
                {
                    foreach($userDriverBook as $userBookAvailability)
                    {
                        $userDriverBookRequests = booking_request::where('booking_availability_id',$userBookAvailability->id)->get();
                        if(count($userDriverBookRequests) > 0)
                        {
                            foreach($userDriverBookRequests as $driverBookRequests)
                            {
                                $driverBookRequests -> delete();
                            }
                        }
                        $userBookAvailability -> delete();
                    }
                }
                $userData = User::where('mobile',$userRole->mobile)->get();
                $userDriver->delete();
                if(count($userData) > 0)
                {
                    foreach($userData as $userMultipleData)
                    {
                        $userMultipleData -> delete();
                    }
                }
                else
                {
                    $userRole->delete();
                }
                Session()->flash('status', 'Driver Delete Successfully ');
                return redirect()->back();
            }
            elseif($userRole->role == "2"){
                $userAgent = travel_agent::where('user_id' ,$userRole->id)->first();
                $userAgentDriver = driver::where('travel_agent_id',$userAgent->id)->get();     
                if(count($userAgentDriver) > 0)
                {
                    foreach($userAgentDriver as $agentDriver)
                    {
                        $userBook = BookingAvailabilty::where('driver_id',$agentDriver->id)->get();
                        if(count($userBook) > 0)
                        {
                            foreach($userBook as $userBookAvailability)
                            {
                                $userAgentDriverBookRequests = booking_request::where('booking_availability_id',$userBookAvailability->id)->get();
                                if(count($userAgentDriverBookRequests) > 0)
                                {
                                    foreach($userAgentDriverBookRequests as $driverBookRequests)
                                    {
                                        $driverBookRequests -> delete();
                                    }
                                }
                                $userBookAvailability -> delete();
            
                            }
                        }
                        $driverAgentMobile = User::where('id',$agentDriver->user_id)->first();
                        if($driverAgentMobile != "")
                        {
                            $driverMultiMobile = User::where('mobile',$driverAgentMobile->mobile)->get();
                            if(count($driverMultiMobile) > 0)
                            {
                                foreach($driverMultiMobile as $driverMobile)
                                {
                                            $driverMobile -> delete();
                
                                }
                            }
                            $driverAgentMobile->delete();
                        }
                        $agentDriver -> delete();
                    }
                }
                $userAgent->delete();
                $userData = User::where('mobile',$userRole->mobile)->get();
                if(count($userData) > 0)
                {
                    foreach($userData as $userMultipleData)
                    {
                        $userMultipleData -> delete();
                    }
                }
                else
                {
                    $userRole->delete();
                }
                Session()->flash('status', 'Agent Delete Successfully ');
                return redirect()->back();
            }
        }
        catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Show Customer List.
     *
     */

    public function customerList(){
        $customers = booking_request::orderBy('id','desc')->get();
        return view('admin.users.customer-list',compact('customers'));
    }
    
    public function agencyDriverDetails($id){
        $user = User::where('id',$id)->first();
        $agency=travel_agent::where('user_id',$id)->first();
        $drivers=driver::where('travel_agent_id',$agency->id)->get();
        $userInfo=[];

        if($drivers != "")
        {
            foreach($drivers as $driver)
            {
                $driverProfile = User::where('id',$driver->user_id)->first();
                $userData['name'] =$driver->name;
                $userData['mobile'] =$driverProfile->mobile;
                $userData['gender'] =$driver->gender;
                $userData['id'] =$driverProfile->id;
                $userData['status'] =$driverProfile->status;
                $userData['agency_name'] =$agency->agency_name;
                array_push($userInfo, $userData);
            }
        }
        return view('admin.users.agency-driver-details',compact('userInfo'));
    }


    public function driverdetailsapp(Request $request, $id = '')
    {
        // die('fgfgyh');
        $role = User::where('id', $id)->first();
        $users = driver::where(['user_id' => $role->id])->first();
        $vehicles = vehicle::select('vehicles.*','vehicle_types.vehicle_name','vehicle_types.seat_capacity')->leftJoin('users', function ($join) {
            $join->on('vehicles.user_id', '=', 'users.id');
        })->join('vehicle_types', function ($join) {
            $join->on('vehicles.vehicle_type_id', '=', 'vehicle_types.id');
        })->where('users.id', $role->id)->get();
        return view('app-admin.drivers.driver-details', compact('users', 'role','vehicles'));
         //return view('admin.users.driver-details', compact('users', 'role','vehicles'));
    }

    public function blockeduserlist()
    {
        $blockedusers = User::where('otp_count','=',2)->get();
        return view('app-admin.drivers.blockedusers',compact('blockedusers'));
    }

    public function reactivateuser(Request $request)
    {
        $uid = $request->uid;

        $userdetail = User::find($uid);
        $userdetail->otp_count =0;
        $userdetail->save();

        return redirect('/admin/app/blockeduser');
    }

}
