<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $guarded;

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function semesterSchedules(): HasMany
    {
        return $this->hasMany(SemesterSchedule::class);
    }

    public function weeklyPlans(): HasMany
    {
        return $this->hasMany(WeeklyPlan::class);
    }

    public function monitorings(): HasMany
    {
        return $this->hasMany(Monitoring::class);
    }

    public function sq3rSessions(): HasMany
    {
        return $this->hasMany(SQ3RSession::class);
    }

    public function conceptMaps(): HasMany
    {
        return $this->hasMany(ConceptMap::class);
    }
}
