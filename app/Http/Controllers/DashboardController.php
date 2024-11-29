<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Flashcard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function dashboard(Request $request)
    {
        $categoryCount = Category::count(); // Menghitung jumlah kategori
        $flashcardCount = Flashcard::count(); // Menghitung jumlah kategori
        $user = Auth::user(); // Ambil data user yang sedang login
        return view('page.dashboard', compact('user', 'categoryCount', 'flashcardCount'));
    }
}