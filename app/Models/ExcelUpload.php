<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExcelUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_user_id',
        'filename',
        'original_filename',
        'file_path',
        'file_size',
        'records_processed',
        'processing_summary',
        'status',
        'error_message',
        'processed_at'
    ];

    protected $casts = [
        'processing_summary' => 'array',
        'processed_at' => 'datetime'
    ];

    // Relación con el usuario administrador
    public function adminUser()
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    // Scope para obtener solo uploads exitosos
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Scope para obtener uploads recientes
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Verificar si el procesamiento fue exitoso
    public function isSuccessful()
    {
        return $this->status === 'completed' && $this->records_processed > 0;
    }
}
