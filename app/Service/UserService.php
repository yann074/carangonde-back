<?php

namespace App\Service;
use App\Models\User;
class UserService{

    protected $userModel;
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }
    public function getAllUsers()
    {
        return $this->userModel->all();
    }
    public function getUserById($id)
    {
        return $this->userModel->find($id);
    }
    

}