<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Flashcard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlashcardController extends Controller
{
    //Menampilkan form tambah/buat flashcard

    public function viewcreate(Request $request)
    {
        $categories = Category::all(); // Ambil semua kategori dari database
        return view('page.flashcard.create', ['categories' => $categories]); // Kirim variabel ke view
    }

    //
    public function create(Request $request)
    {
        // Validasi data dari request
        $request->validate([
            'title'                         => 'required',  // Validasi untuk judul flashcard
            'flashcards.*.front_content'    => 'required',
            'flashcards.*.back_content'     => 'required',
            'category_id'                   => 'required|exists:categories,id',
        ]);

        // Ambil user_id dari user yang login
        $user_id = Auth::id();

        // Pastikan user_id tidak null
        if (!$user_id) {
            return redirect()->back()->with('error', 'User tidak ditemukan. Silakan login terlebih dahulu.');
        }

        // Simpan setiap flashcard ke database
        foreach ($request->flashcards as $flashcardData) {
            Flashcard::create([
                'user_id'       => $user_id, // Ambil user_id dari Auth
                'title'         => $request->title, // Gunakan judul yang sama untuk semua flashcard
                'front_content' => $flashcardData['front_content'],
                'back_content'  => $flashcardData['back_content'],
                'category_id'   => $request->category_id,
            ]);
        }
        return redirect('/flashcard/table')->with('success', 'Flashcards berhasil disimpan!');
    }

    //
    public function getFlashcardsByTitle($title)
    {
        $flashcards = Flashcard::where('title', $title)->get();

        if ($flashcards->isNotEmpty()) {
            return response()->json($flashcards);
        } else {
            return response()->json(['error' => 'Flashcards tidak ditemukan.'], 404);
        }
    }

    //Menampilkan halaman data tabel flashcard
    public function table(Request $request)
    {
        $data = [
            'dataflashcard'     =>  Flashcard::with('category')->get()
        ];
        return view('page.flashcard.table', $data);
    }

    public function edit(Request $request, $id)
    {
        $data = [
            'dataflashcard'  => Flashcard::findOrFail($id),
            'categories'     => Category::all()
        ];
        return view('page.flashcard.edit', $data);
    }


    //menampilkan halaman edit
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'            => 'required',  // Validasi untuk judul flashcard
            'front_content'    => 'required',
            'back_content'     => 'required',
            'category_id'      => 'required|exists:categories,id',
        ]);

        // Ambil user_id dari user yang login
        $user_id = Auth::id();

        // Pastikan user_id tidak null
        if (!$user_id) {
            return redirect()->with('error', 'User tidak ditemukan. Silakan login terlebih dahulu.');
        }

        // Menyimpan flashcard
        $dataflashcard = Flashcard::findOrFail($id);
        $dataflashcard->title = $request->title;
        $dataflashcard->front_content = $request->front_content;
        $dataflashcard->back_content = $request->back_content;
        $dataflashcard->category_id = $request->category_id;
        $dataflashcard->save();

        return redirect('/flashcard/table')->with('success', 'Flashcard berhasil diperbarui.');
    }

    //Hapus data flashcard
    public function destroy($id)
    {
        $flashcard = Flashcard::findOrFail($id);
        $flashcard->delete();

        return redirect('/flashcard/table')->with('success', 'Kategori berhasil dihapus.');
    }


    //Menampilkan flashcard untuk preview
    public function index()
    {
        // Ambil flashcards dengan judul unik
        $flashcards = Flashcard::select('title')
            ->groupBy('title')
            ->get();

        // Masukkan flashcards ke dalam array data
        $data = [
            'flashcards' => $flashcards
        ];

        // Mengirim data ke view
        return view('page.flashcard.index', $data);
    }



    // Method untuk mengupdate flashcard berdasarkan ID
    public function updateFlashcard(Request $request, $id)
    {
        $flashcard = Flashcard::find($id);

        if (!$flashcard) {
            return response()->json(['error' => 'Flashcard not found'], 404);
        }

        // Update title, front_content, atau back_content jika ada di request
        if ($request->has('title')) {
            $flashcard->title = $request->input('title');
        }
        if ($request->has('front')) {
            $flashcard->front_content = $request->input('front');
        }
        if ($request->has('back')) {
            $flashcard->back_content = $request->input('back');
        }

        $flashcard->save();

        return response()->json(['success' => true, 'message' => 'Flashcard updated successfully']);
    }
}
