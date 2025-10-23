<?php

namespace App\Repositories;

use App\Models\Group;
use Illuminate\Pagination\LengthAwarePaginator;

class GroupRepository
{


    public function getGroups() :LengthAwarePaginator
    {
        return Group::with('step')->latest()->paginate(config('setting.LimitPaginate'));

    }// End GetGroups

    public function GroupsWithOutPaginate() {
        return Group::active()->latest()->get();
    }

    public function store(object $inputs)
    {
        Group::create([
            'number'    => $inputs->number,
            'status'    => $inputs->status,
            'step_id'   => $inputs->step,
            'user_id'   => auth()->user()->id,
        ]);
    }

    public function update(object $inputs, object $group)
    {
        $group->update([
            'number'    => $inputs->number,
            'status'    => $inputs->status,
            'step_id'   => $inputs->step,
        ]);
    }

    public function stepGroups($id)
    {
        return Group::where('step_id', $id)->get();
    }


}
