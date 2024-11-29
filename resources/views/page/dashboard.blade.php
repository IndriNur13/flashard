@extends('layout.master')
@section('content')

<div class="col-12 col-xl-8 mb-4 mb-xl-0">
    <h3 class="font-weight-bold">Good to see you, {{$user->name}}! Let’s get started.</h3>
    <h6 class="font-weight-normal mb-0">Everything’s set up for you—have fun exploring!</h6>
</div>
<div class="row mt-4">
    <div class="col-md-6 mb-4 stretch-card transparent">
        <div class="card card-tale">
            <div class="card-body text-center">
                <p class="mb-4">Total Category</p>
                <p class="fs-30 mb-2">{{ $categoryCount }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4 stretch-card transparent">
        <div class="card card-dark-blue">
            <div class="card-body text-center">
            <p class="mb-4">Total Flashcards</p>
            <p class="fs-30 mb-2">{{ $flashcardCount }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Panduan Penggunaan Aplikasi Flashcards</h4>
                <p class="card-description">
                    Berikut adalah langkah-langkah dasar untuk menggunakan aplikasi Flashcards:
                    <ul>
                        <li><strong>Login atau Daftar:</strong> Akses aplikasi dengan akun yang sudah ada atau buat akun baru.</li>
                        <li><strong>Membuat Flashcard:</strong> Buat flashcard baru dengan memasukkan judul, konten depan, dan belakang.</li>
                        <li><strong>Melihat Daftar Flashcards:</strong> Lihat koleksi flashcards yang sudah dibuat.</li>
                        <li><strong>Mengedit Flashcard:</strong> Edit flashcard yang sudah dibuat.</li>
                        <li><strong>Menghapus Flashcard:</strong> Hapus flashcard yang tidak diperlukan.</li>
                        <li><strong>Memulai Kuis:</strong> Gunakan flashcards untuk membuat kuis dan uji pemahaman Anda.</li>
                        <li><strong>Melihat Hasil Kuis:</strong> Lihat skor setelah menyelesaikan kuis.</li>
                        <li><strong>Logout:</strong> Keluar dari aplikasi ketika selesai menggunakan.</li>
                    </ul>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tips Belajar</h4>
                <p class="card-description">
                    <ul>
                        <li><strong>Belajar Lebih Efektif dengan Kategori!</strong><br>
                            Mengelompokkan flashcards berdasarkan kategori (misalnya, Matematika, Sejarah, dll.) akan membantu Anda fokus pada topik tertentu dan mengingat informasi lebih mudah.
                        </li>
                        <li><strong>Gunakan Kuis untuk Menguji Pemahaman Anda</strong><br>
                            Setelah membuat flashcards, gunakan fitur Kuis untuk menguji seberapa baik Anda mengingat materi. Kuis memberi tantangan dan membantu memperkuat ingatan Anda.
                        </li>
                        <li><strong>Cobalah Belajar Secara Teratur</strong><br>
                            Konsistensi adalah kunci! Belajar sedikit setiap hari lebih efektif daripada belajar banyak sekaligus. Gunakan flashcards secara rutin untuk memperkuat memori Anda.
                        </li>
                        <li><strong>Gunakan Fitur Acak untuk Variasi</strong><br>
                            Fitur Acak memungkinkan Anda mempelajari flashcards dalam urutan yang berbeda setiap kali, membantu Anda mengingat informasi tanpa mengandalkan urutan tertentu.
                        </li>
                        <li><strong>Ulangi Setelah Beberapa Waktu</strong><br>
                            Mengulang flashcards pada interval waktu yang lebih panjang membantu memperkuat ingatan jangka panjang Anda. Cobalah meninjau kembali flashcards setelah beberapa hari atau minggu.
                        </li>
                    </ul>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
