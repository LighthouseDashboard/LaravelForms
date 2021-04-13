<?php


namespace Lighthouse\Laravel\Forms\Traits;


use App\Forms\ReviewForm;
use Illuminate\Database\Eloquent\Model;
use Lighthouse\Contract\Form\HandleRequest;
use Lighthouse\Contract\Form\Request;
use Lighthouse\Contract\Form\UpdateAfterSave;

/**
 * Trait Updatable
 * @package Lighthouse\Laravel\Forms\Traits
 *
 * @property Model $data
 * @method getFields(): array
 * @method getDefaultData(): Model
 */
trait Updatable
{

    public function update(Request $request, $data): self
    {
        if ($this->data === null) {
            $this->data = $this->getDefaultData($data);
        }

        $fields = collect($this->getFields());

        $fields
            ->filter(fn ($element) => $element instanceof HandleRequest)
            ->filter(fn ($element) => !($element instanceof UpdateAfterSave))
            ->each(fn (HandleRequest $element) => $element->handle($request, $this->data));

        if ($this->data instanceof Model) {
            $this->data->save();
        }

        $fields
            ->filter(fn ($element) => $element instanceof HandleRequest)
            ->filter(fn ($element) => $element instanceof UpdateAfterSave)
            ->each(fn (HandleRequest $element) => $element->handle($request, $this->data));

        return $this;
    }
    
}
