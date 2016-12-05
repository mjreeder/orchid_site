<?php

 class Message{

    public function __construct(Tamarin $master) {
        $this->master = $master;
    }

    public function send($message, $async = false, $ip_pool = null, $send_at = null) {
        $params = array("message" => $message, "async" => $async, "ip_pool" => $ip_pool, "send_at" => $send_at);
        $url = 'https://apso.bsu.edu/2016/email_service/public/api/v1/email/send';
        return $this->master->call($url, $params);
    }
}
