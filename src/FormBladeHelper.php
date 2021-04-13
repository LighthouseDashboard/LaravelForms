<?php


namespace Lighthouse\Laravel\Forms;


use Lighthouse\Contract\Form\Element;
use Lighthouse\Contract\Form\Form;
use Lighthouse\Contract\Form\Renderer;

class FormBladeHelper
{

    /** @var Form|null */
    protected ?Form $form = null;

    /** @var Renderer|null */
    protected ?Renderer $renderer = null;

    /**
     * FormBladeHelper constructor.
     * @param Form $form
     * @param Renderer $renderer
     */
    public function __construct(Form $form, Renderer $renderer)
    {
        $this->form = $form;
        $this->renderer = $renderer;
    }

    public function render(): string
    {
        return $this->renderer->process($this->form)->render();
    }

    public function field($fieldName)
    {
        $field = collect($this->form->getFields())
            ->first(fn (Element $element) => $element->getName() === $fieldName);

        if ($field instanceof Form) {
            return $this->renderer->process($field);
        }

        return $this->renderer->processField($field);
    }

}
