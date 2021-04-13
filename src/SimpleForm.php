<?php


namespace Lighthouse\Laravel\Forms;


use Lighthouse\Contract\Form\{Element, HandleRequest, Form, Updatable, WithLocations};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Lighthouse\Laravel\Forms\Traits\HasGroup;
use Lighthouse\Laravel\Forms\Traits\HasLocation;
use Lighthouse\Laravel\Forms\Traits\HasName;
use Lighthouse\Laravel\Forms\Traits\HasPath;
use Lighthouse\Laravel\Forms\Traits\HandleRequest as HandleRequestTrait;

abstract class SimpleForm implements Form, HandleRequest
{

    use HasPath;
    use HasName;
    use HasGroup;
    use HasLocation;
    use HandleRequestTrait;

    protected $requestObject = null;

    /** @var Element[] */
    protected $fields = [];

    /** @var mixed */
    protected $data = null;

    public function __construct()
    {
        $this->fields = collect();
    }

    public function add(Element $field): Form
    {
        $path = array_merge($this->getPath());
        array_push($path, $this->getName());

        $field->setPath($path);
        $this->fields->push($field);

        if ($field instanceof Form) {
            $field->build();
        }

        return $this;
    }

    public function setData($data): Form
    {
        $this->data = $data;

        foreach ($this->fields as $field) {
            if ($field instanceof Form && $field instanceof Updatable) {
                $name = $field->getName();
                $value = $data instanceof Model ? $data->{$name} : Arr::get($data, $name);

                if ($value === null) {
                    $value = $field->getDefaultData($data);
                }

                $field->setData($value);
            }
        }

        return $this;
    }


    public function getFields(): array
    {
        return $this->fields->toArray();
    }

    public function getData()
    {
        return $this->data;
    }

}
