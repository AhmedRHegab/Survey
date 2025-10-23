<?php

namespace App\Pattern;

use App\Services\Group\GroupService;
use App\Services\Question\QuestionService;
use App\Services\Step\StepService;
use App\Services\Survey\SurveyService;

class SurveyPattern
{
    public SurveyService $safeSecurityService;
    public StepService $stepService;
    public QuestionService $questionService;
    public GroupService  $groupService;
    protected string $type;
    protected object $inputs;
    protected  object  $survey;
    public function __construct
    (
        SurveyService       $safeSecurityService,
        StepService         $stepService,
        QuestionService     $questionService,
        GroupService        $groupService
    )

    {
        $this->safeSecurityService = $safeSecurityService;
        $this->stepService = $stepService;
        $this->questionService = $questionService;
        $this->groupService       = $groupService;
    }// End Construct

    public function surveyType($type) :SurveyPattern
    {
        $this->type = $type;
        return $this;
    }// End SurveyType

    public function requestInput($inputs) :SurveyPattern
    {
        $this->inputs = $inputs;
        return $this;
    }

    public function surveyModel($survey) :SurveyPattern
    {
        $this->survey = $survey;
        return $this;
    }

    public function create() :array
    {
        $steps = $this->stepService->getStepsWithOutPaginate();
        $questions = $this->questionService
            ->type($this->type)
            ->getQuestionsByType();

        return [
            'steps' => $steps,
            'questions' => $questions
        ];
    }// End Create

    public function store()
    {
        $this->safeSecurityService->inputRequest($this->inputs)->storeSurvey();
    }// End Store

    public function edit() :array
    {
        $steps = $this->stepService->getStepsWithOutPaginate();
        $questions = $this->questionService
            ->type($this->type)
            ->getQuestionsByType();
        $survey =  $this->safeSecurityService->surveyModel($this->survey)->survey();
        $groups = $this->groupService->stepGroups($survey->step_id);
        $answers =  $this->safeSecurityService->surveyModel($survey)->surveyAnswers();

        return [
            'steps'     => $steps,
            'questions' => $questions,
            'survey'    => $survey,
            'groups'    => $groups,
            'answers'   => $answers
        ];
    }// End Edit

    public function update()
    {
        $this->safeSecurityService->inputRequest($this->inputs)->surveyModel($this->survey)->updateSurvey();

    }// End Update

}
