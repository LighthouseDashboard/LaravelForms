<?php


namespace Lighthouse\Laravel\Forms\Fields;


use Lighthouse\Contract\Form\Request;
use Lighthouse\Laravel\Forms\Contracts\BladeField;
use Lighthouse\Laravel\Forms\Traits\SimpleViewBuilder;

class SubmitField extends SimpleField implements BladeField
{

    use SimpleViewBuilder;

    public function getViewName(): string
    {
        return '@lighthouse-forms::fields.submit';
    }

    public function handle(Request $request, $data)
    {
        return $data;
    }

}
