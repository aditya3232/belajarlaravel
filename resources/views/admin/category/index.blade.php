<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Category <b></b>
        </h2>
    </x-slot>

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

                        <div class="card-header">All Category</div>
                        {{-- tabel --}}
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i=1)
                                @foreach ($categories as $category)
                                <tr>
                                    {{-- penomoran yg menggunakan pagination  --}}
                                    <th scope="row">{{$categories->firstItem()+$loop->index}}</th>
                                    {{-- $category->{nama field} --}}
                                    <td>{{$category->category_name}}</td>
                                    {{-- memanggil data name dari fungsi eloquent one to one dimodel category --}}
                                    <td>{{$category->user->name}}</td>
                                    <td>{{$category->created_at->diffForHumans()}}</td>
                                    <td>
                                        {{-- disini pakai url karena tidak ada route name --}}
                                        <a href="{{url('/category/edit/'.$category->id)}}" class="btn btn-info">Edit</a>
                                        <a href="{{url('/softdelete/category/'.$category->id)}}" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{-- pagination --}}
                        {{$categories->links()}}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Add Category</div>
                        <div class="card-body">
                            {{-- form input add category --}}
                            {{-- insert data methodnya post --}}
                            {{-- csrf adalah token security untuk insert data. wajib ditambahkan di insert --}}
                            <form action="{{route('store.category')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Category Name</label>
                                    <input type="text" name="category_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    {{-- pesan error dari validasi input untuk "category_name" --}}
                                    @error('category_name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Add Category</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        {{-- tabel soft delete --}}
        <div class="container">
            <div class="row">
                {{-- tabel dimasukkan ke card, agar tidak penuh dilayar, dengan ukuran col-md-8 --}}
                <div class="col-md-8">
                    <div class="card">

                        <div class="card-header">Trash List</div>
                        {{-- tabel --}}
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i=1)
                                @foreach ($trashCat as $category)
                                <tr>
                                    {{-- penomoran yg menggunakan pagination  --}}
                                    <th scope="row">{{$trashCat->firstItem()+$loop->index}}</th>
                                    {{-- $category->{nama field} --}}
                                    <td>{{$category->category_name}}</td>
                                    {{-- memanggil data name dari fungsi eloquent one to one dimodel category --}}
                                    <td>{{$category->user->name}}</td>
                                    <td>{{$category->created_at->diffForHumans()}}</td>
                                    <td>
                                        {{-- disini pakai url karena tidak ada route name --}}
                                        <a href="{{url('/category/restore/'.$category->id)}}" class="btn btn-info">Restore</a>
                                        {{-- penulisan url yg baru hmmm --}}
                                        <a href="{{url('/pdelete/category/'.$category->id)}}" class="btn btn-danger">P. Delete</a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{-- pagination --}}
                        {{$trashCat->links()}}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">

                    </div>
                </div>

            </div>

        </div>
        {{-- end tabel soft delete  --}}
    </div>
</x-app-layout>
