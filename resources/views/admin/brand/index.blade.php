@extends('admin.admin_master')
@section('admin')
<div class="py-12">

    <div class="container">
        <div class="row">
            {{-- tabel dimasukkan ke card, agar tidak penuh dilayar, dengan ukuran col-md-8 --}}
            <div class="col-md-8">
                <div class="card">
                    {{-- alert berhasil store --}}
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{session('success')}}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <!-- Start kode untuk form pencarian -->
                    <form class="form" method="get" action="{{route('all.brand')}}">
                        <div class="form-group w-100 mb-3">
                            <div class="card-header">All Brand</div>
                            <br>
                            <div class="text-right">
                                <input type="text" name="search" class="form-control w-75 d-inline" id="search" placeholder="Masukkan keyword">
                                <button type="submit" class="btn btn-primary mb-1 mr-3">Cari</button>
                            </div>
                        </div>
                    </form>
                    <!-- Start kode untuk form pencarian -->
                    {{-- tabel --}}
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Brand Name</th>
                                <th scope="col">Brand Image</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach ($brands as $brand)
                            <tr>
                                {{-- penomoran yg menggunakan pagination  --}}
                                <th scope="row">{{$brands->firstItem()+$loop->index}}</th>
                                {{-- $brand->{nama field} --}}
                                <td>{{$brand->brand_name}}</td>
                                {{-- src akan mengakses ke direktori public --}}
                                <td><img src="{{asset($brand->brand_image)}}" style="height:80px; width:80px;"></td>
                                <td>
                                    {{-- jika tidak ada tanggal created_at, tampilkan teks --}}
                                    @if ($brand->created_at == NULL)
                                    <span class="text-danger">Tidak ada tanggal</span>
                                    @else
                                    {{-- {{Carbon\Carbon::parse($brand->created_at)->diffForHumans()}} --}}
                                    {{$brand->created_at->diffForHumans()}}
                                    @endif
                                </td>
                                <td>
                                    {{-- disini pakai url karena tidak ada route name --}}
                                    <a href="{{url('/brand/edit/'.$brand->id)}}" class="btn btn-info">Edit</a>
                                    <a href="{{url('/brand/delete/'.$brand->id)}}" onclick="return confirm('Kamu yakin ingin menghapus data?')" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{-- pagination --}}
                    {{$brands->links()}}
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Add Brand</div>
                    <div class="card-body">
                        {{-- form input add category --}}
                        {{-- insert data methodnya post --}}
                        {{-- csrf adalah token security untuk insert data. wajib ditambahkan di insert --}}
                        {{-- post file harus diberi enctype --}}
                        <form action="{{route('store.brand')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Brand Name</label>
                                <input type="text" name="brand_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                {{-- pesan error dari validasi input untuk "category_name" --}}
                                @error('brand_name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Brand Image</label>
                                <input type="file" name="brand_image" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                {{-- pesan error dari validasi input untuk "category_name" --}}
                                @error('brand_image')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Add Brand</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
