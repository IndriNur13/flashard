<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class QuizController extends Controller
{
    public function index()
    {
        // Fetch all flashcards, ensure there are flashcards to show
        $flashcards = Flashcard::all();

        if ($flashcards->isEmpty()) {
            return redirect('/quiz')->with('error', 'Tidak ada flashcard untuk ditampilkan.');
        }

        // Initialize session variables
        Session::put('flashcards', $flashcards->pluck('id')->toArray());
        Session::put('answered_flashcards', []);
        Session::put('correct_answers', []);

        return view('page.quiz.index', compact('flashcards'));
    }

    public function show($title)
    {
        // Decode title to handle URL encoding
        $decodedTitle = urldecode($title);
        $flashcardsWithSameTitle = Flashcard::where('title', $decodedTitle)->get();

        // Check if there are enough flashcards to generate a quiz
        if ($flashcardsWithSameTitle->count() < 2) {
            return redirect('/quiz')->with('error', 'Tidak cukup data untuk membuat quiz.');
        }

        // Randomly select a flashcard
        $flashcard = $flashcardsWithSameTitle->random();
        $correctAnswer = $flashcard->back_content;

        // Select a wrong answer randomly
        $wrongAnswer = Flashcard::where('title', $flashcard->title)
            ->where('back_content', '<>', $correctAnswer)
            ->inRandomOrder()
            ->value('back_content');

        $choices = collect([$correctAnswer, $wrongAnswer])->shuffle();

        return view('page.quiz.quiz', compact('flashcard', 'choices'));
    }

    public function answer(Request $request)
    {
        $flashcardId = $request->input('id');
        $answeredIds = Session::get('answered_flashcards', []);
        $userId = Auth::id();  // Get the logged-in user ID

        // Mark the flashcard as answered if it's not already
        if (!in_array($flashcardId, $answeredIds)) {
            $answeredIds[] = $flashcardId;
            Session::put('answered_flashcards', $answeredIds);
        }

        // Get the correct answer
        $flashcard = Flashcard::find($flashcardId);
        $correctAnswer = $flashcard ? $flashcard->back_content : null;
        $isCorrect = $correctAnswer === $request->input('answer');

        // Insert the result into the database
        DB::table('quizresults')->insert([
            'user_id' => $userId,
            'flashcard_id' => $flashcard->id,
            'is_correct' => $isCorrect ? 1 : 0,
            'attempted_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Store the correct answers in the session
        $correctAnswers = Session::get('correct_answers', []);
        if ($isCorrect) {
            $correctAnswers[] = $flashcard->id;
        }
        Session::put('correct_answers', $correctAnswers);

        // Check if the quiz is complete
        $flashcards = Session::get('flashcards', []);
        $isComplete = count($answeredIds) === count($flashcards);

        if ($isComplete) {
            // Redirect to the end quiz page
            return redirect('/quiz/end');
        } else {
            // Show the next question
            return $this->showNextQuestion();
        }
    }

    public function showNextQuestion()
    {
        $answeredIds = Session::get('answered_flashcards', []);
        $flashcards = Session::get('flashcards', []);

        // Find the next unanswered flashcard
        $nextId = collect($flashcards)->diff($answeredIds)->first();

        if (!$nextId) {
            // No more questions, redirect to the end page
            return redirect('/quiz/end');
        }

        // Show the next flashcard question
        return $this->showFlashcardById($nextId);
    }

    private function showFlashcardById($id)
    {
        $flashcard = Flashcard::find($id);
        if (!$flashcard) {
            return redirect('/quiz')->with('error', 'Soal tidak ditemukan.');
        }

        $correctAnswer = $flashcard->back_content;
        $wrongAnswer = Flashcard::where('title', $flashcard->title)
            ->where('back_content', '<>', $correctAnswer)
            ->inRandomOrder()
            ->value('back_content');

        $choices = collect([$correctAnswer, $wrongAnswer])->shuffle();

        return view('page.quiz.quiz', compact('flashcard', 'choices'));
    }

    public function endQuiz()
    {
        $correctAnswers = Session::get('correct_answers', []);
        $totalFlashcards = Session::get('flashcards', []);

        $score = count($correctAnswers);
        $total = count($totalFlashcards);
        $isAllCorrect = $score === $total;

        // Clear the session after quiz ends
        Session::forget('flashcards');
        Session::forget('answered_flashcards');
        Session::forget('correct_answers');

        // Redirect to the end page with score
        return view('page.quiz.end', compact('score', 'total', 'isAllCorrect'));
    }
}
