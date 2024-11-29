@extends('layout.master')

@section('content')
<div class="card bg-white">
    <div class="container">
        <h2 class="m-5">Buat Set Flashcard Baru</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form id="form-flashcards" class="m-5" action="/flashcard/table/update/{{$dataflashcard->id}}" method="POST">
            @csrf
            <div id="flashcardContainer">
                <p>Judul Flashcard</p>
                <input class="form-control mb-4" type="text" name="title" placeholder="Judul Flashcard" value="{{$dataflashcard->title}}" required>
                <!-- Dropdown untuk memilih kategori -->
                <div class="form-group input-group-sm mb-5">
                    <label for="category_id">Pilih Kategori</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row mb-5">
                    <div class="flashcard col-md-6">
                        <p>Konten Depan</p>
                        <input class="form-control" type="text" name="front_content" placeholder="Konten Depan" value="{{$dataflashcard->front_content}}" required>
                    </div>
                    <div class="col-md-6">
                        <p>Konten Belakang</p>
                        <input class="form-control" type="text" name="back_content" placeholder="Konten Belakang" value="{{$dataflashcard->back_content}}" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary float-end mb-5"> Edit </button>
        </form>
    </div>
</div>
@endsection
