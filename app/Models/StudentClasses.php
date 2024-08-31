<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentClasses extends Model
{
    use HasFactory;

    protected $table = 'students_classes';

    protected $guarded = [];

    public function classes(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function students(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
