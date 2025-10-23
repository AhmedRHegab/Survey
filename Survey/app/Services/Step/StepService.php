<?php

namespace App\Services\Step;

use App\Repositories\StepRepository;

class StepService
{
    protected object $inputs;
    protected object $step;

    public StepRepository  $stepRepository;

    public function __construct(StepRepository $stepRepository)
    {
        $this->stepRepository = $stepRepository;
    }


    public function steps()
    {
        return $this->stepRepository->getSteps();
    }// End Step


    public function getStepsWithOutPaginate()
    {
        return $this->stepRepository->stepsWithOutPaginate();
    }// End GetStepsWithoutPaginate

    public function storeStep()
    {
        $this->stepRepository->store($this->inputs);
    }//End StoreStep

    public function updateStep()
    {
        $this->stepRepository->update($this->inputs, $this->step);
    }// End UpdateStep

    public function requestInputs($request) :StepService
    {
        $this->inputs = $request;
        return $this;
    }//End Request

    public function stepModel($model) :StepService
    {
        $this->step = $model;
        return $this;
    }// End Step Model
}
