@extends('layout.master')

@section('content')

<div class="card bg-white">
    <div class="container m-4">
        <h2 class="mb-4">Buat Kategori Baru</h2>

        @if (session('success'))
            <div class="alert alert-success me-5">{{ session('success') }}</div>
        @endif

        <form action="/category/create" method="POST">
            @csrf
            <div class="form-group me-5">
                <label for="category_name">Nama Kategori</label>
                <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Nama Kategori" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Tambah Kategori</button>
        </form>
    </div>
</div>

<div class="card mt-3">
    <div class="container">
    <h2 class="m-4">Daftar Kategori</h2>
    <div class="row mb-4">
        @foreach ($categories as $category)
            <div class="col-md-4" id="category-list">
                <div class="card m-3 shadow p-3">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $category->category_name }}</h3>
                        <button class="btn btn-primary btn-sm mdi mdi-eye text-white category-link" href="#" data-id="{{ $category->id }}"></button>
                        <a href="/category/edit/{{$category->id}}" class="btn btn-warning btn-sm mdi mdi-pencil text-white"></a>
                        <form action="/category/delete/{{ $category->id }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mdi mdi-delete text-white"></button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
        <!-- Tempat menampilkan flashcards -->
        <div id="flashcards-list"></div>
    </div>
</div>

@push('jsfooter')
    <script>
        document.querySelectorAll('.category-link').forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault(); // Mencegah link membuka halaman baru

                var categoryId = this.getAttribute('data-id');

                // Request AJAX ke server untuk mendapatkan flashcards berdasarkan kategori yang dipilih
                fetch('/category/' + categoryId + '/flashcards')
                    .then(response => response.json())
                    .then(flashcards => {
                        var flashcardsList = document.getElementById('flashcards-list');
                        flashcardsList.innerHTML = ''; // Kosongkan konten sebelumnya

                        if (flashcards.length > 0) {
                            let uniqueFlashcards = {};

                            // Buat objek dengan judul flashcards sebagai kunci
                            flashcards.forEach(function (flashcard) {
                                if (!uniqueFlashcards[flashcard.title]) {
                                    uniqueFlashcards[flashcard.title] = 1;
                                } else {
                                    uniqueFlashcards[flashcard.title]++;
                                }
                            });

                            // Tampilkan hanya satu judul, dan beri informasi jika ada banyak data
                            Object.keys(uniqueFlashcards).forEach(function (title) {
                                let count = uniqueFlashcards[title];
                                flashcardsList.innerHTML += `
                                    <div class="flashcard-item">
                                        <div class="card bg-primary text-white shadow p-4 m-1 mb-3">
                                            <h4> ${title}</h4>
                                            <p>${count > 1 ? 'Ada ' + count + ' flashcards dengan judul ini.' : 'Satu flashcard tersedia.'}</p>
                                        </div>
                                    </div>`;
                            });
                        } else {
                            flashcardsList.innerHTML = '<p>Tidak ada flashcards di kategori ini.</p>';
                        }
                    });
            });
        });
    </script>
@endpush

@endsection
