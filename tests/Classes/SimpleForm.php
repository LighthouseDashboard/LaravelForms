<?php


namespace Tests\Classes;


use Lighthouse\Laravel\Forms\Fields\TextField;

class SimpleForm extends \Lighthouse\Laravel\Forms\SimpleForm
{

    public function build()
    {
        $this->add(TextField::make('title'));
    }

}
