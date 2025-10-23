<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Step extends Model
{
    use HasFactory;
    protected $table = 'steps';
    protected $guarded = [];

    public function groups() :HasMany
    {
        return $this->hasMany(Group::class, 'step_id', 'id');
    }// End Group

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }// End User

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
