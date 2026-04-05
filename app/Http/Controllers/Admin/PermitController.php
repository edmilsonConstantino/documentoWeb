<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PermitController extends Controller
{
    public function index()
    {
        $permits = Permit::latest()->paginate(15);
        return view('admin.permits.index', compact('permits'));
    }

    public function create()
    {
        return view('admin.permits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $file = $request->file('document_file');

        Permit::create([
            'number'                 => strtoupper(Str::random(10)),
            'reference'              => 'REF-' . strtoupper(Str::random(8)),
            'document_type'          => 'Permit',
            'client_name'            => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'issued_at'              => now(),
            'expires_at'             => now()->addYear(),
            'status'                 => 'valid',
            'validation_token'       => Str::random(40),
            'document_file'          => $file->store('permits', 'public'),
            'document_original_name' => $file->getClientOriginalName(),
        ]);

        return redirect()->route('admin.permits.index')
            ->with('success', 'Documento carregado com sucesso!');
    }

    public function show(Permit $permit)
    {
        return view('admin.permits.show', compact('permit'));
    }

    public function edit(Permit $permit)
    {
        return view('admin.permits.edit', compact('permit'));
    }

    public function update(Request $request, Permit $permit)
    {
        $data = $request->validate([
            'number'               => 'required|unique:permits,number,' . $permit->id,
            'reference'            => 'required|unique:permits,reference,' . $permit->id,
            'document_type'        => 'required',
            'client_name'          => 'required',
            'nuit'                 => 'nullable',
            'vehicle_registration' => 'nullable',
            'vehicle_brand'        => 'nullable',
            'cargo_type'           => 'nullable',
            'capacity'             => 'nullable',
            'origin'               => 'nullable',
            'transit_countries'    => 'nullable|array',
            'issued_at'            => 'required|date',
            'expires_at'           => 'required|date|after:issued_at',
            'status'               => 'required|in:valid,expired,cancelled',
            'document_file'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('document_file')) {
            // Remove o ficheiro antigo se existir
            if ($permit->document_file) {
                Storage::disk('public')->delete($permit->document_file);
            }
            $file = $request->file('document_file');
            $data['document_file'] = $file->store('permits', 'public');
            $data['document_original_name'] = $file->getClientOriginalName();
        }

        $permit->update($data);

        return redirect()->route('admin.permits.index')
            ->with('success', 'Documento atualizado com sucesso!');
    }

    public function destroy(Permit $permit)
    {
        $permit->delete();
        return redirect()->route('admin.permits.index')
            ->with('success', 'Documento removido.');
    }
}
