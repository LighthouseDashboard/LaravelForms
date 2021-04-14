<?php


namespace Lighthouse\Laravel\Forms;


use App\Forms\ReviewForm;
use Illuminate\Support\Collection;
use Lighthouse\Contract\Form\Element;
use Lighthouse\Contract\Form\Field;
use Lighthouse\Contract\Form\Form;
use Lighthouse\Contract\Form\Renderer;
use Lighthouse\Contract\Form\Updatable;
use Lighthouse\Contract\Form\WithLocations;
use Lighthouse\Laravel\Forms\Contracts\BladeField;

class BladeRenderer implements Renderer
{

    protected $appends = [];

    public function process(Form $form)
    {
        $sections = collect($form->getFields())
            ->groupBy(fn (Element $element) => $element->getLocation())
            ->map(fn (Collection $items, string $name) => $this->mapSection($items, $name, $form));

        collect($form->getFields())
            ->filter(fn (Element $element) => $element instanceof BladeField)
            ->each(fn (BladeField $field) => $field->setData($form->getData()));

        $isRoot = count($form->getPath()) === 0;
        $viewName = $isRoot ? '@lighthouse-forms::form' : '@lighthouse-forms::section';

        return view($viewName, compact('form'))
            ->with('sections', $sections)
            ->with('renderer', $this)
            ->with('path', $form->getPath())
            ->with('isRoot', $isRoot)
            ->with($this->appends);
    }

    public function processField(Field $field)
    {
        if ($field instanceof BladeField) {
            $view = view($field->getViewName());
            $view = $field->buildView($view);

            return $view;
        }

        return get_class($field);
    }

    public function append(array $data): Renderer
    {
        $this->appends = $data;
        return $this;
    }

    protected function mapSection(Collection $items, string $name, Form $form): array
    {
        if ($form instanceof WithLocations) {
            $locations = $form->getLocationAttributes();
            return [
                'attributes' => $locations[$name] ?? [],
                'items' => $items
            ];
        }

        return [
            'items' => $items
        ];
    }

}
