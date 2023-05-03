<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DriverPolicy;

class PrivacyPolicyController extends Controller
{
    function index()
    {
       
        $policy = DriverPolicy::latest()->first();
        return view('front.footerpart.terms',compact('policy'));  
        //return view('front.privacyandpolicyrider',compact('policy'));  
    }
    function edit()
    {
       
        $policy = DriverPolicy::latest()->first();
        //return view('front.footerpart.terms',compact('policy'));  
        return view('app-admin.privacyandpolicyrider',compact('policy'));
    }
    function update(Request $request)
    {
        $id = $request->id;
        $policy = $request->policy;
        // return $id;
        $policydetail = DriverPolicy::find($id);
        $policydetail->policy = $policy;
        $policydetail->save();
        return redirect('/admin/app/driver-policy');

    }
}
