<?php


namespace Tests\Classes;


use Lighthouse\Laravel\Forms\Fields\TextField;

class SimpleFormWithGroups extends \Lighthouse\Laravel\Forms\SimpleForm
{

    public function build()
    {
        $this
            ->add(TextField::make('title'))
            ->add(TextField::make('slug')->setGroup('other-group'));
    }

}
