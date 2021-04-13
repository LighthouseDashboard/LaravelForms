<?php


namespace Lighthouse\Laravel\Forms\Fields;


use Lighthouse\Laravel\Forms\Contracts\BladeField;
use Lighthouse\Laravel\Forms\Traits\SimpleViewBuilder;

class PasswordField extends SimpleField implements BladeField
{

    use SimpleViewBuilder;

    protected $type = 'password';

    public function getViewName(): string
    {
        return '@lighthouse-forms::fields.password';
    }

}
