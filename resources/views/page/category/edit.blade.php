@extends('layout.master')

@section('content')

<div class="card bg-white">
    <div class="container m-4">
        <h2 class="mb-4">Edit Kategori</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="/category/ubahcategory/{{$datacategory->id}}" method="POST">
            @csrf
            <div class="form-group me-5">
                <label for="category_name">Nama Kategori</label>
                <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Nama Kategori" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Edit Kategori</button>
        </form>
    </div>
</div>
@endsection
