<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Semester extends Model
{
    use HasFactory;

    protected $guarded;

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    protected $appends = ['is_current'];

    /**
     * Check if semester is current
     */
    public function getIsCurrentAttribute(): bool
    {
        $now = Carbon::now();
        return $now->between($this->start_date, $this->end_date);
    }

    /**
     * Get weeks count in semester
     */
    public function getWeeksCountAttribute(): int
    {
        return $this->start_date->diffInWeeks($this->end_date);
    }

    /**
     * Get progress percentage
     */
    public function getProgressAttribute(): float
    {
        $totalDays = $this->start_date->diffInDays($this->end_date);
        $passedDays = $this->start_date->diffInDays(now());

        if ($totalDays === 0) return 0;

        $progress = min(100, max(0, ($passedDays / $totalDays) * 100));
        return round($progress, 1);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function studyGoals(): HasMany
    {
        return $this->hasMany(StudyGoal::class);
    }

    public function semesterSchedules(): HasMany
    {
        return $this->hasMany(SemesterSchedule::class);
    }
}
