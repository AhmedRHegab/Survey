<?php

namespace App\Services\Group;

use App\Repositories\GroupRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class GroupService
{
    protected GroupRepository $groupRepository;
    protected object $inputs;
    protected object $group;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function groups(): LengthAwarePaginator
    {
        return $this->groupRepository->getGroups();
    }

    public function storeGroup()
    {
        $this->groupRepository->store($this->inputs);
    }

    public function updateGroup()
    {
        $this->groupRepository->update($this->inputs, $this->group);
    }

    public function requestInputs(object $request): GroupService
    {
        $this->inputs = $request;

        return $this;
    }


    public function groupModel(object $group): GroupService
    {
        $this->group = $group;
        return $this;
    }

    public function stepGroups($id)
    {
        return $this->groupRepository->stepGroups($id);
    }


}
