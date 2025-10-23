<?php

namespace App\Http\Controllers\Dashboard\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Group\GroupStoreRequest;
use App\Http\Requests\Dashboard\Group\GroupUpdateRequest;
use App\Models\Group;
use App\Services\Group\GroupService;
use App\Services\Step\StepService;
use Illuminate\Http\RedirectResponse;


class GroupController extends Controller
{
    public GroupService $groupService;
    public StepService $stepService;

    public function __construct(GroupService $groupService, StepService $stepService)
    {
        $this->groupService = $groupService;
        $this->stepService = $stepService;
        $this->middleware('permission:group_access', ['only' => ['index']]);
        $this->middleware('permission:group_create', ['only' => ['store']]);
        $this->middleware('permission:group_edit', ['only' =>   ['update']]);
    }// End Construct

    public function index()
    {
        $groups = $this->groupService->groups();
        $steps = $this->stepService->getStepsWithOutPaginate();
        return view('dashboard.groups.index', compact('groups', 'steps'));
    }// End Index

    public function store(GroupStoreRequest $request): RedirectResponse
    {
        try {
            $this->groupService->requestInputs($request)->storeGroup();
            return redirect()->back()->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }
    }//End Store

    public function update(GroupUpdateRequest $request, Group $group): RedirectResponse
    {
        try {
            $this->groupService->requestInputs($request)->groupModel($group)->updateGroup();
            return redirect()->back()->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }
    }//End Update

    public function groupsStep($id)
    {
        return $this->groupService->stepGroups($id);
    }// End Groups
}
