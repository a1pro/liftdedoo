<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['vehicles'] = VehicleType::all();
        return view("admin.vehicle_type", $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = '')
    {
        if ($id > 0) {
            $arr = VehicleType::where(['id' => $id])->get();
            $result['vehicle_name'] = $arr[0]->vehicle_name;
            $result['seat_capacity'] = $arr[0]->seat_capacity;
            $result['id'] = $arr[0]->id;
        } else {
            $result['vehicle_name'] = '';
            $result['seat_capacity'] = '';
            $result['id'] = 0;
        }
        return view("admin.vehicle_form", $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->post('id') > 0) {
            $vehicle = VehicleType::find($request->post('id'));
            $msg= 'Vehicle Type Updated Successfully';
        } else {
            $vehicle = new VehicleType();
            $msg= 'Vehicle Type Added Successfully';
        }
        $vehicle->vehicle_name = $request->post("vehicle_name");
        $vehicle->seat_capacity = $request->post("seat_capacity");
        $vehicle->save();
        Session()->flash('success', $msg);
        return redirect("vehicle");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleType $vehicleType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleType $vehicleType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleType $vehicleType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $vehicle = VehicleType::find($request->id);
        $vehicle->delete();

        return 0;
    }
}
