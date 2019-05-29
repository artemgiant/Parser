<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 28.05.2019
 * Time: 15:38
 */

class Parser
{
    private $url;
    private $ch;

    public function __construct($url,$print = false)
    {
        $this->url = $url;
        $this->ch = curl_init();
        curl_exec($this->ch);
        if (!$print) {
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        }
    }

    public function set($name, $value)
    {
        curl_setopt($this->ch, $name, $value);
        return $this;
    }

    public function exec()
    {
        curl_setopt($this->ch, CURLOPT_URL, $this->url);
         return curl_exec($this->ch);

    }


}