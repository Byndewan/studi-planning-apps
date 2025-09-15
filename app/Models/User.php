<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the URL to the user's profile photo.
     */
    public function getProfilePhotoUrlAttribute()
    {
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Relationship with semesters
     */
    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }

    /**
     * Relationship with courses through semesters
     */
    public function courses()
    {
        return $this->hasManyThrough(Course::class, Semester::class);
    }

    /**
     * Relationship with weekly plans through courses
     */
    public function weeklyPlans()
    {
        return $this->hasManyThrough(
                WeeklyPlan::class,
                Course::class,
                'semester_id',
                'course_id',
                'id',
                'id'
            )
            ->join('semesters', 'courses.semester_id', '=', 'semesters.id')
            ->where('semesters.user_id', $this->id);
    }

    /**
     * Get completed plans count
     */
    public function getCompletedPlansCountAttribute()
    {
        return $this->weeklyPlans()->where('status', 'completed')->count();
    }

    /**
     * Get study sessions count (SQ3R sessions)
     */
    public function getStudySessionsCountAttribute()
    {
        return SQ3RSession::where('user_id', $this->id)->count();
    }

    public function getSemestersCountAttribute()
    {
        return $this->semesters()->count();
    }

    public function getCoursesCountAttribute()
    {
        return $this->courses()->count();
    }

}
