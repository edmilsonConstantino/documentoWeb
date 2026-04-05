<?php

namespace App\Http\Controllers;

use App\Models\Permit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ValidationController extends Controller
{
    public function serveFile(Permit $permit)
    {
        if (!$permit->document_file || !Storage::disk('public')->exists($permit->document_file)) {
            abort(404);
        }

        $path = storage_path('app/public/' . $permit->document_file);
        $mime = mime_content_type($path);

        return response()->file($path, [
            'Content-Type'        => $mime,
            'Content-Disposition' => "inline; filename=\"{$permit->document_original_name}\"",
        ]);
    }

    public function validateDocument(Request $request)
    {
        $documentType = $request->query('document_type');
        $number       = $request->query('number');

        if (!$documentType || !$number) {
            abort(400, 'Parâmetros em falta.');
        }

        $permit = Permit::where('document_type', $documentType)
            ->where('number', $number)
            ->first();

        if (!$permit) {
            abort(404, 'Documento não encontrado.');
        }

        return view('validation.document', compact('permit'));
    }
}
