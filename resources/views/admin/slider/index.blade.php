@extends('admin.admin_master')
@section('admin')
<div class="py-12">

    <div class="container">
        <div class="row">
            {{-- tabel dimasukkan ke card, agar tidak penuh dilayar, dengan ukuran col-md-8 --}}
            <div class="col-md-12">
                {{-- button add --}}
                <a href=""><button class="btn btn-info">Add Slider</button></a>
                <br><br>
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

                    <div class="card-header">All Slider</div>
                    {{-- tabel --}}
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Image</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach ($sliders as $slider)
                            <tr>
                                {{-- penomoran yg menggunakan pagination  --}}
                                <th scope="row">{{$sliders->firstItem()+$loop->index}}</th>
                                {{-- $brand->{nama field} --}}
                                <td>{{$slider->title}}</td>
                                <td>{{$slider->description}}</td>
                                {{-- src akan mengakses ke direktori public --}}
                                <td><img src="{{asset($slider->image)}}" style="height:80px; width:80px;"></td>
                                <td>
                                    {{-- disini pakai url karena tidak ada route name --}}
                                    <a href="{{url('/slider/edit/'.$slider->id)}}" class="btn btn-info">Edit</a>
                                    <a href="{{url('/slider/delete/'.$slider->id)}}" onclick="return confirm('Kamu yakin ingin menghapus data?')" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
