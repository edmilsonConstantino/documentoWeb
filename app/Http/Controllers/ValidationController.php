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

        // Se tiver ficheiro, renderiza com PDF.js (canvas) — extensão do browser não intercepta
        if ($permit->document_file && Storage::disk('public')->exists($permit->document_file)) {
            $path  = storage_path('app/public/' . $permit->document_file);
            $mime  = mime_content_type($path);
            $name  = e($permit->document_original_name);
            $isPdf = str_starts_with($mime, 'application/pdf');

            if ($isPdf) {
                $b64 = base64_encode(file_get_contents($path));
                $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>{$name}</title>
<style>
  * { margin:0; padding:0; box-sizing:border-box; }
  body { background:#525659; }
  #viewer { display:flex; flex-direction:column; align-items:center; padding:20px 0; gap:12px; }
  canvas { display:block; box-shadow:0 2px 8px rgba(0,0,0,.5); }
</style>
</head>
<body>
<div id="viewer"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
  pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
  const data = atob('{$b64}');
  const bytes = new Uint8Array(data.length);
  for (let i = 0; i < data.length; i++) bytes[i] = data.charCodeAt(i);
  pdfjsLib.getDocument({ data: bytes }).promise.then(function(pdf) {
    for (let p = 1; p <= pdf.numPages; p++) {
      pdf.getPage(p).then(function(page) {
        const vp = page.getViewport({ scale: 1.5 });
        const canvas = document.createElement('canvas');
        canvas.width  = vp.width;
        canvas.height = vp.height;
        document.getElementById('viewer').appendChild(canvas);
        page.render({ canvasContext: canvas.getContext('2d'), viewport: vp });
      });
    }
  });
</script>
</body>
</html>
HTML;
            } else {
                $b64  = base64_encode(file_get_contents($path));
                $html = "<!DOCTYPE html><html><head><meta charset=\"utf-8\"><title>{$name}</title>"
                    . "<style>*{margin:0;padding:0}body{background:#525659;display:flex;justify-content:center;align-items:center;min-height:100vh}"
                    . "img{max-width:100%;max-height:100vh}</style></head>"
                    . "<body><img src=\"data:{$mime};base64,{$b64}\" alt=\"{$name}\"></body></html>";
            }

            return response($html, 200, ['Content-Type' => 'text/html']);
        }

        // Sem ficheiro — mostra os dados do documento
        return view('validation.document', compact('permit'));
    }
}
