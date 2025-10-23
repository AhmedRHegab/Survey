<?php

namespace App\Repositories;

use App\Models\Question;
use Illuminate\Pagination\LengthAwarePaginator;

class QuestionRepository
{


    public function getQuestions() :LengthAwarePaginator
    {
        return Question::with('user')->latest()->paginate(config("setting.LimitPaginate"));
    }// End getQuestion

    public function getQuestionsByType($type)
    {
        return Question::type($type)->active()->get();
    }// End getQuestion

    public function store(object $inputs)
    {
        Question::create([
            'question'      => $inputs->question,
            'status'        => $inputs->status,
            'type'          => $inputs->type,
            'input_type'    => $inputs->inputType,
            'user_id'       => auth()->user()->id
        ]);
    }// End Store

    public function update(object $inputs, object $question)
    {
        $question->update([
            'question'      => $inputs->question,
            'status'        => $inputs->status,
            'type'          => $inputs->type,
            'input_type'    => $inputs->inputType,
        ]);
    }// End Update
}
