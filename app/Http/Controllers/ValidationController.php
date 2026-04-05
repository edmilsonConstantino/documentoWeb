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

        // Se tiver ficheiro, mostra-o embutido (URL fica no domínio, sem extensão do browser)
        if ($permit->document_file && Storage::disk('public')->exists($permit->document_file)) {
            $fileUrl = route('validation.file', $permit);
            $isPdf   = str_ends_with(strtolower($permit->document_original_name ?? ''), '.pdf');
            $name    = e($permit->document_original_name);

            if ($isPdf) {
                $embed = "<embed src=\"{$fileUrl}\" type=\"application/pdf\" style=\"width:100%;height:100%;border:none;\">";
            } else {
                $embed = "<img src=\"{$fileUrl}\" alt=\"{$name}\" style=\"max-width:100%;display:block;margin:auto;\">";
            }

            return response(
                "<!DOCTYPE html><html><head><meta charset=\"utf-8\">
                <meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">
                <title>{$name}</title>
                <style>*{margin:0;padding:0;box-sizing:border-box}html,body{width:100%;height:100%;overflow:hidden;background:#525659}</style>
                </head><body>{$embed}</body></html>",
                200,
                ['Content-Type' => 'text/html']
            );
        }

        // Sem ficheiro — mostra os dados do documento
        return view('validation.document', compact('permit'));
    }
}
