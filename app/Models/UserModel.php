<?php namespace App\Models;

class UserModel extends \CodeIgniter\Model
{
    protected $DBGroup = 'default';

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\UserEntity';

    protected $allowedFields = [
        'full_name', 'address', 'birthday', 'phone_number',
        'email', 'gender', 'username', 'password'];

    protected $useTimestamps = true;

    protected $validationRules = [
        'full_name'     => 'required',
        'address'       => 'required',
        'birthday'      => 'required|regex_match[/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/]',
        'phone_number'  => 'required|is_unique[users.phone_number]',
        'email'         => 'required|is_unique[users.email]|valid_email',
        'gender'        => 'required|in_list[male,female]',
        'username'      => 'required|string|is_unique[users.username]|min_length[5]',
        'password'      => 'required|min_length[5]',
    ];

    protected $validationMassages = [

    ];

    /**
     * get user detail by username
     * @note username can be username, email, or phone_number
     * 
     * @param string $username
     * 
     * @return object
     * or
     * @return null
     */
    public function getUserData(string $username) {
        $builder = $this->db->table('users');
        $builder->select('full_name, address, username, password');
        $builder->where('username', $username);
        $builder->orWhere('email', $username);
        $builder->orWhere('phone_number', $username);
        $result = $builder->get();

        if ($result->getRow() !== null) {
            return $result->getRow();
        } else {
            return null;
        }
    }

    /**
     * check if user is verified or not
     * @note username can be username, email, or phone_number
     * 
     * @param string $username
     * 
     * @return bool
     */
    public function isUserVerified(string $username)
    {
        $builder = $this->db->table('users');
        $builder->select('is_verified');
        $builder->where('username', $username);
        $builder->orWhere('email', $username);
        $builder->orWhere('phone_number', $username);
        $result = $builder->get();

        if ($result->getRow() !== null) {
            if ($result->getRow()->is_verified) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * check if user is activate or not
     * @note username can be username, email, or phone_number
     * 
     * @param string $username
     * 
     * @return bool
     */
    public function isUserActive(string $username)
    {
        $builder = $this->db->table('users');
        $builder->select('is_active');
        $builder->where('username', $username);
        $builder->orWhere('email', $username);
        $builder->orWhere('phone_number', $username);
        $result = $builder->get();

        if ($result->getRow() !== null) {
            if ($result->getRow()->is_active) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * check if user exist
     * @note username can be either email or phone_number
     * 
     * @param string $username
     * 
     * @return bool
     */
    public function isUserExist(string $username)
    {
        $builder = $this->db->table('users');
        $builder->select('username');
        $builder->where('username', $username);
        $builder->orWhere('email', $username);
        $builder->orWhere('phone_number', $username);
        $result = $builder->get();

        if ($result->getResultArray()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get user id by username
     * 
     * @param string $username
     * 
     * @return int $userId
     */
    public function getUserIdByUsername(string $username)
    {
        $builder = $this->db->table('users');
        $builder->select('id');
        $builder->where('username', $username);
        $result = $builder->get();

        if ($result->getRow() != null) {
            return $result->getRow()->id;
        } else {
            return null;
        }
    }
}