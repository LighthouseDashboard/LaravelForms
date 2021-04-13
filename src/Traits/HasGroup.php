<?php


namespace Lighthouse\Laravel\Forms\Traits;


trait HasGroup
{

    protected $group = 'default';

    public function setGroup(string $group): self
    {
        $this->group = $group;
        return $this;
    }

    public function getGroup(): string
    {
        return $this->group;
    }

}
