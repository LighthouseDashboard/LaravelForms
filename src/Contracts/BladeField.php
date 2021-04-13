<?php


namespace Lighthouse\Laravel\Forms\Contracts;



use Illuminate\Contracts\View\View;

interface BladeField
{

    public function setData($data);

    public function getViewName(): string;

    public function buildView(View $view): View;

}
