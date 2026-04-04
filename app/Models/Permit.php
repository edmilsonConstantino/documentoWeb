<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    use HasFactory;

    protected $fillable = [
        'number', 'reference', 'document_type', 'client_name', 'nuit',
        'vehicle_registration', 'vehicle_brand', 'cargo_type', 'capacity',
        'origin', 'transit_countries', 'issued_at', 'expires_at',
        'status', 'validation_token', 'document_file', 'document_original_name',
    ];

    protected $casts = [
        'transit_countries' => 'array',
        'issued_at' => 'date',
        'expires_at' => 'date',
    ];

    public function isValid(): bool
    {
        return $this->status === 'valid' && $this->expires_at->isFuture();
    }

    public function getStatusLabelAttribute(): string
    {
        if ($this->status === 'cancelled') return 'Cancelado';
        if ($this->expires_at->isPast()) return 'Expirado';
        return 'Válido';
    }

    public function getStatusColorAttribute(): string
    {
        if ($this->status === 'cancelled') return 'danger';
        if ($this->expires_at->isPast()) return 'warning';
        return 'success';
    }
}
