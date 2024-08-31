<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Classes extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public $timestamps = false;

    protected $table = 'classes';

    // public function timeFrom(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => date('h:i a', strtotime($value)),
    //     );
    // }

    // public function timeTo(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => date('h:i a', strtotime($value)),
    //     );
    // }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
