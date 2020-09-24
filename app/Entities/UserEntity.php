<?php namespace App\Entities;

class UserEntity extends \CodeIgniter\Entity
{

    protected $dates = array('created_at', 'updated_at', 'deleted_at');

    public function setPassword(string $pass)
    {
        $this->attributes['password'] = password_hash($pass, PASSWORD_BCRYPT);

        return $this;
    }
}