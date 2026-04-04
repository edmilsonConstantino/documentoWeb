@extends('layouts.admin')

@section('title', 'Documentos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-file-earmark-text me-2"></i>Documentos</h5>
    <a href="{{ route('admin.permits.create') }}" class="btn btn-sm btn-warning fw-semibold">
        <i class="bi bi-plus-lg me-1"></i> Novo Documento
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th class="ps-4">#</th>
                    <th>Referência</th>
                    <th>Tipo</th>
                    <th>Operador</th>
                    <th>Validade</th>
                    <th>Estado</th>
                    <th class="text-end pe-4">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permits as $permit)
                @php
                    $sc = $permit->status_color === 'success' ? 'valid' : ($permit->status_color === 'warning' ? 'expired' : 'cancelled');
                @endphp
                <tr>
                    <td class="ps-4 fw-semibold">{{ $permit->number }}</td>
                    <td class="text-muted small">{{ $permit->reference }}</td>
                    <td>{{ $permit->document_type }}</td>
                    <td>{{ $permit->client_name }}</td>
                    <td class="small">
                        {{ $permit->issued_at->format('d/m/Y') }} →
                        {{ $permit->expires_at->format('d/m/Y') }}
                    </td>
                    <td>
                        <span class="badge badge-{{ $sc }}">{{ $permit->status_label }}</span>
                    </td>
                    <td class="text-end pe-4">
                        {{-- Link de validação --}}
                        @php
                            $validationUrl = route('validation.validate', [
                                '_token'        => csrf_token(),
                                'document_type' => $permit->document_type,
                                'number'        => $permit->number,
                            ]);
                        @endphp
                        <a href="{{ $validationUrl }}" target="_blank"
                           class="btn btn-sm btn-outline-primary me-1" title="Ver validação">
                            <i class="bi bi-eye"></i>
                        </a>
                        <button class="btn btn-sm btn-outline-secondary me-1"
                                onclick="copyLink('{{ $validationUrl }}')" title="Copiar link">
                            <i class="bi bi-link-45deg"></i>
                        </button>
                        <a href="{{ route('admin.permits.edit', $permit) }}"
                           class="btn btn-sm btn-outline-warning me-1" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.permits.destroy', $permit) }}" method="POST"
                              class="d-inline" onsubmit="return confirm('Remover este documento?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Remover">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        Nenhum documento cadastrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 d-flex justify-content-end">
    {{ $permits->links() }}
</div>
@endsection

@push('scripts')
<script>
function copyLink(url) {
    navigator.clipboard.writeText(url).then(() => {
        alert('Link de validação copiado!');
    });
}
</script>
@endpush
