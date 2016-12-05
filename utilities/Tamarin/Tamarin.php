<?php

require_once 'Message.php';

class Tamarin{

    public $apikey;
    public $messages;
    public $debug = false;

    public function __construct($apikey = null)
    {
        $this->apikey = $apikey ? $apikey : "";
        $this->messages = new Message($this);
    }

    public function call($url, $params) {
        $params['api_key'] = $this->apikey;
        $params = json_encode($params);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 600);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_VERBOSE, $this->debug);

        $start = microtime(true);
        $this->log('Call to ' . $url . $params);
        if($this->debug) {
            $curl_buffer = fopen('php://memory', 'w+');
            curl_setopt($curl, CURLOPT_STDERR, $curl_buffer);
        }

        $response_body = curl_exec($curl);
        $info = curl_getinfo($curl);
        $time = microtime(true) - $start;
        if($this->debug) {
            rewind($curl_buffer);
            $this->log(stream_get_contents($curl_buffer));
            fclose($curl_buffer);
        }
        $this->log('Completed in ' . number_format($time * 1000, 2) . 'ms');
        $this->log('Got response: ' . $response_body);

        if(curl_error($curl)) {
            throw new Exception("API call to $url failed: " . curl_error($curl));
        }

        if(floor($info['http_code'] / 100) >= 4) {
            throw $this->cast_error($result);
        }
        return $response_body;
    }

    public function log($msg) {
        if($this->debug) error_log($msg);
    }

    public function cast_error($result) {
        if($result['status'] !== 'error' || !$result['name']) throw new Exception('We received an unexpected error: ' . json_encode($result));

        $class = (isset(self::$error_map[$result['name']])) ? self::$error_map[$result['name']] : 'Error';
        return new $class($result['message'], $result['code']);
    }

}
