@extends('layouts.app')

@section('title', 'Documento Inválido')

@section('content')
<div class="container py-5" style="max-width: 600px;">
    <div class="text-center mb-4">
        <i class="bi bi-building-check" style="font-size: 2.5rem; color: #0a3d62;"></i>
        <h4 class="fw-bold mt-2" style="color: #0a3d62;">
            Ministério dos Transportes e Comunicações
        </h4>
    </div>

    <div class="card text-center p-5">
        <i class="bi bi-x-circle-fill text-danger mb-3" style="font-size: 4rem;"></i>
        <h4 class="fw-bold text-danger">Documento Não Encontrado</h4>
        <p class="text-muted mt-2">{{ $message }}</p>
        <hr>
        <p class="text-muted small mb-0">
            <i class="bi bi-shield-exclamation me-1"></i>
            Se acredita que este é um erro, contacte o MTC para verificação.
        </p>
    </div>
</div>
@endsection
