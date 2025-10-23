<?php

namespace App\Repositories;

use App\Models\Step;

class StepRepository
{


    public function getSteps()
    {
        return Step::latest()->paginate(config('setting.LimitPaginate'));
    }
    public function store(object $inputs)
    {
        Step::create([
            'name'      => $inputs->name,
            'status'    => $inputs->status,
            'user_id'   => auth()->user()->id
        ]);
    }

    public function update(object $inputs, object $step)
    {
        $step->update([
            'name'      => $inputs->name,
            'status'    => $inputs->status,
            'user_id'   => auth()->user()->id
        ]);
    }

    public function stepsWithOutPaginate()
    {
        return Step::select(['id', 'name'])->active()->get();
    }


}
