<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    //Membuat Category
    public function create(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255'
        ]);


        // Ambil user_id dari user yang login
        $user_id = Auth::id();

        // Pastikan user_id tidak null
        if (!$user_id) {
            return redirect()->with('error', 'User tidak ditemukan. Silakan login terlebih dahulu.');
        }

        // Menyimpan kategori
        $dataStore  = [
            'user_id'       => $user_id,
            'category_name' => $request->category_name
        ];
        Category::create($dataStore);
        return redirect('/category')->with('success', 'Kategori berhasil dibuat!');
    }

    public function index(Request $request)
    {
        $data = [
            'categories'      => Category::all()
        ];
        return view('page.category.index', $data);
    }

    // Function untuk mengambil flashcards berdasarkan kategori yang diklik
    public function showFlashcards($categoryId)
    {
        // Ambil kategori berdasarkan ID, beserta flashcards yang terkait
        $category = Category::with('flashcards')->find($categoryId);

        // Kirim data flashcards ke view
        return response()->json($category->flashcards);
    }

    //fungsi untuk menampilkan form edit
    public function edit(Request $request, $id)
    {
        $data = [
            'datacategory'  => Category::findOrFail($id)
        ];
        return view('page.category.edit', $data);
    }

    //fungsi untuk menyampaikan perubahan kategori
    public function ubah(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255'
        ]);

        // Ambil user_id dari user yang login
        $user_id = Auth::id();

        // Pastikan user_id tidak null
        if (!$user_id) {
            return redirect()->with('error', 'User tidak ditemukan. Silakan login terlebih dahulu.');
        }

        // Menyimpan kategori
        $category = Category::findOrFail($id);
        $category->category_name = $request->category_name;
        $category->save();

        return redirect('/category')->with('success', 'Kategori berhasil diperbarui.');
    }

    // Fungsi untuk menghapus kategori
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect('/category')->with('success', 'Kategori berhasil dihapus.');
    }
}