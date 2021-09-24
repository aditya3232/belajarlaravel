<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Multipic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    // middleware
    // jadi dengan middleware, maka sebelum CategoryController mengeksekusi semua function yg ada disini,
    // maka middleware akan dijalankan terlebih dahulu.
    // artinya middleware auth akan memeriksa user sudah login atau belum
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //method read data
    public function AllBrand(Request $request){

        $keyword = $request->search; //menangkap kata kunci
        if ($keyword) {
            // jika ada keyword maka passing yang ini
            $brands = Brand::where('brand_name', 'like', "%" . $keyword. "%")->paginate(5);
        } else {
            // jika tidak ada keyword passing data yg ini
            $brands = Brand::latest()->paginate(5);
        }
        return view('admin.brand.index',compact('brands'));
    }

    // public function AllBrand(){

    //     $brands = Brand::latest()->paginate(5);
    //     return view('admin.brand.index',compact('brands'));
    // }

    // method store atau simpan data
    public function StoreBrand(Request $request){
        $validated = $request->validate([
            'brand_name' => 'required|unique:brands|min:4',
            'brand_image' => 'required|mimes:jpg,jpeg,png',//mimes = menentukan jenis file yg diupload
        ],
        [
            'brand_name.required' => 'Nama brand tidak boleh kosong',
            'brand_name.min' => 'Nama brand minimal 4 karakter',
        ]);

        // untuk mengambil file image, ketika user memilih image
        $brand_image = $request->file('brand_image');

        // generate uniq name image yg akan dimasukkan ke database
        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($brand_image->getClientOriginalExtension());// mendapatkan ekstensi file image

        // menggabungkan nama image uniq, dengan ekstensi image nya
        $img_name = $name_gen.'.'.$img_ext;

        // menentukan lokasi file upload image
        $up_location = 'image/brand/';

        // menggabungkan lokasi upload image, dengan $img_name
        // nanti variable $last_img yang akan dimasukkan ke database
        $last_img = $up_location.$img_name; // hasilnya => /image/brand/asidyaih292u2.png

        // memindahkan file image ke lokasinya di public/image, beserta nama yg baru (uniq)
        // $brand_image->move($up_location,$img_name); //yg lama ini. Yang baru pake yg dibawah
        
        // memindahkan file image ke lokasinya,bserta nama yg baru, dan ukuran baru
        Image::make($brand_image)->resize(300,200)->save($up_location.$img_name);        

        // perintah insert ke database
        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_img,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->back()->with('success','Insert brand berhasil dilakukan'); 
    }

    // method tampilan edit
    public function Edit($id){
        $brands = Brand::find($id);
        
        return view('admin.brand.edit',compact('brands'));
    }

    // method update
    public function  Update(Request $request, $id){
        $validated = $request->validate([
            'brand_name' => 'required|min:4',
        ],
        [
            'brand_name.required' => 'Nama brand tidak boleh kosong',
            'brand_name.min' => 'Nama brand minimal 4 karakter',
        ]);

        $old_image = $request->old_image;
        $brand_image = $request->file('brand_image');

        // jika image ada, maka update image beserta namanya,
        // jika tidak ada image, update namanya saja
        // disini diberikan kondisi karena bermasalah ketika namanya saja diupdate adaeror di getClientOriginalExtension()
        if ($brand_image) {
            
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($brand_image->getClientOriginalExtension());
            $img_name = $name_gen.'.'.$img_ext;
            $up_location = 'image/brand/';
            $last_img = $up_location.$img_name; 
            $brand_image->move($up_location,$img_name);
    
            // hapus old_image
            unlink($old_image);
    
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'brand_image' => $last_img,
                'created_at' => Carbon::now(),
            ]);
    
            return redirect()->route('all.brand')->with('success','Update brand berhasil dilakukan');

        } else {
            
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'created_at' => Carbon::now(),
            ]);
    
            return redirect()->route('all.brand')->with('success','Update brand berhasil dilakukan');
        }

    }

    // hapus brand beserta imagenya
    public function Delete($id){
        
        // hapus file image
        $image = Brand::find($id);
        $old_image = $image->brand_image;
        unlink($old_image);

        // hapus row brand berdasarkan id
        Brand::find($id)->delete();

        return redirect()->back()->with('success','Hapus brand berhasil dilakukan');
    }

    // multipic
    public function Multipic(){
        $images = Multipic::all();
        return view('admin.multipic.index',compact('images'));
    }

    // store multipic
    public function StoreImg(Request $request){

        $image = $request->file('image');

        // perulangan untuk upload multipic
        // jadi akan melakukan perulangan pada insert, sesuai dengan jumlah file image yang dipilih
        foreach ($image as $multi_img) {

            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($multi_img->getClientOriginalExtension());
            $img_name = $name_gen.'.'.$img_ext;
            $up_location = 'image/multi/';
            $last_img = $up_location.$img_name; 
            Image::make($multi_img)->resize(300,200)->save($up_location.$img_name);        
    
            // perintah insert ke database
            Multipic::insert([
                'image' => $last_img,
                'created_at' => Carbon::now(),
            ]);
        }

        return redirect()->back()->with('success','Insert brand berhasil dilakukan');
    }

    // user logout
    public function Logout(){

        Auth::logout(); //logout

        return redirect()->route('login'); //kemudian arahkan ke route login

    }
}