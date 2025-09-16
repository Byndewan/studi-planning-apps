<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SQ3RSession extends Model
{
    protected $table = 'sq3r_sessions';

    use HasFactory;

    protected $guarded;

    protected $casts = [
        'questions' => 'array',
        'timestamps' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function conceptMaps()
    {
        return $this->hasMany(ConceptMap::class, 'sq3r_session_id');
    }

}
