<?php

namespace App\Http\Controllers\Dashboard\Step;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Step\StepStoreRequest;
use App\Http\Requests\Dashboard\Step\StepUpdateRequest;
use App\Models\Step;
use App\Services\Step\StepService;
use Illuminate\Http\RedirectResponse;


class StepController extends Controller
{
   public StepService $stepService;

    public function __construct(StepService $stepService)
    {
        $this->stepService = $stepService;
        $this->middleware('permission:step_access', ['only' => ['index']]);
        $this->middleware('permission:step_create', ['only' => ['store']]);
        $this->middleware('permission:step_edit', ['only' =>   ['update']]);
    }// End Construct

    public function index()
    {
        $steps =  $this->stepService->steps();
        return view('dashboard.steps.index', compact('steps'));
    }// End Index

    public function store(StepStoreRequest $request) :RedirectResponse
    {
        try {

            $this->stepService->requestInputs($request)->storeStep();
            return redirect()->back()->with('success', 'تم الحفظ بنجاح');
        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()] );
        }
    }// End Store

    public function update(StepUpdateRequest $request, Step $step) :RedirectResponse
    {
        try {

            $this->stepService->requestInputs($request)->stepModel($step)->updateStep();
            return redirect()->back()->with('success', 'تم الحفظ بنجاح');
        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()] );
        }
    }// End Update
}
