<?php

class FlarumTeach
{
    const REMEMBER_ME_KEY = 'flarum_remember';
    private $config;

    public function __construct()
    {  // Modificare con il percorso al config.php
        $this->config = require '/home/mathe/www/forum_login/teacher/config.php';
    }

    public function login($username, $email, $password)
    {

        $token = $this->getToken($username, $password);

        return $this->setRememberCookie($token);
    }


  /*  public function logout()
    {
        $this->removeCookie();
    } */


    public function redirectToForum()
    {
        header('Location: ' . $this->config->flarum_url);
        die();
    }

    public function getForumLink() {

        return $this->config->flarum_url;
    }

    private function getToken($username, $password)
    {
        $data = [
            'identification' => $username,
            'password' => $password,
            'lifetime' => $this->getLifetimeSeconds(),
        ];

        $response = $this->sendRequest('/api/token', $data);

        return isset($response['token']) ? $response['token'] : '';
    }

    private function sendRequest($path, $data=[], $method='POST')
    {

        $options = [
            'http' => [
                'header'  => 'Authorization: Token ' . $this->config->flarum_api_key . '; userId=4',
                'method'  => $method,
                'content' => http_build_query($data),
                'ignore_errors' => true
            ]
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($this->config->flarum_url . $path, false, $context);
        return json_decode($result, true);
    }

    private function setRememberCookie($token)
    {
        return $this->setcookie(self::REMEMBER_ME_KEY, $token, time() + $this->getLifetimeSeconds());
    }

    private function removeCookie()
    {
        unset($_COOKIE[self::REMEMBER_ME_KEY]);
        return $this->setCookie(self::REMEMBER_ME_KEY, '', time() - 10);
    }

    private function setCookie($key, $token, $time)
    {
        return setCookie($key, $token, $time, '/', $this->config->root_domain);
    }

    private function getLifetimeSeconds()
    {
        return $this->config->lifetime_in_days * 60 * 60 * 24;
    }
}
