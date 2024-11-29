@extends('layout.master')

@section('content')

<div class="card mt-3">
    <div class="container">
        <h2 class="mt-5 ms-4 mb-3">Daftar Flashcard</h2>
        <div class="row">
            @foreach ($flashcards as $flashcard)
                <div class="col-md-4" id="flashcard-list">
                    <div class="card m-4 shadow p-3">
                        <div class="card-body text-center">
                            <!-- Editable Title -->
                            <input type="text" value="{{ $flashcard->title }}" id="edittable-title" class="form-control mb-2" data-id="{{ $flashcard->id }}">
                            <button class="btn btn-primary flashcard-link"
                                data-title="{{ $flashcard->title }}">
                                Lihat Flashcard
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Tempat menampilkan detail flashcards -->
        <div id="flashcard-detail" class="card shadow p-4 m-5" style="display: none;">
            <div class="d-flex justify-content-between m-5">
                <button class="btn" id="prev-button">
                    <img src="{{asset('assets/images/icon/arrowLeft.svg')}}" style="width:50px;height:50px;" alt="Previous">
                </button>

                <div class="text-center fs-2 mt-5 mb-5">
                    <div class="editable-content m-5" id="flashcard-front-content" contenteditable="true" style="border: 1px solid #ddd; padding: 10px;"></div>
                    <div class="editable-content m-5" id="flashcard-back-content" contenteditable="true" style="border: 1px solid #ddd; padding: 10px; display: none;"></div>
                </div>

                <button class="btn" id="next-button">
                    <img src="{{asset('assets/images/icon/arrowRight.svg')}}" style="width:50px;height:50px;" alt="Next">
                </button>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-outline-primary mt-5" id="flip-button">Balik Kartu</button>
                <button class="btn btn-outline-success mt-2" id="save-changes">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

@push('jsfooter')
<script>
    document.querySelectorAll('.flashcard-link').forEach(button => {
        button.addEventListener('click', function() {
            const title = this.getAttribute('data-title');

            // AJAX untuk mengambil flashcards berdasarkan judul
            fetch(`/flashcards/${title}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        const flashcards = data.filter(flashcard => flashcard.title === title).map(flashcard => ({
                            id: flashcard.id,
                            front: flashcard.front_content,
                            back: flashcard.back_content
                        }));

                        let currentIndex = 0;
                        let showingFront = true;

                        updateFlashcard();

                        document.getElementById('flip-button').onclick = function() {
                            showingFront = !showingFront;
                            updateFlashcard();
                        };

                        document.getElementById('flashcard-detail').style.display = 'block';

                        document.getElementById('next-button').onclick = function() {
                            currentIndex = (currentIndex + 1) % flashcards.length;
                            showingFront = true;
                            updateFlashcard();
                        };

                        document.getElementById('prev-button').onclick = function() {
                            currentIndex = (currentIndex - 1 + flashcards.length) % flashcards.length;
                            showingFront = true;
                            updateFlashcard();
                        };

                        function updateFlashcard() {
                            const frontContent = document.getElementById('flashcard-front-content');
                            const backContent = document.getElementById('flashcard-back-content');
                            frontContent.innerText = flashcards[currentIndex].front;
                            backContent.innerText = flashcards[currentIndex].back;
                            frontContent.style.display = showingFront ? 'block' : 'none';
                            backContent.style.display = showingFront ? 'none' : 'block';
                        }

                        // Simpan perubahan
                        document.getElementById('save-changes').onclick = function() {
                            const front = document.getElementById('flashcard-front-content').innerText;
                            const back = document.getElementById('flashcard-back-content').innerText;
                            const id = flashcards[currentIndex].id;

                            fetch(`/flashcards/update/${id}`, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    front: front,
                                    back: back
                                })
                            }).then(response => response.json())
                              .then(data => {
                                  if (data.success) {
                                      alert('Perubahan berhasil disimpan');
                                  } else {
                                      alert('Gagal menyimpan perubahan');
                                  }
                              });
                        };

                        document.querySelectorAll('.editable-title').forEach(titleInput => {
                            titleInput.addEventListener('change', function() {
                                const id = this.getAttribute('data-id');
                                const newTitle = this.value;

                                fetch(`/flashcards/update/${id}`, {
                                    method: 'PATCH',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({ title: newTitle })
                                }).then(response => response.json())
                                  .then(data => {
                                      if (data.success) {
                                          alert('Title berhasil diupdate');
                                      } else {
                                          alert('Gagal mengupdate title');
                                      }
                                  });
                            });
                        });
                    }
                });
        });
    });
</script>
@endpush

@endsection
