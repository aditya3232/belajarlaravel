@extends('admin.admin_master')
@section('admin')
<div class="py-12">

    <div class="container">
        <div class="row">
            {{-- tabel dimasukkan ke card, agar tidak penuh dilayar, dengan ukuran col-md-8 --}}
            <div class="col-md-12">
                <h4>Home About</h4>
                <br>
                {{-- button add --}}
                <a href="{{route('add.about')}}"><button class="btn btn-info">Add About</button></a>
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

                    <div class="card-header">All About</div>
                    {{-- tabel --}}
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">No</th>
                                <th scope="col" width="10%">Title</th>
                                <th scope="col" width="15%">Short Description</th>
                                <th scope="col" width="25%">Long Description</th>
                                <th scope="col" width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach ($homeabout as $about)
                            <tr>
                                <th scope="row">{{$i++}}</th>
                                {{-- $brand->{nama field} --}}
                                <td>{{$about->title}}</td>
                                <td>{{$about->short_dis}}</td>
                                <td>{{$about->long_dis}}</td>
                                <td>
                                    {{-- disini pakai url karena tidak ada route name --}}
                                    <a href="{{url('/about/edit/'.$about->id)}}" class="btn btn-info">Edit</a>
                                    <a href="{{url('/about/delete/'.$about->id)}}" onclick="return confirm('Kamu yakin ingin menghapus data?')" class="btn btn-danger">Delete</a>
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
