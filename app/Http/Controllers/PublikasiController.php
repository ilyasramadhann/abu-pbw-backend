<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; // Tambahkan ini untuk tipe hint JsonResponse

class PublikasiController extends Controller
{
    /**
     * Mengambil semua publikasi.
     * GET /api/publikasi
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // Mengembalikan semua publikasi dari database
        return response()->json(Publikasi::all());
    }

    /**
     * Menyimpan publikasi baru ke database.
     * POST /api/publikasi
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Validasi data yang masuk
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'releaseDate' => 'required|date',
            'description' => 'nullable|string',
            'coverUrl' => 'nullable|url',
        ]);

        // Membuat record baru di tabel 'publikasis'
        $publikasi = Publikasi::create($validated);

        // Mengembalikan respons JSON dengan data publikasi yang baru dibuat dan status 201 Created
        return response()->json($publikasi, 201);
    }

    /**
     * Menampilkan detail satu publikasi berdasarkan ID.
     * GET /api/publikasi/{id}
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        // Mencari publikasi berdasarkan ID. Jika tidak ditemukan, akan mengembalikan null.
        $publikasi = Publikasi::find($id);

        // Jika publikasi tidak ditemukan, kembalikan respons 404 Not Found
        if (!$publikasi) {
            return response()->json(['message' => 'Publikasi tidak ditemukan'], 404);
        }

        // Mengembalikan detail publikasi dalam format JSON
        return response()->json($publikasi);
    }

    /**
     * Memperbarui data publikasi yang sudah ada.
     * PUT /api/publikasi/{id}
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // Mencari publikasi berdasarkan ID
        $publikasi = Publikasi::find($id);

        // Jika publikasi tidak ditemukan, kembalikan respons 404 Not Found
        if (!$publikasi) {
            return response()->json(['message' => 'Publikasi tidak ditemukan'], 404);
        }

        // Validasi data yang masuk untuk pembaruan. 'sometimes' berarti field tidak wajib ada
        // dalam request update, tetapi jika ada, harus memenuhi aturan validasi.
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'releaseDate' => 'sometimes|required|date',
            'description' => 'nullable|string',
            'coverUrl' => 'nullable|url',
        ]);

        // Memperbarui data publikasi dengan data yang tervalidasi
        $publikasi->update($validated);

        // Mengembalikan respons JSON dengan data publikasi yang sudah diperbarui
        return response()->json($publikasi);
    }

    /**
     * Menghapus publikasi dari database.
     * DELETE /api/publikasi/{id}
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        // Mencari publikasi berdasarkan ID
        $publikasi = Publikasi::find($id);

        // Jika publikasi tidak ditemukan, kembalikan respons 404 Not Found
        if (!$publikasi) {
            return response()->json(['message' => 'Publikasi tidak ditemukan'], 404);
        }

        // Menghapus publikasi dari database
        $publikasi->delete();

        // Mengembalikan respons sukses tanpa konten (status 200 OK)
        return response()->json(['message' => 'Publikasi berhasil dihapus']);
    }
}