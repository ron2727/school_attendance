<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use SoftDeletes;
    use HasFactory;
    
    protected $guarded = [];

    public $timestamps = false;

    protected $table = 'classes';

    public function timeFrom(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => date('h:i a', strtotime($value)),
        );
    }

    public function timeTo(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => date('h:i a', strtotime($value)),
        );
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'class_id');
    } 

    public function studentsClasses(): HasMany
    {
        return $this->hasMany(StudentClasses::class, 'class_id');
    }

    public function attendance(): HasMany
    {
        return $this->hasMany(Attendance::class, 'class_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    
}
