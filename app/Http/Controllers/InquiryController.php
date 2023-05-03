<?php

namespace App\Http\Controllers;

use App\Models\booking_request;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Validator;
use App\Models\SearchUser;

class InquiryController extends Controller
{

	public function store(Request $request){
        //dd($request->all());
		$validator = Validator::make($request->all(), [
            'inquiry_start_location' => 'required',
            'inquiry_end_location' => 'required',
            'inquiry_start_time' => 'required',
            'inquiry_user_phone' => 'required|numeric|min:10',
            'inquiry_message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'failure',
            ],500);
        }
        $inquiry = new Inquiry();
        $inquiry->inquiry_start_location = $request->inquiry_start_location;
        $inquiry->inquiry_end_location = $request->inquiry_end_location;
        $inquiry->inquiry_start_time = $request->inquiry_start_time;
        //$inquiry->inquiry_end_time = $request->inquiry_end_time;
        $inquiry->inquiry_user_phone = $request->inquiry_user_phone;
        $inquiry->inquiry_message = $request->inquiry_message;
        $inquiry->save();
        return response()->json([
            'message' => 'Your Inquiry successfully Added',
            'status' => 'success',
        ],200);
	}
    public function index(Request $request){
        $inquiry = Inquiry::orderBy('id','DESC')->get();
        return view('admin.inquiry',compact('inquiry'));
    }

    public function searchuser(Request $request){
        $searchusers = SearchUser::orderBy('id','DESC')->get();
        return view('admin.search_users',compact('searchusers'));
    }
    public function status(Request $request, $status, $id)
    {
        $model = SearchUser::find($id);
        $model->status = $status;
        $model->save();
        Session()->flash('status', 'Search User Updated Successfully ');
        return redirect()->back();
    }
    public function deleteUser($id)
    {
        $model = SearchUser::find($id);
        $model->delete();
        Session()->flash('status', 'Search Delete Successfully ');
        return redirect()->back();
    }


}