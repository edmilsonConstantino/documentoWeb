@extends('layouts.admin')

@section('title', 'Documento #' . $permit->number)

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.permits.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0">Documento #{{ $permit->number }}</h5>
    <div class="ms-auto d-flex gap-2">
        <a href="{{ route('admin.permits.edit', $permit) }}" class="btn btn-sm btn-warning">
            <i class="bi bi-pencil me-1"></i> Editar
        </a>
    </div>
</div>

<div class="row g-4">

    {{-- Identificação --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header fw-semibold" style="background:#0a3d62;color:#fff;border-radius:10px 10px 0 0">
                <i class="bi bi-card-text me-2"></i>Identificação
            </div>
            <div class="card-body row g-3">
                <div class="col-sm-4">
                    <div class="text-muted small">Número</div>
                    <div class="fw-semibold">#{{ $permit->number }}</div>
                </div>
                <div class="col-sm-4">
                    <div class="text-muted small">Referência</div>
                    <div class="fw-semibold">{{ $permit->reference }}</div>
                </div>
                <div class="col-sm-4">
                    <div class="text-muted small">Tipo de Documento</div>
                    <div class="fw-semibold">{{ $permit->document_type }}</div>
                </div>
                <div class="col-sm-4">
                    <div class="text-muted small">Data de Emissão</div>
                    <div class="fw-semibold">{{ $permit->issued_at->format('d/m/Y') }}</div>
                </div>
                <div class="col-sm-4">
                    <div class="text-muted small">Data de Expiração</div>
                    <div class="fw-semibold">{{ $permit->expires_at->format('d/m/Y') }}</div>
                </div>
                <div class="col-sm-4">
                    <div class="text-muted small">Estado</div>
                    @php
                        $color = $permit->status_color;
                        $badgeClass = $color === 'success' ? 'bg-success' : ($color === 'warning' ? 'bg-warning text-dark' : 'bg-danger');
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $permit->status_label }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Operador --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header fw-semibold" style="background:#0a3d62;color:#fff;border-radius:10px 10px 0 0">
                <i class="bi bi-person-badge me-2"></i>Operador
            </div>
            <div class="card-body row g-3">
                <div class="col-sm-8">
                    <div class="text-muted small">Nome do Operador / Cliente</div>
                    <div class="fw-semibold">{{ $permit->client_name }}</div>
                </div>
                @if($permit->nuit)
                <div class="col-sm-4">
                    <div class="text-muted small">NUIT</div>
                    <div class="fw-semibold">{{ $permit->nuit }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Veículo e Carga --}}
    @if($permit->vehicle_registration || $permit->vehicle_brand || $permit->cargo_type || $permit->capacity || $permit->origin || ($permit->transit_countries && count($permit->transit_countries)))
    <div class="col-12">
        <div class="card">
            <div class="card-header fw-semibold" style="background:#0a3d62;color:#fff;border-radius:10px 10px 0 0">
                <i class="bi bi-truck me-2"></i>Veículo e Carga
            </div>
            <div class="card-body row g-3">
                @if($permit->vehicle_registration)
                <div class="col-sm-4">
                    <div class="text-muted small">Matrícula</div>
                    <div class="fw-semibold">{{ $permit->vehicle_registration }}</div>
                </div>
                @endif
                @if($permit->vehicle_brand)
                <div class="col-sm-4">
                    <div class="text-muted small">Marca</div>
                    <div class="fw-semibold">{{ $permit->vehicle_brand }}</div>
                </div>
                @endif
                @if($permit->cargo_type)
                <div class="col-sm-4">
                    <div class="text-muted small">Tipo de Carga</div>
                    <div class="fw-semibold">{{ $permit->cargo_type }}</div>
                </div>
                @endif
                @if($permit->capacity)
                <div class="col-sm-4">
                    <div class="text-muted small">Capacidade</div>
                    <div class="fw-semibold">{{ $permit->capacity }}</div>
                </div>
                @endif
                @if($permit->origin)
                <div class="col-sm-4">
                    <div class="text-muted small">Origem</div>
                    <div class="fw-semibold">{{ $permit->origin }}</div>
                </div>
                @endif
                @if($permit->transit_countries && count($permit->transit_countries))
                <div class="col-12">
                    <div class="text-muted small mb-1">Países de Trânsito</div>
                    <div class="d-flex flex-wrap gap-1">
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

    {{-- Ficheiro do Documento --}}
    @if($permit->document_file)
    @php
        $isPdf = str_ends_with(strtolower($permit->document_original_name ?? ''), '.pdf');
        $fileUrl = route('validation.file', $permit);
    @endphp
    <div class="col-12">
        <div class="card">
            <div class="card-header fw-semibold d-flex align-items-center justify-content-between" style="background:#0a3d62;color:#fff;border-radius:10px 10px 0 0">
                <span><i class="bi bi-paperclip me-2"></i>Ficheiro Oficial — {{ $permit->document_original_name }}</span>
                <a href="{{ $fileUrl }}" download="{{ $permit->document_original_name }}" class="btn btn-sm btn-light">
                    <i class="bi bi-download me-1"></i> Descarregar
                </a>
            </div>
            <div class="card-body p-0">
                @if($isPdf)
                    <iframe src="{{ $fileUrl }}" style="width:100%;height:700px;border:none;border-radius:0 0 10px 10px;"></iframe>
                @else
                    <div class="text-center p-3">
                        <img src="{{ $fileUrl }}" alt="{{ $permit->document_original_name }}" style="max-width:100%;border-radius:0 0 10px 10px;">
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
