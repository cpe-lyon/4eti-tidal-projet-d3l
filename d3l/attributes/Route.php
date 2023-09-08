<?php

namespace AttributesRouter\Attribute;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Route {

    public const DEFAULT_REGEX = '[\w\-]+';

    private array $parameters = [];

    public function __construct(
        private string $path, 
        private string $name = '',
        private array $methods = ['GET']){

        if (empty($this->name)) {
            $this->name = $this->path;
        }
    }

    public function getPath(): string {
        return $this->path;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getMethods(): array {
        return $this->methods;
    }


    public function hasParams(): bool {
        return preg_match('/{([\w\-%]+)(<(.+)>)?}/', $this->path);
    }


    public function fetchParams(): array {
        if (empty($this->parameters)) {
            preg_match_all('/{([\w\-%]+)(?:<(.+?)>)?}/', $this->getPath(), $params);
            $this->parameters = array_combine($params[1], $params[2]);
        }

        return $this->parameters;
    }
}