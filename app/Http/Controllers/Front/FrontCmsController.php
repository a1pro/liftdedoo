<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\cms_pages;

class FrontCmsController extends Controller
{
    public function aboutus(){
        $about=cms_pages::where('page_slug','about-us')->first();
        return view('front.headerpart.aboutus',compact('about'));
    }

    public function mission(){
        $about=cms_pages::where('page_slug','mission-vission')->first();
        return view('front.headerpart.mission_vission',compact('about'));
    }

    public function howItWork(){
        $about=cms_pages::where('page_slug','how-its-work')->first();
        return view('front.headerpart.how-its-work',compact('about'));
    }

    public function services(){
        $about=cms_pages::where('page_slug','services')->first();
        return view('front.footerpart.services',compact('about'));
    }

    public function terms(){
        $about=cms_pages::where('page_slug','terms-conditions')->first();
        return view('front.footerpart.terms',compact('about'));
    }

    public function privacy(){
        $about=cms_pages::where('page_slug','privacy-policy')->first();
        return view('front.footerpart.privecy-policy',compact('about'));
    }

    public function refund(){
        $about=cms_pages::where('page_slug','refund-policy')->first();
        return view('front.footerpart.refund-policy',compact('about'));
    }

    public function disclaimer(){
        $about=cms_pages::where('page_slug','disclaimer')->first();
        return view('front.footerpart.disclaimer',compact('about'));
    }

    public function dataprotection(){
        $about=cms_pages::where('page_slug','data-protection')->first();
        return view('front.footerpart.data-protection',compact('about'));
    }
}
