<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking\BookingAvailabilty;
use App\Models\driver;
use App\Models\vehicle;
use App\Models\VehicleType;
use App\Models\location;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\SearchUser;
use App\Notifications\SearchNotification;
use Illuminate\Notifications\Notification;

use function Symfony\Component\String\b;
use Mail;
use App\Http\Controllers\Booking\BookingAvailabilityController;

class SearchController extends Controller
{
    /**
     * Show search page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSearch(Request $request)
    {
        
        
        // $msg = "Hi, Start location: ".$request->start_location." End Location: ".$request->end_location." Phone Number: ".$request->input('phone');
        // $this->sendEmail('rswebtechonline@gmail.com',$msg,[],[]);
        // @mail("rswebtechonline@gmail.com","Search user incoming",$msg);
        try {

            $start_time = date('Y-m-d',strtotime($request->start_time));
            $startLocationId = location::where("location",$request->input('start_location'))->pluck("id")->first();
            $endLocationId = location::where("location",$request->input('end_location'))->pluck("id")->first();
            $phone = $request->input('phone');

            $user_exist = SearchUser::where('search_start_location',$request->start_location)
            ->where('search_end_location',$request->end_location)
            ->where('search_date',$start_time)
            ->where('search_user_phone',$phone)
            ->first();
            if(empty($user_exist) && !empty($phone)){
                $search_user = new SearchUser();
                $search_user->search_start_location = $request->start_location;
                $search_user->search_end_location = $request->end_location;
                $search_user->search_date = $start_time;
                $search_user->search_user_phone = $phone;
                $search_user->save();
            }


            $search = $startLocationId;
            $search2 = $endLocationId;
            $start_time = $start_time;
            $startLocationName = $request->start_location;
            $endLocationName =$request->end_location;
            $capacity = $request->input('capacity');
            $booking = BookingAvailabilty::leftJoin('users', function ($join) {
                $join->on('booking_availabilties.user_id', '=', 'users.id');
            })->Join('locations as two', function ($join) {
                $join->on('booking_availabilties.end_location_id', '=', 'two.id');
            })->Join('locations as one', function ($join) {
                $join->on('booking_availabilties.start_location_id', '=', 'one.id');
            })->Join('vehicles as five', function ($join) {
                $join->on('booking_availabilties.vehicle_id', '=', 'five.id');
            })->leftJoin('booking_requests', function ($join) {
                $join->on('booking_availabilties.id', '=', 'booking_requests.booking_availability_id')->where("booking_requests.status",'=',0);
            })->Join('drivers', function ($join) {
                $join->on('booking_availabilties.driver_id', '=', 'drivers.id');
            })
                ->select([
                    'booking_availabilties.*',
                    'five.vehicle_registration_number as vehicleNumber',
                    'five.vehicle_type_id as vehicleTypeId',
                    'five.capacity as capacity',
                    'five.rate_per_km as rate_per_km',
                    'one.location as startLocation',
                    'two.location as endLocation',
                    'five.capacity as capacity',
                    'booking_requests.id as bookingRequestId',
                    'booking_requests.status as bookingRequestStatus',
                    'drivers.travel_agent_id as travelAgentId',
                    'drivers.name as driverName',
                    'drivers.license_number as driverLicenceNumber',
                    'drivers.age as driverAge',
                    'users.mobile as driverMobile',
                ])->where('booking_availabilties.booking_confirm_status',"=","0")->where('booking_availabilties.end_time','>=',date("Y-m-d H:i"));

                // if($capacity==5 || $capacity==6 || $capacity==7 )
                // {
                //     $capacity="6+1";
                // }
               

                // if($capacity=="6+1" )
                // {
                //     $booking =$booking->where('booking_availabilties.start_location_id', '=', "{$search}")
                //     ->where('booking_availabilties.end_location_id', '=', "{$search2}")
                //     ->where('five.capacity', '=', "6+1")
                //     ->get();
                // }
                // else
                // {
                    $booking =$booking->where('booking_availabilties.start_location_id', '=', "{$search}")
                    ->where('booking_availabilties.end_location_id', '=', "{$search2}")
                    ->get();
                //}

                $book_search=[];
                $vehicle_ids =[];
                $booking_ids =[];
                $ids = null;
                $maxPrice = 0;
                $minPrice = 0;
                $times = 0;
                if(count($booking) >0)
                {
                    foreach($booking as $book)
                    {
                        $startTime = date('Y-m-d', strtotime($book->start_time));
                        $endTime = date('Y-m-d', strtotime($book->end_time));
                        $currentTime = date('Y-m-d', strtotime($request->start_time));

                        if (($currentTime >= $startTime) && ($currentTime <= $endTime))
                        {
                            array_push($book_search, $book);
                        }

                        $vehicle_ids[] = $book->vehicleTypeId;
                        $booking_ids[] = $book->id;
                        $ids = implode(', ',$booking_ids);

                    }
                }
              
            $vehicleType = VehicleType::whereIn('id',$vehicle_ids)->orderBy('vehicle_name','ASC')->get();
            if(isset($ids) && !empty($ids)){
                $priceMaxMin = BookingAvailabilty::select(array('booking_availabilties.*', DB::raw("(SELECT MIN(distance_price) from booking_availabilties where id IN(".$ids.")) minPrice"), DB::raw("(SELECT MAx(distance_price) from booking_availabilties where id IN(".$ids.")) maxPrice")))->whereIn('id',$booking_ids)->first();
          

                if(isset($priceMaxMin->minPrice) &&  isset($priceMaxMin->maxPrice)){
                    if($priceMaxMin->minPrice >=1000){
                        $minPrice = floor($priceMaxMin->minPrice / 1000) * 1000;
                        $times = 1000;
                    } else {
                        $minlength = strlen(floor($priceMaxMin->minPrice));
                        $times = str_pad('1', $minlength, "0");
                        $minPrice =  floor($priceMaxMin->minPrice / $times) * $times;
                    }
                    if($priceMaxMin->maxPrice >=1000){
                        $times = 1000;
                        $maxPrice = floor($priceMaxMin->maxPrice / 1000) * 1000;
                    } else {
                        $maxlength = strlen(floor($priceMaxMin->maxPrice));
                        $times = str_pad('1', $minlength, "0");
        
                        $maxPrice =  floor($priceMaxMin->maxPrice / $times) * $times;
                    }
            
                }

            }

            $distanceKm = 0;
            $booking_cab_15_percent = 0;
            $booking_cab_total = 0;
            $booking_cab_25_percent = 0;
            $booking_large_cab_total = 0;
            $price = 0;

            if(count($booking) == 0){
                $calculateDistance = (new BookingAvailabilityController)->calculateDistanceByLocation($startLocationId,$endLocationId);
                $distanceKm = $calculateDistance['0']->distance_in_km;
                //$booking->distance = round($distanceKm);
                $price = round($distanceKm) * 12 ;
                $priceCommission = $price * 70/100;
                $finalPrice = $price + round($priceCommission);
                $booking_cab_15_percent = $finalPrice;
                $booking_cab_total = 2*$finalPrice;

                $priceCommission = $price * 99/100;
                $finalPrice = $price + round($priceCommission);
                $booking_cab_25_percent = $finalPrice;
                $booking_large_cab_total = 2*$finalPrice;
            }

            $start_timeNew =date('d-m-Y',strtotime($request->start_time));
            // return ['vehicleType' => $vehicleType, 'booking' => $book_search, 'strtLocId' => $search, 'endLocId' => $search2, 'start_time' => $start_timeNew,'capacity' => $capacity,'startLocationName' => $startLocationName,'endLocationName' => $endLocationName,'starttime'=> $request->start_time,'minPrice'=>$minPrice,'maxPrice'=>$maxPrice,'times'=>$times ,'booking_cab_15_percent' => $booking_cab_15_percent,'booking_cab_total'=>$booking_cab_total,'booking_cab_25_percent' => $booking_cab_25_percent,'booking_large_cab_total' => $booking_large_cab_total,'distanceKm' => $distanceKm];
            return view('front.search', ['vehicleType' => $vehicleType, 'booking' => $book_search, 'strtLocId' => $search, 'endLocId' => $search2, 'start_time' => $start_timeNew,'capacity' => $capacity,'startLocationName' => $startLocationName,'endLocationName' => $endLocationName,'starttime'=> $request->start_time,'minPrice'=>$minPrice,'maxPrice'=>$maxPrice,'times'=>$times ,'booking_cab_15_percent' => $booking_cab_15_percent,'booking_cab_total'=>$booking_cab_total,'booking_cab_25_percent' => $booking_cab_25_percent,'booking_large_cab_total' => $booking_large_cab_total,'distanceKm' => $distanceKm]);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Show search page.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        //  dd($request->all());
        try {
            $startLocationId = location::where("id",$request->strtLocId)->pluck("id")->first();
            $endLocationId = location::where("id",$request->endLocId  )->pluck("id")->first();
            $requestStartTime =$request->start_time;
            $requestEndTime =$request->end_time;
            $vehicleId = $request->sort_by_value;

            $capacity = $request->capacity;

            $booking = BookingAvailabilty::leftJoin('users', function ($join) {
                $join->on('booking_availabilties.user_id', '=', 'users.id');
            })
            ->Join('locations as two', function ($join) {
                $join->on('booking_availabilties.end_location_id', '=', 'two.id');
            })
            ->Join('locations as one', function ($join) {
                $join->on('booking_availabilties.start_location_id', '=', 'one.id');
            })
            ->Join('vehicles as five', function ($join) {
                $join->on('booking_availabilties.vehicle_id', '=', 'five.id');
            })
            ->Join('drivers', function ($join) {
                $join->on('booking_availabilties.driver_id', '=', 'drivers.id');
            })
            ->Join('vehicle_types as vehicle_name', function ($join) {
                $join->on('vehicle_name.id', '=', 'five.vehicle_type_id');
            })
            ->leftJoin('booking_requests', function ($join) {
                $join->on('booking_availabilties.id', '=', 'booking_requests.booking_availability_id')->where("booking_requests.status",'=',0);
            })
            ->select([
                'booking_availabilties.*',
                'five.vehicle_registration_number as vehicleNumber',
                'five.id as vehicle_type_id',
                'five.capacity as capacity',
                'one.location as startLocation',
                'two.location as endLocation',
                'drivers.travel_agent_id as travelAgentId',
                'vehicle_name.vehicle_name as vehicleName',
                'vehicle_name.id as vehicleId',
                'booking_requests.id as bookingRequestId',
                'booking_requests.status as bookingRequestStatus',
            ])->where('booking_availabilties.end_time','>=',date("Y-m-d H:i"))
            ->where('booking_availabilties.booking_confirm_status',"=","0")->orderBy('booking_availabilties.id','DESC');

            // dd($request->all(),$startLocationId,$endLocationId,$booking->get());

            if(!empty($capacity)){
                if($capacity==5 || $capacity==6 || $capacity==7 )
                {
                    $capacity="6+1";
                    $booking= $booking ->where('five.capacity',$capacity);
                }
               
            }

            
            if(!empty($requestStartTime)){
                $booking= $booking->where('booking_availabilties.start_time','>=',date('Y-m-d H:i',strtotime($request->start_time)));
            }
            
            if(!empty($requestEndTime)){
                $booking= $booking->where('booking_availabilties.end_time','<=',date('Y-m-d 23:59',strtotime($request->end_time)));
            }
            
            if(!empty($startLocationId)){
                $booking= $booking
                ->where('booking_availabilties.start_location_id',$startLocationId);
            }
            
            if(!empty($endLocationId)){
                $booking= $booking->where('booking_availabilties.end_location_id',$endLocationId);
            }
            
            if(!empty($vehicleId)){
                $booking= $booking->where('vehicle_name.id',$vehicleId);
            }
            $booking = $booking->get();
            if(count($booking)>0){
                $result ='';
                foreach($booking as $list)
                {
                    $vehicleName = VehicleType::getVehicleName($list->vehicle_type_id);
                    $result .='<div class="col-12 even"><ul>
                    <li class="place-sec even">
                        <span class="place">
                            <span>'.$list->startLocation.'</span>
                            <span class="icon-arrow"><i class="fa fa-long-arrow-right"
                                    aria-hidden="true"></i></span>
                            <span>'.$list->endLocation.'</span> </span>
                        <li class="grey price-sec"><span class="price">'.$list->distance_price.'</span></li>
                        </li>
                        <li class="even frst car-name-sec"><span>'.$vehicleName.'</span>
                        </li>
                        <li class="grey car-no-sec"><span class="car-no">
                            <span>'.$list->dateFormat($list->start_time) .'</span>
                            <span class="icon-arrow">
                                <i class="fa fa-long-arrow-right"     aria-hidden="true"></i></span>
                            <span>'.$list->dateFormat($list->end_time).'</span> </span></span>
                        </li>';
                    if($list->bookingRequestId != "")
                    {
                        $result .='<li class="even book-now-sec"><a href="javascript:void(0)" class="booknow" onClick="alertMsg()" >book now</a>
                        <a href="javascript:void(0)" class="quick-view" data-toggle="modal" data-target="#quickView-{{ $list->id }}">Quick View <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                        </li></ul></div>';
                    }
                    else
                    {
                        $result.='<li class="even book-now-sec"><a href="#" class="booknow" data-toggle="modal" data-target="#myModal-'.$list->id.'" onClick="captcha('.$list->id.')">book now</a>
                        <a href="javascript:void(0)" class="quick-view" data-toggle="modal" data-target="#quickView-'.$list->id.'">Quick View <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                        </li></ul></div>';
                    }
                }
                return $result;
            }
            else{
                $result ='<p class="text-center error-massage">No Data Found</p>';
                return $result;
            }

        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }


    public function getLeftSearch(Request $request)
    {
        try {

            $startLocationId = location::where("id",$request->strtLocId)->pluck("id")->first();
            $endLocationId = location::where("id",$request->endLocId)->pluck("id")->first();
            $vehicleId = explode(',', $request->carTypes);
            $priceRanges = explode(',', $request->priceRanges);
            $minRange = explode(',', $request->minRange);
            $maxRange = explode(',', $request->maxRange);
            $capacity = $request->capacity;
            $start_time = $request->startDate;
            $booking = BookingAvailabilty::leftJoin('users', function ($join) {
                $join->on('booking_availabilties.user_id', '=', 'users.id');
            })
            ->Join('locations as two', function ($join) {
                $join->on('booking_availabilties.end_location_id', '=', 'two.id');
            })
            ->Join('locations as one', function ($join) {
                $join->on('booking_availabilties.start_location_id', '=', 'one.id');
            })
            ->Join('vehicles as five', function ($join) {
                $join->on('booking_availabilties.vehicle_id', '=', 'five.id');
            })
            ->Join('drivers', function ($join) {
                $join->on('booking_availabilties.driver_id', '=', 'drivers.id');
            })
            ->Join('vehicle_types as vehicle_name', function ($join) {
                $join->on('vehicle_name.id', '=', 'five.vehicle_type_id');
            })
            ->leftJoin('booking_requests', function ($join) {
                $join->on('booking_availabilties.id', '=', 'booking_requests.booking_availability_id')->where("booking_requests.status",'=',0);
            })
            ->select([
                'booking_availabilties.*',
                'five.vehicle_registration_number as vehicleNumber',
                'five.id as vehicle_type_id',
                'five.capacity as capacity',
                'one.location as startLocation',
                'two.location as endLocation',
                'drivers.travel_agent_id as travelAgentId',
                'vehicle_name.vehicle_name as vehicleName',
                'vehicle_name.id as vehicleId',
                'booking_requests.id as bookingRequestId',
                'booking_requests.status as bookingRequestStatus',
            ])->where('booking_availabilties.end_time','>=',date("Y-m-d H:i"))
            ->where('booking_availabilties.booking_confirm_status',"=","0")->orderBy('booking_availabilties.id','DESC');

            // dd($request->all(),$startLocationId,$endLocationId,$booking->get());

            if(!empty($capacity)){
                if($capacity==5 || $capacity==6 || $capacity==7 )
                {
                    $capacity="6+1";
                    $booking= $booking ->where('five.capacity',$capacity);
                }
               
            }
            
            if(!empty($startLocationId)){
                $booking= $booking
                ->where('booking_availabilties.start_location_id',$startLocationId);
            }
            
            if(!empty($endLocationId)){
                $booking= $booking->where('booking_availabilties.end_location_id',$endLocationId);
            }
            
            if (is_null($request->carTypes) == false) {
                $booking->whereIn('vehicle_name.id',$vehicleId);
            }
           if (is_null($request->priceRanges) == false) {
                $booking->where(function($query) use ($minRange) {
                    foreach ($minRange as $key => $min) {
                        if ($key === 0) {
                            $query->where('booking_availabilties.distance_price', '>=', $min);
                            continue;
                        }
                        $query->orWhere('booking_availabilties.distance_price', '>=', $min);
                    }

                });
                
            }
            if (is_null($request->priceRanges) == false) {
                $booking->where(function($query) use ($maxRange) {
                    foreach ($maxRange as $key => $max) {
                        if ($key === 0) {
                            $query->where('booking_availabilties.distance_price', '<=', $max);
                            continue;
                        }
                        $query->orWhere('booking_availabilties.distance_price', '<=', $max);
                    }
                    
                });
                
            }
            
            $booking = $booking->get();
            $book_search=[];
                if(count($booking) >0)
                {
                    foreach($booking as $book)
                    {
                        $startTime = date('Y-m-d', strtotime($book->start_time));
                        $endTime = date('Y-m-d', strtotime($book->end_time));
                        $currentTime = date('Y-m-d', strtotime($request->startDate));

                        if (($currentTime >= $startTime) && ($currentTime <= $endTime))
                        {
                            array_push($book_search, $book);
                        }


                    }
                }
            return view('front.search_list', [ 'booking' => $book_search]);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    // public function sendEmail($to,$body,$cc,$bcc){
    //     try{
    //         Mail::to($to)->send($body);
    //         //->cc($cc)->bcc($bcc)

    //         return true;
    //     } catch (\Exception $e) {

    //         return true;
    //     }
    // }
}
