<?php

namespace App\Http\Controllers;

use App\Models\location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the location data in table.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['locations']=location::all();
        return view('admin.location',$result);
    }

    /**
     * Edit the location.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$id='')
    {
        if($id>0){
            $arr=location::where(['id'=>$id])->get();
            $result['location']=$arr[0]->location;
            $result['latitude']=$arr[0]->latitude;
            $result['longitude']=$arr[0]->longitude;
            $result['id']=$arr[0]->id;
        }else{
            $result['location']='';
            $result['latitude']='';
            $result['longitude']='';
            $result['id']=0;
        }
        return view("admin.location_form",$result);
    }

    /**
     * Store and update location.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->post('id')>0){
            $location=location::find($request->post('id'));
            $msg='Your location updated successfully';

        }else{
            $location=new location();
            $msg='Your location added successfully';
        }

        $location->location=$request->post("location");
        $location->latitude=$request->post("latitude");
        $location->longitude=$request->post("longitude");
        $location->save();
        Session()->flash('success', $msg);
        return redirect("location");
    }


    public function searchLocation(Request $request){

        if($request->location != "")
        {
            $search = $request->location;

            $location = location::select("id", "location")
                ->where('location', 'LIKE', "%{$search}%")
                ->get();
            $output = '';
            foreach($location as $row)
            {
                $output .= $row->location;
            }
            echo $output;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, location $location)
    {
        //
    }

    /**
     * Remove the location from database.
     *
     * @param  \App\Models\location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $location=location::find($request->id);
        $location->delete();

        return 0;
    }
}
