@extends('layout.master')

@section('content')
<div class="card mt-3">
    <div class="container">
        <h2 class="mt-5 ms-4 mb-3">Daftar Flashcard</h2>
        <div class="row">
            @foreach ($flashcards->groupBy('title') as $title => $groupedFlashcards)
                <div class="col-md-4" id="flashcard-list">
                    <div class="card m-4 shadow p-3">
                        <div class="card-body text-center">
                            <h5>{{ $title }}</h5>
                            <a href="/quiz/{{ urlencode($title) }}" class="btn btn-primary">Mulai Quiz</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
