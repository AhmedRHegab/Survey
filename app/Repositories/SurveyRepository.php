<?php

namespace App\Repositories;

use App\Models\Attachment;
use App\Models\Survey;
use App\Traits\MediaTrait;
use Illuminate\Pagination\LengthAwarePaginator;

class SurveyRepository
{
    use MediaTrait;

    protected object $request;
    protected object $survey;


    public function getSurveys(): LengthAwarePaginator
    {

        $surveys = Survey::query();
        $query = $surveys->with([
            'user:id,name',
            'step:id,name',
            'group:id,number'
        ]);
        // Filter By Type
        $query = $surveys->when($this->request->filled('surveyType'), function ($q) {
            $q->where('type', '=', $this->request->surveyType);
        });
        // Filter By Step
        $query =  $surveys->when($this->request->filled('step'),function($q){
            $q->where('step_id', '=' ,$this->request->step);
        });
        // Filter By Group
        $query = $surveys->when($this->request->filled('group'),function ($q){
           $q->where('group_id', '=', $this->request->group);
        });
        //Filter By User
        $query = $surveys->when($this->request->filled('user'), function ($q){
            $q->where('user_id', '=', $this->request->user);
        });

        //Filter By Time

        $query = $surveys->when($this->request->filled('start_date'),function($q){
            $q->whereBetween('created_at' , array($this->request->start_date, $this->request->end_date));
        });
//        $query = $surveys->when($this->request->filled('end_date'),function($q){
//                $q->where('created_at', '<=' , $this->request->end_date);
//        });
        return $surveys->latest()->paginate(config('setting.LimitPaginate'))->withQueryString();

    }// End Get Surveys

    public function store(): SurveyRepository
    {
        $survey = Survey::create([
            'step_id' => $this->request->step,
            'group_id' => $this->request->group,
            'no_security' => $this->request->no_security,
            'no_unit' => $this->request->no_unit,
            'notes' => $this->request->notes,
            'type' => $this->request->type,
            'user_id' => auth()->user()->id
        ]);
        $this->survey = $survey;
        return $this;
    }// End Store

    public function storeAttachments(): SurveyRepository
    {
        if ($this->request->hasFile('attachments')) {
            foreach ($this->request['attachments'] as $attachment) {
                $this->survey->attachments()->create([
                    'photo' => $this->storeMedia($attachment, 'files', 'survey'),
                ]);
            }
        }

        return $this;

    }// End Store Attachments

    public function storeAnswer(): SurveyRepository
    {
        $this->survey->answers()->delete();
        if ($this->request->filled('questions')) {
            foreach ($this->request->questions as $question) {

                $this->survey->answers()->create([
                    'question_id' => $question
                ]);
            }
        }

        return $this;
    }


    public function inputRequest(object $request): SurveyRepository
    {
        $this->request = $request;

        return $this;
    }// End InputRequest

    public function surveyModel(object $model): SurveyRepository
    {
        $this->survey = $model;
        return $this;
    }// End SurveyModel

    public function getSurveyById(): object
    {
        return $this->survey->with([
            'answers:id,question_id,survey_id',
            'attachments:id,photo,survey_id'
        ])->findOrFail($this->survey->id);
    }// End GetSurveyById

    public function update(): SurveyRepository
    {
        $this->survey->update([
            'step_id' => $this->request->step,
            'group_id' => $this->request->group,
            'no_security' => $this->request->no_security,
            'no_unit' => $this->request->no_unit,
            'notes' => $this->request->notes,
        ]);
        return $this;
    }// End Update

    public function destroyAttachments(): void
    {
        $attachments = Attachment::select(['id', 'photo'])->whereIn('id', $this->request->attachments)->get();


        if (count($this->request->attachments) > 0) {
            foreach ($attachments as $attachment) {
                $this->deleteMedia('files', 'survey', $attachment->photo);
                $attachment->delete();
            }//End Foreach
        }
    }// End Destroy Attachments
}
