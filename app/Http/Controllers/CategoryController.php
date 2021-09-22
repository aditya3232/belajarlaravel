<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // middleware
    // jadi dengan middleware, maka sebelum CategoryController mengeksekusi semua function yg ada disini,
    // maka middleware akan dijalankan terlebih dahulu.
    // artinya middleware auth akan memeriksa user sudah login atau belum
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // method read data
    public function AllCat(){
        // $categories = Category::all(); //read data biasa
        // $categories = Category::latest()->get(); //read data dengan urutan data terbaru diatas
        $categories = Category::latest()->paginate(5); //read data dengan paginate
        $trashCat = Category::onlyTrashed()->latest()->paginate(3);//read data yang didelete sementara (soft delete)

        return view('admin.category.index',compact('categories','trashCat'));  //passing data categories ke view
    }

    // method store data
    // karena disini pakai method post, maka haru memanggil (Reuqest)
    // request digunakan untuk menampung data dari form input
    public function AddCat(Request $request){
        // validasi input dari request
        $validated = $request->validate([
        // input field yg akan divalidasi berdasarkan name input
        // unique:{nama tabel}
        // max:{maksimum karakter yg diinput}
        'category_name' => 'required|unique:categories|max:255',
        ],
        [
            // error message yg baru {tidak otomatis dari laravelnya}
            'category_name.required' => 'Nama kategori tidak boleh kosong',
            'category_name.max' => 'Maksimum karakter 255',
        ]);
         
        // store data/ insert data menggunakan eloquent
        Category::insert([
            //'{field table in database}' => $request->{name input in form}
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id, //insert user yg login saat itu
            'created_at' => Carbon::now() //insert time
        ]);

        // cara store data/ insert data yang kedua menggunakan eloquent
        // kelebihannya tidak perlu insert created_at updated_at, karena otomatis ditambah
        // $category = new Category;
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->save();

        // mereturn redirect ke halaman sebelumnya, &  pesan sukses ketika store data
        return redirect()->back()->with('success','Category sudah di insert');
    }

    // method view edit
    // Edit($id) => menampung passing data dari url
    public function Edit($id){
        $categories = Category::find($id); //find, untuk mencari data sesuai yang ada di variabel ($id)

        return view('admin.category.edit',compact('categories')); //yg dipassing adalah data spesifik sesuai dengan idnya
    }

    // method update
    // karena disini pakai method post, maka haru memanggil (Reuqest)
    // request digunakan untuk menampung data dari form input
    // $id menampung passing data dari url
    public function Update(Request $request, $id){
        $update = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
        ]);

        // mereturn redirect ke halaman sebelumnya, &  pesan sukses ketika store data
        // disini g pakai back(), karena nanti malah balik ke view edit
        return redirect()->route('all.category')->with('success','Update data sudah berhasil');
    }

    // method soft delete
    public function SoftDelete($id){
        $delete = Category::find($id)->delete();

        return redirect()->back()->with('success','Category soft delete berhasil dilakukan');
    }

    // method restore
    public function Restore($id){
        // onlyTrashed() = mengambil data yang terhapus sementara
        $delete = Category::onlyTrashed()->find($id)->restore();

        return redirect()->back()->with('success','Category restore berhasil dilakukan');
    }

    // method permenen delete
    public function Pdelete($id){
        $delete = Category::onlyTrashed()->find($id)->forceDelete();

        return redirect()->back()->with('success','Category permanen delete berhasil dilakukan');
    }
}