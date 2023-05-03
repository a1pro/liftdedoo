 @if (count($booking)>0)
<div class="row text-center new-append test">    
   
    @foreach ($booking as $list)
    <div class="col-12 even filterCheck">
        <ul>
            <li class="place-sec even">
                <span class="place">
                    <span>{{ $list->startLocation }}</span>
                    <span class="icon-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                    <span>{{ $list->endLocation }}</span> </span>
            <li class="grey price-sec"><span class="price">{{$list->distance_price}}</span></li>
            </li>
            <?php $vehicleName = App\Models\VehicleType::getVehicleName($list->vehicle_id); ?>
            <li class="even frst car-name-sec"><span id="{{ $list->vehicle_id }}">{{$vehicleName}}</span>
            </li>
            <li class="grey car-no-sec"><span class="car-no">
                    <span>{{ $list->dateFormat($list->start_time) }}</span>
                    <span class="icon-arrow">
                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                    <span>{{ $list->dateFormat($list->end_time) }}</span> </span></span>
            </li>
            @if($list->bookingRequestId != "")
            <li class="even book-now-sec"><a href="javascript:void(0)" class="booknow" onClick="return alert('This car already book, please try with another car')">book now</a>
                <a href="javascript:void(0)" class="quick-view" data-toggle="modal" data-target="#quickView-{{ $list->id }}">Quick View <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
            </li>
            @else
            <li class="even book-now-sec"><a href="#" class="booknow" data-toggle="modal" data-target="#myModal-{{$list->id}}" onClick="captcha('{{$list->id}}')">book now</a>
                <a href="javascript:void(0)" class="quick-view" data-toggle="modal" data-target="#quickView-{{ $list->id }}">Quick View <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
            </li>
            @endif
        </ul>
    </div>
    @endforeach
   
</div>
 @else

<p class="text-center error-massage">No Data Found</p>

@endif
 