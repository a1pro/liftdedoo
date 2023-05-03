<?php

namespace App\Http\Controllers;

use App\Models\contact_us;
use App\Models\contact_right;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['contact'] = contact_us::all();
        return view('admin.contact_us.contact_us', $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contact = new contact_us();
        $contact->name = $request->name;
        $contact->email    = $request->email;
        $contact->mobile = $request->mobile;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();
        Session()->flash('msg', 'Your  Data Saved Successfully ');
        return redirect()->back();
    }

    /**
     * Display the specified resource.SQLSTATE[23000]: Integrity constraint violation: 1048 Column
     *
     * @param  \App\Models\contact_us  $contact_us
     * @return \Illuminate\Http\Response
     */
    public function rightcontact()
    {
        $result['rightcontact'] = contact_right::all();
        return view('admin.contact_us.right_content', $result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\contact_us  $contact_us
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact_right = contact_right::where(['id' => $id])->first();
        return view('admin.contact_us.edit_right_content', compact('contact_right'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\contact_us  $contact_us
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $contact_right = contact_right::where(['id' => $request->id])->first();
        $contact_right->address = $request->address;
        $contact_right->mobile = $request->mobile;
        $contact_right->email = $request->email;
        $contact_right->update();
        Session()->flash('update', 'Contact  Data Updated Successfully ');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\contact_us  $contact_us
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $contact = contact_us::find($request->id);
        $contact->delete();
        return 0;
    }

    public function show()
    {
        try {
            $result['contact'] = contact_right::orderBy('id', 'ASC')->first();
            return view('front.headerpart.contact', $result);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
}
