<?php


namespace Themes\labo\src;

use Themes\labo\src\Repository\TermsRepository;

class TermsFilter
{

    private $context;
    private $repository;
    public $tags;

    public function __construct($context, string $tagType)
    {
        $this->context = $context;
        $this->repository = new TermsRepository;
        $this->tags = $this->repository->getAllTagsByType($tagType);
    }

    public function setSelectItems(?string $slug, string $defaultValue): array
    {
        $selectItems['active'] = $slug ? $slug : 'all';
        foreach ($this->tags as $k => $tag) {
            $selectItems[$tag['slug']] = $tag['name'];
        }
        $selectItems['all'] = $defaultValue;
        return $selectItems;
    }

    public function formatTermsArray(): array
    {
        $output = [];
        foreach ($this->tags as $tag) {
            $output[$tag['slug']] = $tag['name'];
        }
        return array_merge(['all' => 'Tous'], $output);
    }
}
