<?php

namespace Lighthouse\Laravel\Forms\Traits;

trait HasPath
{

    protected $path = [];

    public function getPath(): array
    {
        return $this->path;
    }

    public function setPath(array $path): self
    {
        $this->path = $path;
        return $this;
    }

}
