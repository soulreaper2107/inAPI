<?php
class PaymentInfo {
    private $encryptionKey;
    private $salt;

    public function __construct() {
        $this->encryptionKey = "your-encryption-key"; 
        $this->salt = "your-salt"; 
    }

        public function encryptPaymentInfo($data) {
        $saltedData = $data . $this->salt;
        $encryptedData = openssl_encrypt($saltedData, 'AES-256-CBC', $this->encryptionKey, 0, $this->generateIv());
        return $encryptedData;
    }

    public function decryptPaymentInfo($encryptedData) {
        $decryptedData = openssl_decrypt($encryptedData, 'AES-256-CBC', $this->encryptionKey, 0, $this->generateIv());
        return rtrim($decryptedData, $this->salt);
    }

    private function generateIv() {
        return openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
    }

    public function getPaymentInfo($paymentData) {
        $encryptedAmount = $this->encryptPaymentInfo($paymentData['amount']);
        $encryptedCardNumber = $this->encryptPaymentInfo($paymentData['card_number']);

        return [
            'amount' => $encryptedAmount,
            'card_number' => $encryptedCardNumber
        ];
    }
}


$paymentInfo = new PaymentInfo();
$paymentData = [
    'amount' => '100.50',
    'card_number' => '4111111111111111'
];

$encryptedPayment = $paymentInfo->getPaymentInfo($paymentData);
print_r($encryptedPayment);
?>
