<?php

namespace App\Http\Controllers;

use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserFileController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'file' => 'required|mimes:pdf|max:10240',
        ]);

        $file = $request->file('file');
        $path = $file->storePublicly('user_files');

        $userFile = UserFile::create([
            'user_id' => $request->user_id,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    public function show(UserFile $userFile)
    {
        return response()->json($userFile);
    }

    public function preview($id)
    {
        $userFile = UserFile::findOrFail($id);

        // Vérifier si le fichier est un PDF
        if (pathinfo($userFile->file_path, PATHINFO_EXTENSION) !== 'pdf') {
            abort(404, 'Aperçu non disponible');
        }

        $filePath = storage_path('app/' . $userFile->file_path);

        // Retourner la réponse pour afficher le PDF
        return response()->file($filePath);
    }
    public function update(Request $request, UserFile $userFile)
    {
        $request->validate([
            'file' => 'mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('file')) {
            Storage::delete($userFile->file_path);

            $file = $request->file('file');
            $path = $file->store('user_files');

            $userFile->update([
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'updated_by' => auth()->id(),
            ]);
        }

        return response()->json($userFile);
    }

    public function destroy(UserFile $userFile)
    {
        Storage::delete($userFile->file_path);
        $userFile->delete();

        return response()->json(null, 204);
    }

    public function download(UserFile $userFile)
    {
        return Storage::download($userFile->file_path, $userFile->file_name);
    }
}
