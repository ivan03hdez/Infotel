<?php
    class Encrypt {
        private $key;
        private $ciphering;
        private $iv_length;
        private $options;
        private $encryption_iv;
        private $encryption_key;
        private $decryption_iv;
        private $decryption_key;

        public function __construct() {
            $this->key = 'Infotel';
            $this->ciphering = "AES-128-CTR";
            $this->iv_length = openssl_cipher_iv_length($this->ciphering);
            $this->options = 0;
            $this->encryption_iv = substr(hash('sha256', $this->key), 0, $this->iv_length);
            $this->encryption_key = openssl_digest(php_uname(), 'MD5', TRUE);
            $this->decryption_iv = substr(hash('sha256', $this->key), 0, $this->iv_length);
            $this->decryption_key = openssl_digest(php_uname(), 'MD5', TRUE);
        }


        public function encryptData($data) {
            $encrypted = openssl_encrypt($data, $this->ciphering, $this->encryption_key, $this->options, $this->encryption_iv);
            return $encrypted;
        }

        public function decryptData($encrypted) {
            $decrypted = openssl_decrypt($encrypted, $this->ciphering, $this->decryption_key, $this->options, $this->decryption_iv);
            return $decrypted;
        }
}
?>