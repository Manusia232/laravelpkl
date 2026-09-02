<?php

namespace App\Http\Controllers;

use App\Models\ModelList;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class DiscussionController extends Controller
{
    public function index(Request $request, $id)
    {
        $modelId = (int) $id;
        $sort = $request->query('sort', 'newest');
        $isLoggedIn = Auth::check();

        // Ambil data model
        $model = ModelList::with('brand')->find($modelId);
        
        if (!$model) {
            abort(404, 'Model tidak ditemukan.');
        }

        // Ambil semua komentar untuk model ini
        $comments = Comment::with('user')
            ->where('model_id', $modelId)
            ->orderBy('created_at', 'asc')
            ->get();

        $totalComments = $comments->count();

        // Susun komentar menjadi tree
        $byParent = [];
        foreach ($comments as $comment) {
            $key = $comment->parent_id ?? 0;
            if (!isset($byParent[$key])) {
                $byParent[$key] = [];
            }
            $byParent[$key][] = $comment;
        }

        // Urutkan komentar level teratas
        if (isset($byParent[0])) {
            // Ubah ke collection untuk menggunakan sort
            $collection = collect($byParent[0]);
            
            $byParent[0] = $collection->sort(function ($a, $b) use ($sort) {
                if ($sort === 'oldest') {
                    return $a->created_at <=> $b->created_at;
                }
                return $b->created_at <=> $a->created_at;
            })->values()->all();
        }

        return view('discussion.index', compact(
            'model', 
            'comments', 
            'totalComments', 
            'byParent', 
            'sort', 
            'isLoggedIn',
            'modelId'
        ));
    }

    public function store(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|integer|exists:comments,id'
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'model_id' => $id,
            'parent_id' => $request->parent_id ?? null,
            'content' => trim($request->content)
        ]);

        $sort = $request->query('sort', 'newest');

        return redirect()->route('discussion.index', [
            'id' => $id,
            'sort' => $sort
        ])->with('success', 'Komentar berhasil ditambahkan.');
    }

    // public function report(Request $request)
    // {
    //     if (!Auth::check()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Silakan login terlebih dahulu.'
    //         ], 401);
    //     }

    //     $request->validate([
    //         'comment_id' => 'required|integer|exists:comments,id'
    //     ]);

    //     try {
    //         $response = Http::post('http://43.106.115.184:1190/api/reports', [
    //             'username_pelapor' => Auth::user()->username,
    //             'jenis_konten' => 'komentar',
    //             'id_konten' => (string) $request->comment_id
    //         ]);

    //         $result = $response->json();

    //         if ($response->successful() && isset($result['success']) && $result['success']) {
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => $result['message'] ?? 'Laporan terkirim.'
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => $result['message'] ?? 'Gagal mengirim laporan.'
    //             ], 400);
    //         }

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Tidak dapat terhubung ke server.'
    //         ], 500);
    //     }
    // }

    public function report(Request $request)
{
    \Log::info('REPORT CONTROLLER MASUK', [
        'user_id' => Auth::id(),
        'is_auth' => Auth::check(),
        'request' => $request->all()
    ]);

    if (!Auth::check()) {
        \Log::warning('REPORT: USER BELUM LOGIN');

        return response()->json([
            'success' => false,
            'message' => 'Silakan login terlebih dahulu.'
        ], 401);
    }

    $request->validate([
        'comment_id' => 'required|integer|exists:comments,id'
    ]);

    try {

        $url = 'http://43.106.115.184:1190/api/reports';

        $payload = [
            'username_pelapor' => Auth::user()->username,
            'jenis_konten' => 'komentar',
            'id_konten' => (string) $request->comment_id
        ];

        \Log::info('REPORT: MENGIRIM KE API', [
            'url' => $url,
            'payload' => $payload
        ]);

        $response = Http::timeout(10)
            ->acceptJson()
            ->post($url, $payload);

        \Log::info('REPORT: RESPONSE API', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        $result = $response->json();

        if ($response->successful() && ($result['success'] ?? false)) {

            return response()->json([
                'success' => true,
                'message' => $result['message'] ?? 'Laporan terkirim.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Gagal mengirim laporan.',
            'api_status' => $response->status(),
            'api_response' => $result
        ], 400);

    } catch (\Throwable $e) {

        \Log::error('REPORT: EXCEPTION', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Tidak dapat terhubung ke server.',
            'error' => $e->getMessage()
        ], 500);
    }
}



    // public function delete($id)
    // {
    //     $comment = Comment::with('user')->findOrFail($id);

    //     // Cek apakah user yang punya komentar atau admin
    //     if (Auth::id() !== $comment->user_id && Auth::user()->role !== 'admin') {
    //         abort(403, 'Anda tidak memiliki izin untuk menghapus komentar ini.');
    //     }

    //     $modelId = $comment->model_id;
    //     $comment->delete();

    //     return redirect()->route('discussion.index', ['id' => $modelId])
    //         ->with('success', 'Komentar berhasil dihapus.');
    // }

    public function delete($id)
    {
        $comment = Comment::with('user')->findOrFail($id);

        // Cek apakah user yang punya komentar atau admin
        if (Auth::id() !== $comment->user_id && Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk menghapus komentar ini.'
            ], 403);
        }

        $modelId = $comment->model_id;
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil dihapus.'
        ]);
    }

}