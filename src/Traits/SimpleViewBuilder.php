<?php

namespace Lighthouse\Laravel\Forms\Traits;


use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Trait SimpleViewBuilder
 * @package Lighthouse\Laravel\Forms\Traits
 * @method getName(): string
 * @method getPath(): array
 */
trait SimpleViewBuilder
{

    protected $data = null;

    public function setData($data)
    {
        $this->data = $data;
    }

    public function buildView(View $view): View
    {
        $parameters = $this->getViewParameters();

        return $view->with($parameters);
    }

    public function getViewParameters()
    {
        $name = $this->getName();
        $path = [...$this->getPath()];
        array_shift($path);

        $fullName = [...$path];
        array_push($fullName, $name);
        $fieldId = implode('.', $fullName);

        $fullNameBuilder = array_shift($fullName);
        foreach ($fullName as $namePart) {
            $fullNameBuilder .= '[' . $namePart . ']';
        }

        $value = $this->data instanceof Model ? $this->data->{$name} : Arr::get($this->data, $name);

        return [
            'full_name' => $fullNameBuilder,
            'name' => $name,
            'id' => $fieldId,
            'data' => $this->data,
            'path' => $path,
            'value' => $value
        ];
    }

}
