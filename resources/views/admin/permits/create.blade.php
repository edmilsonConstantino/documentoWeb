@extends('layouts.admin')

@section('title', 'Novo Documento')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.permits.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0">Novo Documento</h5>
</div>

<form action="{{ route('admin.permits.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
    @csrf

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card">
        <div class="card-body text-center py-5">
            <input type="file" name="document_file" id="document_file"
                   accept=".pdf,.jpg,.jpeg,.png"
                   class="d-none @error('document_file') is-invalid @enderror"
                   required>

            <div id="dropArea" onclick="document.getElementById('document_file').click()"
                 style="border: 2px dashed #0a3d62; border-radius: 12px; padding: 60px 40px; cursor: pointer; transition: background .2s;">
                <i class="bi bi-cloud-arrow-up" style="font-size: 3rem; color: #0a3d62;"></i>
                <div class="fw-semibold mt-3" style="color: #0a3d62; font-size: 1.1rem;">
                    Clique para escolher o ficheiro
                </div>
                <div class="text-muted small mt-1">PDF, JPG, PNG — máx. 10MB</div>
            </div>

            <div id="fileInfo" class="mt-3 d-none">
                <i class="bi bi-file-earmark-check text-success" style="font-size: 2rem;"></i>
                <div class="fw-semibold mt-1" id="fileName"></div>
                <button type="submit" class="btn btn-warning fw-semibold px-5 mt-3">
                    <i class="bi bi-save me-1"></i> Guardar Documento
                </button>
            </div>

            @error('document_file')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>
    </div>
</form>

<script>
document.getElementById('document_file').addEventListener('change', function () {
    if (this.files.length > 0) {
        document.getElementById('fileName').textContent = this.files[0].name;
        document.getElementById('fileInfo').classList.remove('d-none');
        document.getElementById('dropArea').style.background = '#f0f7ff';
    }
});
</script>
@endsection
