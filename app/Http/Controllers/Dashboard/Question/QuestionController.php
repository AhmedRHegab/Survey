<?php

namespace App\Http\Controllers\Dashboard\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Question\QuestionStoreRequest;
use App\Http\Requests\Dashboard\Question\QuestionUpdateRequest;
use App\Models\Question;
use App\Services\Question\QuestionService;
use Illuminate\Http\RedirectResponse;


class QuestionController extends Controller
{
    public QuestionService $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
        $this->middleware('permission:question_access', ['only' => ['index']]);
        $this->middleware('permission:question_create', ['only' => ['store']]);
        $this->middleware('permission:question_edit', ['only' =>   ['update']]);
    }// End Construct

    public function index()
    {
        $questions = $this->questionService->questions();
        return view('dashboard.questions.index', compact('questions'));
    }// End Index

    public function store(QuestionStoreRequest $request) :RedirectResponse
    {
        try {

            $this->questionService->requestInput($request)->storeQuestion();
            return redirect()->back()->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }

    }// End Store

    public function update(QuestionUpdateRequest $request, Question $question) :RedirectResponse
    {
        try {

            $this->questionService
                ->requestInput($request)
                ->questionModel($question)
                ->updateQuestion();

            return redirect()->back()->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }

    }//End Update
}
