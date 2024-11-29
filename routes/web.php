<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FlashcardController;

//Route::get('/', function () {return view('welcome');});

//Register Form
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'registered']);

//Login Form
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/ceklogin', [AuthController::class, 'ceklogin']);

//logout
Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    //Dashboard Page
    Route::get('/dashboard', [DashboardController::class, 'dashboard']);

    //Flashcard Page
    Route::get('/flashcard', [FlashcardController::class, 'viewcreate']);
    Route::post('/flashcard/create', [FlashcardController::class, 'create']);
    Route::get('/flashcards', [FlashcardController::class, 'index']);
    Route::get('/flashcards/{title}', [FlashcardController::class, 'getFlashcardsByTitle'])->name('flashcards.byTitle');
    Route::get('/flashcards/{id}', [FlashcardController::class, 'show']);
    Route::patch('/flashcards/update/{id}', [FlashcardController::class, 'updateFlashcard']);
    Route::get('/flashcard/table', [FlashcardController::class, 'table']);
    Route::get('/flashcard/table/edit/{id}', [FlashcardController::class, 'edit']);
    Route::post('/flashcard/table/update/{id}', [FlashcardController::class, 'update']);
    Route::get('/flashcard/table/hapus/{id}', [FlashcardController::class, 'destroy']);


    //Category Page
    Route::get('/category/create', [CategoryController::class, 'viewcreate']);
    Route::post('/category/create', [CategoryController::class, 'create'])->middleware('auth');
    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/category/{categoryId}/flashcards', [CategoryController::class, 'showFlashcards']);
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit']);
    Route::post('/category/ubahcategory/{id}', [CategoryController::class, 'ubah']);
    Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy']);


    // Quiz Routes
    Route::get('/quiz', [QuizController::class, 'index']); // Halaman awal untuk memulai kuis
    Route::get('/quiz/{title}', [QuizController::class, 'show']); // Menampilkan soal berdasarkan title
    Route::get('/quiz/next', [QuizController::class, 'showNextQuestion']); // Menampilkan soal berikutnya
    Route::post('/quiz/answered', [QuizController::class, 'answer']); // Mencatat jawaban
    Route::get('/quiz/end', [QuizController::class, 'endQuiz'])->name('quiz.end');
    Route::post('/quiz/submit-answers', [QuizController::class, 'submitAnswers']); // Menyimpan jawaban benar yang dikoreksi
});
