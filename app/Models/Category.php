<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    // softdeletes untuk penghapusan sementara. jadi data tidak benar dihapus
    // jgn lupa tambahkan field baru ketika menggunakan softdeletes untuk menyimpan data yg dihapus
    use SoftDeletes;

    // field mana saja yg boleh dientry datanya
    protected $fillable = [
        'user_id',
        'category_name',
    ];

    // fungsi eqloquent one to one
    // artinya: tabel categories memiliki satu relasi ke tabel users,
    // dimana field yg berelasi adalah field id{tabel user} dengan field user_id{tabel categories}
    // dengan adanya eloquent one to one kita dapat memanggil nama dari user dengan model category

    // jika relasi one to onenya cuman read data, tidak perlu ada foreign key tidak apa,
    // namun sebaiknya diberi foreign key untuk setiap primary key dari tabel lain,
    // dengan begitu kita dapat mengolah data tabel lain
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }


}