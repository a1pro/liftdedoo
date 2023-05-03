<?php

namespace App\Http\Controllers;

use App\Models\vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
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
        $result['vehicles'] = vehicle::all();
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
            $arr = vehicle::where(['id' => $id])->get();
            $result['vehicle_name'] = $arr[0]->vehicle_name;
            $result['id'] = $arr[0]->id;
        } else {
            $result['vehicle_name'] = '';
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
            $vehicle = vehicle::find($request->post('id'));
            $msg= 'Vehicle Type Updated Successfully';
        } else {
            $vehicle = new vehicle();
            $msg= 'Vehicle Type Added Successfully';
        }
        $vehicle->vehicle_name = $request->post("vehicle_name");
        $vehicle->save();
        Session()->flash('success', $msg);
        return redirect("vehicle");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $vehicle = vehicle::find($request->id);
        $vehicle->delete();

        return 0;
    }
}
