<?php

namespace App\Twig;

use App\Service\MarkdownHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    /**
     * @var MarkdownHelper
     */
    private $helper;

    public function __construct(MarkdownHelper $helper)
    {
        $this->helper = $helper;
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('cache_markdown', [$this, 'cacheMarkdown'], ['is_safe' => ['html']]),
        ];
    }

    public function cacheMarkdown($value)
    {
        return $this->helper->parse($value);
    }
}
