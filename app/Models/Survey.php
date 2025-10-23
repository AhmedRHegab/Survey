<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Survey extends Model
{
    use HasFactory;
    protected $table = 'surveys';
    protected $guarded = [];

    public function step() :BelongsTo
    {
        return $this->belongsTo(Step::class, 'step_id', 'id');
    }// End Step

    public function group() :BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }// End Group

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }// End User

    public function attachments() :HasMany
    {
        return $this->hasMany(Attachment::class, 'survey_id', 'id');
    }// End Attachments


    public function answers() :HasMany
    {
        return $this->hasMany(SurveyAnswer::class , 'survey_id', 'id');
    }// End Answers

    public function scopeType($query, $type)
    {
        $query->where('type', $type);
    }// End Type

}
