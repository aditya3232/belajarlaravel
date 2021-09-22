<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Multi Picture<b></b>
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="container">
            <div class="row">
                {{-- tabel dimasukkan ke card, agar tidak penuh dilayar, dengan ukuran col-md-8 --}}
                <div class="col-md-8">
                    <div class="card-group">
                        @foreach ($images as $multi)
                        <div class="col-md-4 mt-5">
                            <div class="card">
                                <img src="{{asset($multi->image)}}" alt="">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Add Image</div>
                        <div class="card-body">
                            {{-- form input add category --}}
                            {{-- insert data methodnya post --}}
                            {{-- csrf adalah token security untuk insert data. wajib ditambahkan di insert --}}
                            {{-- post file harus diberi enctype --}}
                            <form action="{{route('store.image')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Brand Image</label>
                                    {{-- tambahkan multiple agar input bisa banyak --}}
                                    {{-- name disini ditambahi array untuk menampung banyak gambar --}}
                                    <input type="file" name="image[]" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" multiple="">
                                    {{-- pesan error dari validasi input untuk "category_name" --}}
                                    @error('image')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Add Image</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
