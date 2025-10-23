<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public UserRepository $userRepository;

    protected object $inputs;

    protected object $user ;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }// End Construct

    public function requestInputs($request) :UserService
    {
        $this->inputs = $request;
        return $this;
    }//End Request

    public function userModel($model) :UserService
    {
      $this->user = $model;
      return $this;
    }// End UserModel

    public function getUsers():lengthAwarePaginator
    {
        return $this->userRepository->users();
    }// End GetUsers

    public function storeUser()
    {
        $this->userRepository->store($this->inputs);
    }// End StoreUsers

    public function updateUser()
    {
        $this->userRepository->update($this->inputs , $this->user);
    }// End UpdateUser

    public function getUsersWithOutPaginate()
    {
     return $this->userRepository->getUsersWithoutPaginate();
    }// End GetUserWithOutPaginate
}
