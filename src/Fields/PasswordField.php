<?php


namespace Lighthouse\Laravel\Forms\Fields;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Lighthouse\Contract\Form\Request;
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

    public function handle(Request $request, $data)
    {
        $fullPath = $this->getFieldPathInRequest();
        $updatedValue = bcrypt($request->input($fullPath));

        if ($data instanceof Model) {
            $data->{$this->getName()} = $updatedValue;
        } else {
            Arr::set($data, $fullPath, $updatedValue);
        }

        return $data;
    }


}
