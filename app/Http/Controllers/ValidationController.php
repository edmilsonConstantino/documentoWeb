<?php

namespace App\Http\Controllers;

use App\Models\Permit;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function validate(Request $request)
    {
        $documentType = $request->query('document_type');
        $number       = $request->query('number');

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

        return view('validation.show', compact('permit'));
    }
}
