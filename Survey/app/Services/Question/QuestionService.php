<?php

namespace App\Services\Question;

use App\Repositories\QuestionRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class QuestionService
{
    protected QuestionRepository $questionRepository;
    protected object $inputs;
    protected object $question;
    protected string $type;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function questions() :LengthAwarePaginator
    {
        return $this->questionRepository->getQuestions();
    }// End Questions

    public function storeQuestion()
    {
        $this->questionRepository->store($this->inputs);
    }// End Store Question

    public function updateQuestion()
    {
        $this->questionRepository->update($this->inputs, $this->question);
    }// End Update Question

    public function getQuestionsByType()
    {
      return  $this->questionRepository->getQuestionsByType($this->type);
    }

    public function requestInput(object $request) :QuestionService
    {
        $this->inputs = $request;
        return $this;
    }//End RequestInput

    public function questionModel(object $model) :QuestionService
    {
        $this->question = $model;
        return $this;
    }//End Question Model

    public function type(string $type) :QuestionService
    {
        $this->type = $type;
        return $this;
    }//End Type
}
