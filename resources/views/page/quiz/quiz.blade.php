@extends('layout.master')

@section('content')
<div class="card">
    <div class="container mt-3">
        <h3 class="text-center mt-5">{{ $flashcard->front_content }}</h3>
        <p class="text-center mb-5">Choose the correct answer:</p>

        <div id="notification" class="text-center mb-3"></div>

        <form action="/quiz/answered" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $flashcard->id }}">

            <div class="row text-center">
                @foreach ($choices as $choice)
                    <div class="col-6 mb-3">
                        <label>
                            <input type="radio" name="answer" value="{{ $choice }}"> {{ $choice }}
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <p id="feedback" class="text-muted mb-2"></p>
                <a href="#" id="dontKnowButton" class="text-muted">Don't know?</a>
                <br>
                <button type="submit" class="btn btn-primary mt-3 mb-5 d-grid gap-2 col-6 mx-auto">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('jsfooter')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const feedback = document.getElementById('feedback');
        const dontKnowButton = document.getElementById('dontKnowButton');

        document.querySelectorAll('input[name="answer"]').forEach(choice => {
            choice.addEventListener('change', function() {
                const selectedAnswer = this.value;
                const correctAnswer = "{{ $flashcard->back_content }}";

                if (selectedAnswer === correctAnswer) {
                    feedback.innerText = 'Correct!';
                    feedback.style.color = 'green';
                } else {
                    feedback.innerText = `Incorrect! The correct answer is: ${correctAnswer}`;
                    feedback.style.color = 'red';
                }

                // Show correct answer highlight
                document.querySelectorAll('input[name="answer"]').forEach(input => {
                    if (input.value === correctAnswer) {
                        input.parentNode.style.color = 'green';
                    } else {
                        input.parentNode.style.color = 'red';
                    }
                });
            });
        });

        dontKnowButton.addEventListener('click', function(event) {
            event.preventDefault();
            const correctAnswer = "{{ $flashcard->back_content }}";
            feedback.innerText = `The correct answer is: ${correctAnswer}`;
            feedback.style.color = 'blue';
        });
    });

    // Tambahkan fungsi fetchAnswerAndMoveNext di sini
    function fetchAnswerAndMoveNext(id) {
        fetch('/quiz/answered', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ id: id })
        }).then(response => response.json())
        .then(data => {
            if (data.isComplete) {
                // Jika kuis sudah selesai, alihkan ke halaman end
                window.location.href = '/quiz/end';
            } else {
                // Pindah ke pertanyaan berikutnya
                window.location.href = '/quiz/next';
            }
        });
    }
</script>
@endpush

