<?php namespace App\Helpers;

use App\Constants\MyConstant;

class MyHelper {

    /**
     * simple query value getter
     * 
     * @param string $paramStr
     * @param string $key
     * 
     * @return string|null
     */
    public static function getQueryValue(string $paramStr, string $key)
    {
        $params = explode('&', $paramStr);
        
        foreach($params as $param) {
            if (strpos($param, $key) !== false) {
                return explode('=', $param)[1];
            }
        }

        return null;
    }

    /**
     * simple userInfo encryption that we will send to email
     * 
     * @param int $userId
     * 
     * @return array
     */
    public static function encryptUserId(int $userId)
    {
        $result = array();

        try {
            if (\in_array(MyConstant::CHIPER_METHOD, openssl_get_cipher_methods())) {
                $simpleHashedId = ($userId + 10) * 99;
                $tag = MyConstant::CHIPER_TAG;
                $result['status'] = MyConstant::CHIPER_STATUS_OK;
                $result['secret'] = \openssl_encrypt(
                    $simpleHashedId, 
                    MyConstant::CHIPER_METHOD, 
                    MyConstant::CHIPER_KEY, 
                    $options=0,
                    MyConstant::CHIPER_IV, 
                    $tag);
            } else {
                throw new \Exception("Chiper method not found.");
            }
        } catch(\Exception $e) {
            $result['status'] = MyConstant::CHIPER_STATUS_FAIL;
            $result['message'] = $e->getMessage();
        }

        return $result;
    }

    /**
     * simple username encryption to sent to email
     * 
     * @param string $username
     * 
     * @return array
     */
    public static function encryptUsername(string $username)
    {
        $result = array();

        try {
            $caesarCipherHash = \App\Helpers\CaesarCipher::encrypt($username);
            $tag = MyConstant::CHIPER_TAG;
                $result['status'] = MyConstant::CHIPER_STATUS_OK;
                $result['secret'] = \openssl_encrypt(
                    $caesarCipherHash, 
                    MyConstant::CHIPER_METHOD, 
                    MyConstant::CHIPER_KEY, 
                    $options=0,
                    MyConstant::CHIPER_IV, 
                    $tag);
        } catch(\Exception $e) {
            $result['status'] = MyConstant::CHIPER_STATUS_FAIL;
            $result['message'] = $e->getMessage();
        }

        return $result;
    }

    /**
     * simple userInfo decryption
     * 
     * @param string $crypticUserInfo
     * 
     * @return array
     */
    public static function decryptUserId(string $cryptedUserId)
    {
        $result = array();

        try {
            if (\in_array(MyConstant::CHIPER_METHOD, openssl_get_cipher_methods())) {
                $tag = MyConstant::CHIPER_TAG;
                $simpleHashedId = \openssl_decrypt(
                    $cryptedUserId, 
                    MyConstant::CHIPER_METHOD, 
                    MyConstant::CHIPER_KEY, 
                    $options=0, 
                    MyConstant::CHIPER_IV, 
                    $tag);
                
                $result['status'] = MyConstant::CHIPER_STATUS_OK;
                $result['userId'] = ($simpleHashedId / 99) - 10;
            } else {
                throw new \Exception('Chiper method not found.');
            }
        } catch(\Exception $e) {
            $result['status'] = MyConstant::CHIPER_STATUS_FAIL;
            $result['message'] = $e->getMessage();
        }

        return $result;
    }

    /**
     * simple username decryption
     * 
     * @param string $cryptedUsername
     * 
     * @return array
     */
    public static function decryptUsername(string $cryptedUsername)
    {
        $result = array();

        try {
            if (\in_array(MyConstant::CHIPER_METHOD, openssl_get_cipher_methods())) {
                $tag = MyConstant::CHIPER_TAG;
                $hashedUsername = \openssl_decrypt(
                    $cryptedUsername, 
                    MyConstant::CHIPER_METHOD, 
                    MyConstant::CHIPER_KEY, 
                    $options=0, 
                    MyConstant::CHIPER_IV, 
                    $tag);
                
                $result['status'] = MyConstant::CHIPER_STATUS_OK;
                $result['username'] = \App\Helpers\CaesarCipher::decrypt($hashedUsername);
            } else {
                throw new \Exception('Chiper method not found.');
            }
        } catch(\Exception $e) {
            $result['status'] = MyConstant::CHIPER_STATUS_FAIL;
            $result['message'] = $e->getMessage();
        }

        return $result;
    }

    public static function randomizeUsername()
    {
        // TODO: random username, email and phone_number
        // TODO: return one of them
    }

} 