@php $editing = isset($permit); @endphp

@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row g-4">
    {{-- Identificação --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header fw-semibold" style="background:#0a3d62;color:#fff;border-radius:10px 10px 0 0">
                <i class="bi bi-card-text me-2"></i>Identificação
            </div>
            <div class="card-body row g-3">
                <div class="col-sm-4">
                    <label class="form-label">Número <span class="text-danger">*</span></label>
                    <input type="text" name="number" class="form-control @error('number') is-invalid @enderror"
                           value="{{ old('number', $permit->number ?? '') }}" required>
                    @error('number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-4">
                    <label class="form-label">Referência <span class="text-danger">*</span></label>
                    <input type="text" name="reference" class="form-control @error('reference') is-invalid @enderror"
                           value="{{ old('reference', $permit->reference ?? '') }}" required>
                    @error('reference')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-4">
                    <label class="form-label">Tipo de Documento <span class="text-danger">*</span></label>
                    <select name="document_type" class="form-select @error('document_type') is-invalid @enderror" required>
                        @foreach(['Permit','License','Certificate'] as $type)
                            <option value="{{ $type }}"
                                {{ old('document_type', $permit->document_type ?? 'Permit') === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                    @error('document_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-4">
                    <label class="form-label">Data de Emissão <span class="text-danger">*</span></label>
                    <input type="date" name="issued_at" class="form-control @error('issued_at') is-invalid @enderror"
                           value="{{ old('issued_at', isset($permit) ? $permit->issued_at->format('Y-m-d') : '') }}" required>
                    @error('issued_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-4">
                    <label class="form-label">Data de Expiração <span class="text-danger">*</span></label>
                    <input type="date" name="expires_at" class="form-control @error('expires_at') is-invalid @enderror"
                           value="{{ old('expires_at', isset($permit) ? $permit->expires_at->format('Y-m-d') : '') }}" required>
                    @error('expires_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-4">
                    <label class="form-label">Estado <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="valid"     {{ old('status', $permit->status ?? 'valid') === 'valid'     ? 'selected' : '' }}>Válido</option>
                        <option value="expired"   {{ old('status', $permit->status ?? '') === 'expired'   ? 'selected' : '' }}>Expirado</option>
                        <option value="cancelled" {{ old('status', $permit->status ?? '') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                    <label class="form-label">Nome do Operador / Cliente <span class="text-danger">*</span></label>
                    <input type="text" name="client_name" class="form-control @error('client_name') is-invalid @enderror"
                           value="{{ old('client_name', $permit->client_name ?? '') }}" required>
                    @error('client_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-4">
                    <label class="form-label">NUIT</label>
                    <input type="text" name="nuit" class="form-control"
                           value="{{ old('nuit', $permit->nuit ?? '') }}">
                </div>
            </div>
        </div>
    </div>

    {{-- Veículo --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header fw-semibold" style="background:#0a3d62;color:#fff;border-radius:10px 10px 0 0">
                <i class="bi bi-truck me-2"></i>Veículo e Carga
            </div>
            <div class="card-body row g-3">
                <div class="col-sm-4">
                    <label class="form-label">Matrícula</label>
                    <input type="text" name="vehicle_registration" class="form-control"
                           value="{{ old('vehicle_registration', $permit->vehicle_registration ?? '') }}">
                </div>
                <div class="col-sm-4">
                    <label class="form-label">Marca</label>
                    <input type="text" name="vehicle_brand" class="form-control"
                           value="{{ old('vehicle_brand', $permit->vehicle_brand ?? '') }}">
                </div>
                <div class="col-sm-4">
                    <label class="form-label">Tipo de Carga</label>
                    <input type="text" name="cargo_type" class="form-control"
                           value="{{ old('cargo_type', $permit->cargo_type ?? '') }}"
                           placeholder="ex: Mercadoria (Regular)">
                </div>
                <div class="col-sm-4">
                    <label class="form-label">Capacidade</label>
                    <input type="text" name="capacity" class="form-control"
                           value="{{ old('capacity', $permit->capacity ?? '') }}"
                           placeholder="ex: +25.001kg">
                </div>
                <div class="col-sm-4">
                    <label class="form-label">Origem</label>
                    <input type="text" name="origin" class="form-control"
                           value="{{ old('origin', $permit->origin ?? '') }}"
                           placeholder="ex: Mozambique">
                </div>
                <div class="col-12">
                    <label class="form-label">Países de Trânsito</label>
                    <div class="row g-2">
                        @php
                            $allCountries = ['Africa do Sul','Angola','Botsuana','Malawi','Namíbia','República do Congo','Suazilândia','Tanzânia','Zâmbia','Zimbabué','Lesoto','Madagáscar'];
                            $selected = old('transit_countries', isset($permit) ? ($permit->transit_countries ?? []) : []);
                        @endphp
                        @foreach($allCountries as $country)
                        <div class="col-sm-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="transit_countries[]" value="{{ $country }}"
                                       id="country_{{ $loop->index }}"
                                       {{ in_array($country, $selected) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="country_{{ $loop->index }}">
                                    {{ $country }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Ficheiro do Documento --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header fw-semibold" style="background:#0a3d62;color:#fff;border-radius:10px 10px 0 0">
                <i class="bi bi-paperclip me-2"></i>Ficheiro do Documento
            </div>
            <div class="card-body">
                @if($editing && $permit->document_file)
                <div class="alert alert-info d-flex align-items-center gap-3 mb-3">
                    <i class="bi bi-file-earmark-check fs-4"></i>
                    <div>
                        <div class="fw-semibold">{{ $permit->document_original_name }}</div>
                        <div class="small text-muted">Ficheiro actual. Carregue um novo para substituir.</div>
                    </div>
                    <a href="{{ Storage::url($permit->document_file) }}" target="_blank"
                       class="btn btn-sm btn-outline-primary ms-auto">
                        <i class="bi bi-eye me-1"></i>Ver
                    </a>
                </div>
                @endif
                <label class="form-label">
                    {{ $editing && $permit->document_file ? 'Substituir Ficheiro' : 'Carregar Ficheiro' }}
                    <span class="text-muted small">(PDF, JPG, PNG — máx. 10MB)</span>
                </label>
                <input type="file" name="document_file" class="form-control @error('document_file') is-invalid @enderror"
                       accept=".pdf,.jpg,.jpeg,.png">
                @error('document_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
</div>
