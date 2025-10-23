<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';
    protected $guarded = [];

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }// End User

    public function scopeType($query,$type)
    {
        $query->where('type' , $type);
    }// End ScopeType

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }// End ScopeActive


}
