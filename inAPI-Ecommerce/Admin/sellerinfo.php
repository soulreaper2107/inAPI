<?php
class SellerInfo {
    private $encryptionKey;
    private $salt;

    public function __construct() {
        $this->encryptionKey = "your-encryption-key";
        $this->salt = "your-salt";
    }

    public function encryptSellerInfo($data) {
        $saltedData = $data . $this->salt;
        $encryptedData = openssl_encrypt($saltedData, 'AES-256-CBC', $this->encryptionKey, 0, $this->generateIv());
        return $encryptedData;
    }


    public function decryptSellerInfo($encryptedData) {
        $decryptedData = openssl_decrypt($encryptedData, 'AES-256-CBC', $this->encryptionKey, 0, $this->generateIv());
        return rtrim($decryptedData, $this->salt);
    }

    private function generateIv() {
        return openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
    }

    public function getSellerInfo($sellerData) {
        $encryptedUsername = $this->encryptSellerInfo($sellerData['username']);
        $encryptedEmail = $this->encryptSellerInfo($sellerData['email']);
        $encryptedPassword = $this->encryptSellerInfo($sellerData['password']);
        $encryptedAddress = $this->encryptSellerInfo($sellerData['address']);


        return [
            'username' => $encryptedUsername,
            'email' => $encryptedEmail,
            'password' => $encryptedPassword,
            'address' => $encryptedAddress
        ];
    }
}

$sellerInfo = new SellerInfo();
$sellerData = [
    'username' => 'seller_john',
    'email' => 'seller@example.com',
    'password' => 'sellerspassword',
    'address' => '5678 Oak Avenue'
];

$encryptedSeller = $sellerInfo->getSellerInfo($sellerData);
print_r($encryptedSeller);
?>
