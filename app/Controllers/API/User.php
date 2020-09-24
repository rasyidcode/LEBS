<?php namespace App\Controllers\API;

use App\Models\UserModel;
use App\Entities\UserEntity;
use App\Helpers\MyHelper;
use App\Controllers\BaseController;

class User extends BaseController
{
    use \CodeIgniter\API\ResponseTrait;

    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel;
    }

    /**
     * Login endpoint
     * 
     * @endpoint {base_url}/api/v1/user/signIn
     * @payload
     *  - username
     *  - password
     */
    public function signIn()
    {
        $data = $this->request->getJSON();

        $userData = $this->userModel->getUserData($data->username);
        if ($userData !== null) {
            if (password_verify($data->password, $userData->password)) {
                unset($userData->password);

                $key = \Config\Services::getSecretKey();
                $iat = time();
                $payload = array(
                    'iss'   => base_url(),
                    'sub'   => 'JWT AUTH',
                    'aud'   => current_url(),
                    'iat'   => $iat,
                    'nbf'   => $iat + 10,
                    'exp'   => $iat + 3600,
                    'data'  => $userData
                );

                $token = \Firebase\JWT\JWT::encode($payload, $key);

                return $this->respond(array(
                    'status'    => 200,
                    'code'      => 'login_success',
                    'message'   => 'User login successfuly.',
                    'token'     => $token
                ), 200);
            } else {
                return $this->failNotFound('User with that credential is not found');
            }
        } else {
            return $this->failNotFound('User with that credential is not found');
        }
    }

    /**
     * Register endpoint
     * 
     * @endpoint {base_url}/api/v1/user/signUp
     * @payload
     *  - full_name
     *  - address
     *  - birthday
     *  - phone_number
     *  - email
     *  - gender
     *  - username
     *  - password
     */
    public function signUp()
    {
        $data = $this->request->getJSON();

        $newUser = new UserEntity;
        $newUser->full_name     = $data->full_name;
        $newUser->address       = $data->address;
        $newUser->birthday      = $data->birthday;
        $newUser->phone_number  = $data->phone_number;
        $newUser->email         = $data->email;
        $newUser->gender        = $data->gender;
        $newUser->username      = $data->username;
        $newUser->password      = $data->password;

        // TODO: figure out what happen to openssl error tag decryption
        // $cryptedUsername = MyHelper::encryptUsername($newUser->username);
        // if ($cryptedUsername['status'] === \App\Constants\MyConstant::CHIPER_STATUS_FAIL) {
        //     return $this->fail($cryptedUsername['message']);
        // }

        $createdUser = $this->userModel->save($newUser);
        if ($createdUser === false) {
            return $this->fail($this->userModel->errors(), 400, 'validation_error', 'Validation Error');
        }

        unset($newUser->password);
        
        $encryptedUsername = \App\Helpers\CaesarCipher::encrypt($newUser->username);
        $verificationLink = base_url() . '/user/verification?user_info='.$encryptedUsername;

        $this->sendVerificationMail($verificationLink, $newUser->email, $newUser->full_name);

        return $this->respondCreated(array(
            'status'    => 201,
            'code'      => 'user_created',
            'data'      => $newUser,
            'message'   => 'You need to check your email first before you can use this account.'
        ));
    }

    /**
     * Logout endpoint
     */
    public function logout()
    {

    }

    public function forgotPassword()
    {
        
    }

    public function rememberMe()
    {

    }

    private function sendVerificationMail($link, $emailTo, $full_name)
    {
        $email = \Config\Services::email();

        $email->setFrom('no-replay@lebs.com', 'LEBS (Learn English By Subtitle)');
        $email->setTo($emailTo);
        $email->setSubject('LEBS User Verification');

        $data['link'] = $link;
        $data['full_name'] = $full_name;
        // print_r($data);die();

        $email->setMessage(view('email/verification', $data));

        $email->send();
    }

    private function debugResponse($val) {
        // header('Content-Type: application/json');
        echo "<pre>";
        print_r($val);die();
        echo "</pre>";
    }
}