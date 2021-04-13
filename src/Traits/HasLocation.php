<?php


namespace Lighthouse\Laravel\Forms\Traits;


trait HasLocation
{

    protected $location = 'default';

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

}
