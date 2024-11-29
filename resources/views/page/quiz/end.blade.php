@extends('layout.master')

@section('content')
<div class="container mt-5 text-center">
    <h3>Quiz Completed!</h3>
    <p>
        @if ($isAllCorrect)
            Congratulations! You got all answers correct!
        @else
            There were some incorrect answers. Please fill in the correct answers in the form below.
        @endif
    </p>

    @if (!$isAllCorrect)
        <form action="/quiz/submit-answers" method="POST">
            @csrf
            @foreach (session('flashcards') as $flashcard)
                <div class="mb-3">
                    <label for="answer_{{ $flashcard }}">Correct answer for Flashcard {{ $flashcard }}:</label>
                    <input type="text" class="form-control" name="answers[{{ $flashcard }}]" required>
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Submit Correct Answers</button>
        </form>
    @endif

    <a href="/quiz" class="btn btn-secondary mt-3">Back to Quiz Index</a>
</div>
@endsection
