<?php


namespace Lighthouse\Laravel\Forms\Traits;


use Illuminate\Database\Eloquent\Model;
use Lighthouse\Contract\Form\Request;

/**
 * Trait HandleRequest
 * @package Lighthouse\Laravel\Forms\Traits
 *
 * @method getFields(): array
 */
trait HandleRequest
{

    /**
     * @param Request $request
     * @param $data
     * @return array|\ArrayAccess|Model
     */
    public function handle(Request $request, $data)
    {
        if ($this->requestObject !== null) {
            $laravelRequest = app()->make($this->requestObject);
        }

        if ($this instanceof \Lighthouse\Contract\Form\Updatable) {
            $this->update($request, $data);
            return $data;
        }

        $fields = collect($this->getFields());
        return $fields
            ->filter(fn ($element) => $element instanceof \Lighthouse\Contract\Form\HandleRequest)
            ->reduce(fn ($acc, \Lighthouse\Contract\Form\HandleRequest $element) => $element->handle($request, $acc), $data);
    }

}
