<?php
class Encryption {
    private $method = 'aes-256-cbc';
    private $key;
    private $iv;

    public function __construct($key) {
        $this->key = $key;
        $this->iv = substr(sha1($key), 0, 16);
    }

    public function encrypt($data) {
        return openssl_encrypt($data, $this->method, $this->key, 0, $this->iv);
    }

    public function decrypt($data) {
        return openssl_decrypt($data, $this->method, $this->key, 0, $this->iv);
    }

    public function hashPassword($password, $salt) {
        return hash('sha256', $password . $salt);
    }
}
