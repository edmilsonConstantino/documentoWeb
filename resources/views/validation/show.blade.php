@extends('layouts.app')
@php use Illuminate\Support\Facades\Storage; @endphp

@section('title', 'Validação de Documento #' . $permit->number)

@section('content')
<div class="container py-5" style="max-width: 750px;">

    {{-- Cabeçalho --}}
    <div class="text-center mb-4">
        <div class="mb-2">
            <i class="bi bi-building-check" style="font-size: 2.5rem; color: #0a3d62;"></i>
        </div>
        <h4 class="fw-bold" style="color: #0a3d62;">
            Ministério dos Transportes e Comunicações
        </h4>
        <p class="text-muted mb-0">Validação de Documento Oficial</p>
    </div>

    {{-- Status --}}
    @php
        $statusClass = $permit->status_color === 'success' ? 'valid' : ($permit->status_color === 'warning' ? 'expired' : 'cancelled');
        $icon = $statusClass === 'valid' ? 'bi-patch-check-fill' : ($statusClass === 'expired' ? 'bi-exclamation-triangle-fill' : 'bi-x-circle-fill');
    @endphp
    <div class="status-bar {{ $statusClass }} mb-4 d-flex align-items-center gap-3">
        <i class="bi {{ $icon }}" style="font-size: 2rem;"></i>
        <div>
            <div class="fw-bold fs-5">{{ $permit->status_label }}</div>
            <div class="text-muted small">
                Válido de {{ $permit->issued_at->format('d/m/Y') }}
                até {{ $permit->expires_at->format('d/m/Y') }}
            </div>
        </div>
    </div>

    {{-- Detalhes do Documento --}}
    <div class="card mb-4">
        <div class="card-header fw-semibold" style="background: #0a3d62; color: #fff; border-radius: 10px 10px 0 0;">
            <i class="bi bi-file-earmark-text me-2"></i>Detalhes do Documento
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-sm-6">
                    <label class="text-muted small">Tipo de Documento</label>
                    <div class="fw-semibold">{{ $permit->document_type }}</div>
                </div>
                <div class="col-sm-6">
                    <label class="text-muted small">Número</label>
                    <div class="fw-semibold">#{{ $permit->number }}</div>
                </div>
                <div class="col-sm-6">
                    <label class="text-muted small">Referência</label>
                    <div class="fw-semibold">{{ $permit->reference }}</div>
                </div>
                <div class="col-sm-6">
                    <label class="text-muted small">Estado</label>
                    <div>
                        <span class="badge badge-{{ $statusClass }}">{{ $permit->status_label }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Operador --}}
    <div class="card mb-4">
        <div class="card-header fw-semibold" style="background: #0a3d62; color: #fff; border-radius: 10px 10px 0 0;">
            <i class="bi bi-person-badge me-2"></i>Informação do Operador
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-sm-8">
                    <label class="text-muted small">Operador / Cliente</label>
                    <div class="fw-semibold">{{ $permit->client_name }}</div>
                </div>
                @if($permit->nuit)
                <div class="col-sm-4">
                    <label class="text-muted small">NUIT</label>
                    <div class="fw-semibold">{{ $permit->nuit }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Veículo --}}
    @if($permit->vehicle_registration || $permit->vehicle_brand)
    <div class="card mb-4">
        <div class="card-header fw-semibold" style="background: #0a3d62; color: #fff; border-radius: 10px 10px 0 0;">
            <i class="bi bi-truck me-2"></i>Informação do Veículo
        </div>
        <div class="card-body">
            <div class="row g-3">
                @if($permit->vehicle_registration)
                <div class="col-sm-6">
                    <label class="text-muted small">Matrícula</label>
                    <div class="fw-semibold">{{ $permit->vehicle_registration }}</div>
                </div>
                @endif
                @if($permit->vehicle_brand)
                <div class="col-sm-6">
                    <label class="text-muted small">Marca</label>
                    <div class="fw-semibold">{{ $permit->vehicle_brand }}</div>
                </div>
                @endif
                @if($permit->cargo_type)
                <div class="col-sm-6">
                    <label class="text-muted small">Tipo de Carga</label>
                    <div class="fw-semibold">{{ $permit->cargo_type }}</div>
                </div>
                @endif
                @if($permit->capacity)
                <div class="col-sm-6">
                    <label class="text-muted small">Capacidade</label>
                    <div class="fw-semibold">{{ $permit->capacity }}</div>
                </div>
                @endif
                @if($permit->origin)
                <div class="col-sm-6">
                    <label class="text-muted small">Origem</label>
                    <div class="fw-semibold">{{ $permit->origin }}</div>
                </div>
                @endif
                @if($permit->transit_countries && count($permit->transit_countries))
                <div class="col-12">
                    <label class="text-muted small">Países de Trânsito</label>
                    <div class="d-flex flex-wrap gap-1 mt-1">
                        @foreach($permit->transit_countries as $country)
                            <span class="badge bg-secondary">{{ $country }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- Botão de download do ficheiro --}}
    @if($permit->document_file)
    @php
        $isPdf = str_ends_with(strtolower($permit->document_original_name ?? ''), '.pdf');
    @endphp
    <div class="card mb-4">
        <div class="card-header fw-semibold" style="background: #0a3d62; color: #fff; border-radius: 10px 10px 0 0;">
            <i class="bi bi-paperclip me-2"></i>Ficheiro Oficial
        </div>
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <i class="bi {{ $isPdf ? 'bi-file-earmark-pdf text-danger' : 'bi-file-earmark-image text-primary' }}" style="font-size: 2rem;"></i>
                <div>
                    <div class="fw-semibold">{{ $permit->document_original_name }}</div>
                    <div class="text-muted small">Documento oficial anexado</div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ Storage::url($permit->document_file) }}" target="_blank"
                   class="btn btn-outline-primary">
                    <i class="bi bi-eye me-1"></i> Visualizar
                </a>
                <a href="{{ Storage::url($permit->document_file) }}" download="{{ $permit->document_original_name }}"
                   class="btn btn-primary">
                    <i class="bi bi-download me-1"></i> Descarregar
                </a>
            </div>
        </div>
    </div>
    @endif

    <div class="text-center text-muted small mt-4">
        <i class="bi bi-shield-lock me-1"></i>
        Documento verificado pelo sistema Balcão Virtual · MTC Moçambique
    </div>
</div>
@endsection
