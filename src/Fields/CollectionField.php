<?php


namespace Lighthouse\Laravel\Forms\Fields;


use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Lighthouse\Contract\Form\Element;
use Lighthouse\Contract\Form\Form;
use Lighthouse\Contract\Form\HandleRequest;
use Lighthouse\Contract\Form\Request;
use Lighthouse\Contract\Form\Updatable;
use Lighthouse\Laravel\Forms\Contracts\BladeField;
use Lighthouse\Laravel\Forms\Traits\SimpleViewBuilder;

/**
 * Class CollectionField
 * @package Lighthouse\Laravel\Forms\Fields
 *
 * @method static CollectionField make(string $name)
 */
class CollectionField extends SimpleField implements BladeField
{

    use SimpleViewBuilder;

    /** @var string */
    protected string $childElement;

    public function getViewName(): string
    {
        return '@lighthouse-forms::fields.collection';
    }

    public function buildView(View $view): View
    {
        $parameters = $this->getViewParameters();
        $parameters = array_merge([
            'field' => $this
        ], $parameters);

        return $view->with($parameters);
    }

    public function handle(Request $request, $data)
    {
        $path = [...$this->getPath(), $this->getName()];
        array_shift($path);
        $path = implode('.', $path);

        $items = $request->input($path);

        foreach ($items as $key => $item) {
            /** @var Element $element */
            $element = app()->make($this->childElement);
            $itemPath = [...$this->getPath(), $this->getName()];
            $element->setPath($itemPath);
            $element->setName($key);

            if ($element instanceof Form) {
                $element->build();
            }

            if ($element instanceof BladeField || $element instanceof Form) {
                $element->setData($item);
            }

            if ($element instanceof HandleRequest) {
                $element->handle($request, $data);
            }
        }
    }

    public function items()
    {
        $items = $this->data instanceof Model
            ? $this->data->{$this->getName()}
            : Arr::get($this->data, $this->getName());

        foreach ($items as $key => $item) {
            /** @var Element $element */
            $element = app()->make($this->childElement);
            $itemPath = [...$this->getPath(), $this->getName()];
            $element->setPath($itemPath);
            $element->setName($key);

            if ($element instanceof Form) {
                $element->build();
            }

            if ($element instanceof BladeField || $element instanceof Form) {
                $element->setData($item);
            }

            yield $element;
        }
    }

    /**
     * @return string
     */
    public function getChildElement(): string
    {
        return $this->childElement;
    }

    /**
     * @param string $childElement
     * @return CollectionField
     */
    public function setChildElement(string $childElement): self
    {
        $this->childElement = $childElement;

        return $this;
    }

}
