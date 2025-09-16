<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConceptMap extends Model
{
    use HasFactory;

    protected $guarded;

    protected $casts = [
        'nodes' => 'array',
        'edges' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function sq3rSession()
    {
        return $this->belongsTo(SQ3RSession::class, 'sq3r_session_id');
    }

}
