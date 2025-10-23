<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Group extends Model
{
    use HasFactory;
    protected $table = 'groups';
    protected $guarded = [];

    public function step() :BelongsTo
    {
        return $this->belongsTo(Step::class, 'step_id', 'id');
    }// End Step

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }// End User

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
