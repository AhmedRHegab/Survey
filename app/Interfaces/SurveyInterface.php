<?php

namespace App\Interfaces;

use App\Http\Requests\Dashboard\Survey\SurveyStoreRequest;
use App\Http\Requests\Dashboard\Survey\SurveyUpdateRequest;
use App\Models\Survey;

interface SurveyInterface
{
    public function show(Survey $survey);
    public function create();
    public function store(SurveyStoreRequest $request);
    public function edit(Survey $survey);
    public function update(SurveyUpdateRequest $request, Survey $survey);
}
