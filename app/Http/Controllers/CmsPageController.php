<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\driver;
use App\Models\User;
use App\Models\cms_pages;

class CmsPageController extends Controller
{
    public function view(){
        $result['cms']=cms_pages::all();
        return view('admin.cms_pages.cms_pages',$result);
    }

    public function edit($id)
    {
        $pages=cms_pages::where(['id'=>$id])->first();
        return view('admin.cms_pages.edit_cms_pages',compact('pages'));
    }

    public function update(Request $request)
    {
        $pages=cms_pages::where(['id'=>$request->id])->first();
        $pages->title=$request->title;
        $pages->keywords=$request->keywords;
        $pages->description=$request->description;
        $pages->meta_title=$request->meta_title;
        $pages->meta_description=$request->meta_description;
        $pages->update();
        Session()->flash('status', 'Contents Updated Successfully ');
        return redirect()->route('cms-page-list');
    }
}
