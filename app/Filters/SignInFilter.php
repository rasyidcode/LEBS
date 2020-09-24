<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use \Config\Services;

class SignInFilter implements \CodeIgniter\Filters\FilterInterface
{

    use \CodeIgniter\API\ResponseTrait;

    private $userModel;

    protected $response;

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel;
        $this->response = Services::response();
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $loginPayload = $request->getJSON();

        /* check if this is a valid JSON */
        if ($loginPayload == null) {
            return $this->failForbidden('Invalid JSON payload.');
        }

        /* check if required field is exist */
        if (!$this->validateLogin($loginPayload)) {
            return $this->failValidationError('Username and password is required');
        }

        /* check if user exist or not */
        if ($this->userModel->isUserExist($loginPayload->username)) {
            /* check if user is verified */
            if (!$this->userModel->isUserVerified($loginPayload->username)) {
                return $this->failUnauthorized('This user is not verified yet, please check your email to verify.');
            }

            /* check if user is activated */
            if (!$this->userModel->isUserActive($loginPayload->username)) {
                return $this->failUnauthorized('Your account has been disabled, please contact the administrator for the activation');
            }
        }
        
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // something after operation
    }

    private function validateLogin($data) {
        return property_exists($data, 'username') && property_exists($data, 'password');
    }

}