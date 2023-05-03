<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show driver and agency change password form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        return view('front.change-password');
    }

    /**
     * change driver and agency password.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
        Session()->flash('change', 'Your Password Changed Successfully ');
        return redirect('/my-account');
    }

    /**
     * Show admin change password form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminPassword()
    {
        return view('admin.admin-change-password');
    }

    /**
     * change admin password.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function storeNewPassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
        Session()->flash('change', 'Your Password Changed Successfully ');
        return redirect()->back();
    }
}
