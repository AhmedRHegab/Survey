<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyAnswer extends Model
{
    use HasFactory;

    protected $table = 'survey_answers';
    protected $guarded = [];

    public function question() :BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }
    public function survey() :BelongsTo
    {
        return $this->belongsTo(Survey::class, 'survey_id', 'id');
    }
}
