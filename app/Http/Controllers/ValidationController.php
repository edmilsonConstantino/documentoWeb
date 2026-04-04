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

        $path = Storage::disk('public')->path($permit->document_file);
        $mime = mime_content_type($path);

        return response()->file($path, [
            'Content-Type'        => $mime,
            'Content-Disposition' => 'inline; filename="' . $permit->document_original_name . '"',
        ]);
    }

    public function validateDocument(Request $request)
    {
        $documentType = $request->query('document_type');
        $number       = $request->query('number');
        $token        = $request->query('_token');

        if (!$documentType || !$number) {
            return view('validation.invalid', [
                'message' => 'Link de validação incompleto. Parâmetros em falta.',
            ]);
        }

        $permit = Permit::where('document_type', $documentType)
            ->where('number', $number)
            ->first();

        if (!$permit) {
            return view('validation.invalid', [
                'message' => 'Documento não encontrado. Verifique o tipo e o número do documento.',
            ]);
        }

        // Se o token estiver presente e for válido, serve o ficheiro directamente
        if ($token && $token === $permit->validation_token) {
            if (!$permit->document_file || !Storage::disk('public')->exists($permit->document_file)) {
                abort(404, 'Ficheiro não encontrado.');
            }

            $path = Storage::disk('public')->path($permit->document_file);
            $mime = mime_content_type($path);

            return response()->file($path, [
                'Content-Type'        => $mime,
                'Content-Disposition' => 'inline; filename="' . $permit->document_original_name . '"',
            ]);
        }

        return view('validation.show', compact('permit'));
    }
}
