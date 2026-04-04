@extends('layouts.admin')

@section('title', 'Novo Documento')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.permits.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0">Novo Documento</h5>
</div>

<form action="{{ route('admin.permits.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.permits._form')
    <div class="mt-3">
        <button type="submit" class="btn btn-warning fw-semibold px-4">
            <i class="bi bi-save me-1"></i> Guardar Documento
        </button>
    </div>
</form>
@endsection
