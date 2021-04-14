<?php


namespace Lighthouse\Laravel\Forms\Contracts;


interface OnCreateOrUpdate
{

    public function onCreateOrUpdate($parent): bool;

}
