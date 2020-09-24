<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements CodeIgniter\Filters\FilterInterface
{
    
    use CodeIgniter\API\ResponseTrait;

    public function before(RequestInterface $request)
    {
        $key = Config\Services::getSecretKey();
        $authHeader = $request->getServer('HTTP_AUTHORIZATION');
        $arr = explode(' ', $authHeader);
        $token = $arr[1];

        try {
            Firebase\JWT\JWT::decode($token, $key, ['HS256']);
        } catch(\Exception $e) {
            return Config\Services::response()
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // something after operation
    }

}