<?php namespace App\Controllers\API;

use App\Controllers\BaseController;

class Test extends BaseController
{
    use \CodeIgniter\API\ResponseTrait;

    public function sendMail()
    {
        $email  = \Config\Services::email();

        $email->setFrom('jamil@dwebsite.net', 'Jamil Dwebsite');
        $email->setTo('rasyidcode7@gmail.com', 'Jamil Rasyidcode');
        $email->setSubject('Send Email Test CI 4');
        $email->setMessage('This is only for testing');

        if ($email->send()) {
            echo 'sent';
        } else {
            echo 'not sent';
        }
    }

    public function test()
    {
        return $this->respond(array(
            'message' => 'This is a test'
        ), 200);
    }

    public function testRoute() {
        return $this->respond(array(
            'message' => 'This is a testRoute'
        ), 200);
    }

    public function testCaesarCipherEncrypt()
    {
        $text = 'rasyidcode';
        return $this->respond(array(
                'crypted_text' => \App\Helpers\CaesarCipher::encrypt($text)
            )
        );
    }

    public function testCaesarCipherDecrypt()
    {
        $text = 'xvhuwhvw2';
        return $this->respond(array(
            'decrypted_text' => \App\Helpers\CaesarCipher::decrypt($text)
        ));
    }

    public function testChiperAlgorithm()
    {
        return $this->respond(array(
            'step_1' => ord('a'),
            'step_2' => ord('a') - 3,
            'step_3' => ord('a') - 3 - 97,
            'step_4' => (ord('a') - 3 - 97) % 26,
            'step_5' => (ord('a') - 3 - 97) % 26 + 97,
            'step_6' => chr((ord('a') - 3 - 97) % 26 + 97),
            'test_1' => chr(97),
            'test_2' => chr(97 + 25),
            'test_3' => chr((ord('z') + 3 - 97) % 26 + 97),
            'encrypt'   => array(
                'step_1' => ord('z'),
                'step_2' => ord('z') + 3,
                'step_3' => ord('z') + 3 - 97,
                'step_4' => (ord('z') + 3 - 97) % 26,
                'step_5' => (ord('z') + 3 - 97) % 26 + 97,
            ),
            'decrypt'   => array(
                'step_1' => ord('a'),
                'step_2' => ord('a') - 3,
                'step_3' => ord('a') - 3 - 122,
                'step_4' => (ord('a') - 3 - 122) % 26,
                'step_5' => (ord('a') - 3 - 122) % 26 + 122,
            ),
            'test_4' => chr(65 + 25)
        ));
        return chr(((ord('a') - 3) - 97) % 26 + 97);
    }

    public function testDecryptUsernameFromEmail()
    {
        $encryptedUsername = 'Itrx3XLnCHEt';
        return $this->respond(array(
            'result' => \App\Helpers\MyHelper::decryptUsername($encryptedUsername)
        ));
    }

    public function testEnvironment()
    {
        return $this->respond(array(
            'result' => getenv('CI_ENVIRONMENT')
        ));
    }

}