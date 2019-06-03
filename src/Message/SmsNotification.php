<?php

namespace App\Message;


class SmsNotification
{
    private $content;
    /**
     * @var array
     */
    private $params;

    public function __construct(string $content, array $params)
    {
        $this->content = $content;
        $this->params = $params;
    }

    public function getContent():string
    {
        return $this->content;
    }

    public function getParams():array
    {
        return $this->params;
    }

}