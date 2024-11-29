@extends('layout.master')

@section('content')
<div class="card bg-white">
    <div class="container">
        <h2 class="m-5">Buat Set Flashcard Baru</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form id="form-flashcards" class="m-5" action="/flashcard/create" method="POST">
            @csrf
            <div id="flashcardContainer">
                <p>Judul Flashcard</p>
                <input class="form-control mb-4" type="text" name="title" placeholder="Judul Flashcard" required>
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
                        <input class="form-control" type="text" name="flashcards[0][front_content]" placeholder="Konten Depan" required>
                    </div>
                    <div class="col-md-6">
                        <p>Konten Belakang</p>
                        <input class="form-control" type="text" name="flashcards[0][back_content]" placeholder="Konten Belakang" required>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-add btn-inverse-primary float-start mb-5" onclick="tambahFlashcard()">TAMBAHKAN KARTU</button>
            <button type="submit" class="btn btn-primary float-end mb-5"> BUAT </button>
        </form>
    </div>
</div>

@push('jsfooter')
<script>
    var flashcardIndex = 1;

    // Fungsi untuk menambahkan flashcard secara dinamis di form
    function tambahFlashcard() {
        let newFlashcard = `

            <div class="row mb-5 mt-3">
                <div class="flashcard col-md-6">
                    <input class="form-control" type="text" name="flashcards[${flashcardIndex}][front_content]" placeholder="Konten Depan" required>
                </div>
                <div class="col-md-6">
                    <input class="form-control" type="text" name="flashcards[${flashcardIndex}][back_content]" placeholder="Konten Belakang" required>
                </div>
            </div>
        `;
        $('#flashcardContainer').append(newFlashcard);
        flashcardIndex++;
    }

    // Fungsi untuk menyimpan flashcards secara dinamis dengan Ajax
    function simpanFlashcards() {
        $.ajax({
            url: window.location.origin + '/flashcards/create',
            type: "POST",
            dataType: "JSON",
            data: $('#form-flashcards').serialize(),
            success: function(res){
                console.log("Flashcards berhasil disimpan");
                alert('Flashcards berhasil disimpan!');
            },
            error: function(res){
                alert("Gagal menyimpan flashcards, coba lagi.");
            }
        });
    }
</script>
@endpush
@endsection
