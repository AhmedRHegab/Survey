<?php

namespace App\Services\Survey;

use App\Repositories\SurveyRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class SurveyService
{
    public SurveyRepository $surveyRepository;
    public object $inputs;
    protected object $survey;

    public function __construct(SurveyRepository $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }// End Construct

    public function surveys(): LengthAwarePaginator
    {
        return $this->surveyRepository->inputRequest($this->inputs)->getSurveys();
    }// End Surveys

    public function inputRequest(object $request): SurveyService
    {
        $this->inputs = $request;
        return $this;
    }// End InputRequest

    public function surveyModel(object $model): SurveyService
    {
        $this->survey = $model;
        return $this;
    }// End SurveyModel

    public function storeSurvey()
    {
        $this->surveyRepository
            ->inputRequest($this->inputs)
            ->store()
            ->storeAttachments()
            ->storeAnswer();
    }// End Store Survey

    public function survey(): object
    {
        return $this->surveyRepository->surveyModel($this->survey)->getSurveyById();
    }// End Survey

    public function surveyAnswers(): array
    {
        $survey = $this->survey();
        $answers = [];
        foreach ($survey->answers as $answer) {
            $answers[] = $answer->question_id;
        }

        return $answers;
    }// End SurveyAnswers

    public function updateSurvey()
    {
        $this->surveyRepository
            ->inputRequest($this->inputs)
            ->surveyModel($this->survey)
            ->update()
            ->storeAttachments()
            ->storeAnswer();
    }// End Update Survey

    public function destroyAttachments()
    {
        $this->surveyRepository->inputRequest($this->inputs)->destroyAttachments();
    }// End DestroyAttachment

}
