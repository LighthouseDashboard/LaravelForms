<?php


namespace Tests\Classes;


use Lighthouse\Laravel\Forms\Fields\TextField;

class SimpleFormWithLocations extends \Lighthouse\Laravel\Forms\SimpleForm
{

    public function build()
    {
        $this
            ->add(TextField::make('title'))
            ->add(TextField::make('slug')->setLocation('other-location'));
    }

}
