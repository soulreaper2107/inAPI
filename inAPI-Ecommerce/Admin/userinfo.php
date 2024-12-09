<?php
class UserInfo {
    private $encryptionKey;
    private $salt;

    public function __construct() {
        $this->encryptionKey = "your-encryption-key"; 
        $this->salt = "your-salt";
    }

    public function encryptUserInfo($data) {
        $saltedData = $data . $this->salt;
        $encryptedData = openssl_encrypt($saltedData, 'AES-256-CBC', $this->encryptionKey, 0, $this->generateIv());
        return $encryptedData;
    }


    public function decryptUserInfo($encryptedData) {
        $decryptedData = openssl_decrypt($encryptedData, 'AES-256-CBC', $this->encryptionKey, 0, $this->generateIv());
        return rtrim($decryptedData, $this->salt);
    }

    private function generateIv() {
        return openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
    }

    public function getUserInfo($userData) {
        $encryptedUsername = $this->encryptUserInfo($userData['username']);
        $encryptedEmail = $this->encryptUserInfo($userData['email']);
        $encryptedPassword = $this->encryptUserInfo($userData['password']);
        $encryptedAddress = $this->encryptUserInfo($userData['address']);

        return [
            'username' => $encryptedUsername,
            'email' => $encryptedEmail,
            'password' => $encryptedPassword,
            'address' => $encryptedAddress
        ];
    }
}

$userInfo = new UserInfo();
$userData = [
    'username' => 'john_doe',
    'email' => 'john@example.com',
    'password' => 'securepassword',
    'address' => '1234 Elm Street'
];

$encryptedUser = $userInfo->getUserInfo($userData);
print_r($encryptedUser);
?>
