<?php

namespace App\Http\Controllers\Dashboard\Survey;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Survey\SurveyStoreRequest;
use App\Http\Requests\Dashboard\Survey\SurveyUpdateRequest;
use App\Models\Survey;
use App\Pattern\SurveyPattern;
use App\Interfaces\SurveyInterface;
use Illuminate\Http\RedirectResponse;

class BuildingController extends Controller implements SurveyInterface
{
    public SurveyPattern $surveyPattern;
    public const  SURVEY_TYPE = 'building';

    public function __construct(SurveyPattern $surveyPattern)
    {
        $this->surveyPattern = $surveyPattern;
        $this->middleware('permission:building_add', ['only' => ['store']]);
        $this->middleware('permission:survey_edit', ['only' =>   ['update', 'edit']]);
    }// End Construct

    public function show(Survey $survey)
    {
        return view('dashboard.surveys.building.show', compact('survey'));
    }// End Show

    public function create()
    {
        $data = $this->surveyPattern->surveyType(self::SURVEY_TYPE)->create();
        return view('dashboard.surveys.building.create')->with($data);
    }// End Create

    public function store(SurveyStoreRequest $request) :RedirectResponse
    {
        try {

            $this->surveyPattern->requestInput($request)->store();
            return redirect()->back()->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }
    }// End Store

    public function edit(Survey $survey)
    {
        $data = $this->surveyPattern->surveyType(self::SURVEY_TYPE)->surveyModel($survey)->edit();
        return view('dashboard.surveys.building.edit')->with($data);
    }// End Edit

    public function update(SurveyUpdateRequest $request, Survey $survey): RedirectResponse
    {
        try {
            $this->surveyPattern->requestInput($request)->surveyModel($survey)->update();
            return redirect()->back()->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }
    }// End Update
}
