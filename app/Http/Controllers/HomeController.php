<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Brand;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function HomeSlider(){
        $sliders = Slider::get();
        return view('admin.slider.index',compact('sliders'));
    }

    public function AddSlider(){
        return view('admin.slider.create');
    }

    // fungsi simpan
    public function StoreSlider(Request $request){

        $slider_image = $request->file('image');
        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($slider_image->getClientOriginalExtension());
        $img_name = $name_gen.'.'.$img_ext;
        $up_location = 'image/slider/';
        $last_img = $up_location.$img_name; 

        Image::make($slider_image)->resize(1920,1088)->save($up_location.$img_name);        

        Slider::insert([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $last_img,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('home.slider')->with('success','Insert slider berhasil dilakukan');
    }
}