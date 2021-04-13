<?php


namespace Lighthouse\Laravel\Forms\Fields;


use Lighthouse\Contract\Form\{Field, HandleRequest, Renderer, Request};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Lighthouse\Laravel\Forms\Traits\HasGroup;
use Lighthouse\Laravel\Forms\Traits\HasLocation;
use Lighthouse\Laravel\Forms\Traits\HasName;
use Lighthouse\Laravel\Forms\Traits\HasPath;

abstract class SimpleField implements Field, HandleRequest
{

    use HasPath;
    use HasName;
    use HasLocation;
    use HasGroup;

    /** @var string */
    protected $type = null;

    public static function make(string $name)
    {
        $className = get_called_class();
        /** @var Field $field */
        $field = new $className();
        $field->setName($name);

        return $field;
    }

    /**
     * @param Request $request
     * @param $data
     * @return array|\ArrayAccess|Model
     */
    public function handle(Request $request, $data)
    {
        $fullPath = $this->getFieldPathInRequest();
        $updatedValue = $request->input($fullPath);

        if ($data instanceof Model) {
            $data->{$this->getName()} = $updatedValue;
        } else {
            Arr::set($data, $fullPath, $updatedValue);
        }

        return $data;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Field
    {
        $this->name = $name;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAttributes(): array
    {
        return [];
    }

    protected function getFieldPathInRequest(): string
    {
        $fullPath = [ ...$this->path, $this->getName() ];
        array_shift($fullPath);
        return implode('.', $fullPath);
    }

}
