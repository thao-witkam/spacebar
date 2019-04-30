<?php

namespace App\Service;

use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;

class MarkdownHelper
{
    private $markdown;
    private $cache;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(MarkdownInterface $markdown, CacheInterface $cache, LoggerInterface $markdownLogger)
    {
        $this->cache = $cache;
        $this->markdown = $markdown;
        $this->logger = $markdownLogger;
    }

    public function parse(string $source):string
    {
        if(strpos($source, 'bacon')){
            $this->logger->info('they are talking about bacon again!');
        }

        $item = $this->cache->getItem('markdown_', md5($source));
        if(!$item->isHit()){
            $item = $item->set($this->markdown->transform($source));
            $this->cache->save($item);
        }
        return $item->get();
    }

}