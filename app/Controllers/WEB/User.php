<?php namespace App\Controllers\WEB;

use App\Models\UserModel;
use App\Entities\UserEntity;
use CodeIgniter\HTTP\URI;
use App\Helpers\MyHelper;

class User extends \App\Controllers\BaseController
{

    public function verificationView()
    {
        $params     = $this->request->uri->getQuery();
        $userInfo  = MyHelper::getQueryValue($params, 'user_info');
        $decryptedUsername = \App\Helpers\CaesarCipher::decrypt($userInfo);
        echo $decryptedUsername;
    }

    public function emailTemplate()
    {
        echo view('email/verification', array('full_name' => 'Ahmad Jamil Al Rasyid', 'link' => 'https://www.google.com'));
    }

}