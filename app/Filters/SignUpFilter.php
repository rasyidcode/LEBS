<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class SignUpFilter implements \CodeIgniter\Filters\FilterInterface
{

    use \CodeIgniter\API\ResponseTrait;

    protected $response;

    public function __construct()
    {
        $this->response = Services::response();
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $signUpPayload = $request->getJSON();

        /* check if this is a valid JSON */
        if ($signUpPayload == null) {
            return $this->failForbidden('Invalid JSON request');
        }

        $errors = $this->validatePayload($signUpPayload);
        if (count($errors) > 0) {
            return $this->fail((object) $errors);
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $argumetns = null)
    {
        // something after operation
    }
    
    private function validatePayload($payload) {
        $requiredFields = array(
            'full_name',
            'address',
            'birthday',
            'phone_number',
            'email',
            'gender',
            'username',
            'password'
        );
        $errors = array();

        foreach($requiredFields as $field) {
            if (!property_exists($payload, $field)) {
                $errors[$field] = $field . ' is required.';
            }
        }

        return $errors;
    }
}