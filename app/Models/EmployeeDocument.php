<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class EmployeeDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cs_profile_id',
        'document_type',
        'document_number',
        'file_path',
        'original_filename',
        'file_size',
        'uploaded_at',
        'is_verified',
        'verified_by',
        'verified_at',
        'notes',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'verified_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    protected $appends = ['document_type_label', 'file_url'];

    /**
     * Relationships
     */
    public function csProfile()
    {
        return $this->belongsTo(CsProfile::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Attributes
     */
    public function getDocumentTypeLabelAttribute()
    {
        return match($this->document_type) {
            'ktp' => 'KTP (Kartu Tanda Penduduk)',
            'kk' => 'KK (Kartu Keluarga)',
            'ijazah' => 'Ijazah',
            'rekening' => 'Buku Rekening',
            default => 'Unknown',
        };
    }

    public function getFileUrlAttribute()
    {
        return $this->file_path ? Storage::url($this->file_path) : null;
    }

    /**
     * Scopes
     */
    public function scopeByType($query, $type)
    {
        return $query->where('document_type', $type);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeUnverified($query)
    {
        return $query->where('is_verified', false);
    }

    /**
     * Helper Methods
     */

    // Verify document
    public function verify($userId, $notes = null)
    {
        $this->update([
            'is_verified' => true,
            'verified_by' => $userId,
            'verified_at' => now(),
            'notes' => $notes,
        ]);

        return $this;
    }

    // Unverify document
    public function unverify($notes = null)
    {
        $this->update([
            'is_verified' => false,
            'verified_by' => null,
            'verified_at' => null,
            'notes' => $notes,
        ]);

        return $this;
    }

    // Delete file from storage
    public function deleteFile()
    {
        if ($this->file_path && Storage::exists($this->file_path)) {
            Storage::delete($this->file_path);
        }

        return true;
    }

    // Override delete to also delete file
    public function delete()
    {
        $this->deleteFile();
        return parent::delete();
    }

    // Format file size
    public function getFormattedFileSizeAttribute()
    {
        if (!$this->file_size) return '-';

        $bytes = (int) $this->file_size;

        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return round($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
