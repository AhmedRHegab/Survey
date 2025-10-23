<?php

namespace App\Http\Controllers\Dashboard\Survey;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Services\Step\StepService;
use App\Services\Survey\SurveyService;
use App\Services\User\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public SurveyService $surveyService;
    public StepService  $stepService;
    public UserService  $userService;
    public function __construct(SurveyService $surveyService, StepService $stepService, UserService $userService)
    {
        $this->surveyService = $surveyService;
        $this->stepService = $stepService;
        $this->userService = $userService;

        $this->middleware('permission:survey_access', ['only' =>   ['index']]);
        $this->middleware('permission:survey_edit', ['only' =>   ['destroyAttachment']]);

    }// End Construct

    public function index(Request $request)
    {
        $surveys = $this->surveyService->inputRequest($request)->surveys();
        $steps   = $this->stepService->getStepsWithOutPaginate();
        $users   = $this->userService->getUsersWithOutPaginate();
        return view('dashboard.surveys.index', compact('surveys', 'steps', 'users'));
    }// End Index

    public function destroyAttachment(Request $request, Survey $survey) :RedirectResponse
    {


        try {
            $this->surveyService->inputRequest($request)->destroyAttachments();
            return redirect()->back()->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }
    }// ENd DestroyAttachment
}
