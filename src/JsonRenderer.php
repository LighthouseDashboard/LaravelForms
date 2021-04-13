<?php


namespace Lighthouse\Laravel\Forms;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Lighthouse\Contract\Form\Element;
use Lighthouse\Contract\Form\Field;
use Lighthouse\Contract\Form\Form;
use Lighthouse\Contract\Form\Renderer;

class JsonRenderer implements Renderer
{

    /** @var array  */
    protected $appendData = [];

    /** @var array|\ArrayAccess|Model */
    protected $formData;

    public function process(Form $form)
    {
        $schema = [];

        if (count($form->getPath()) === 0) {
            $this->formData = $form->getData() ?? [];

            $schema = [
                'data' => $form->getData() ?? []
            ];
        }

        $fields = $form->getFields();
        $fields = collect($fields)
            ->map(fn (Element $field) => $this->processSingleField($field))
            ->groupBy(fn (array $item) => $item['location'] ?? 'default')
            ->map(function (Collection $items) {
                return $items
                    ->groupBy('group')
                    ->map(function (Collection $groupItems) {
                        return $groupItems->map(function (array $item) {
                            unset($item['group']);
                            unset($item['location']);
                            return $item;
                        });
                    });
            })
            ->toArray();

        $schema = array_merge($schema, [ 'fields' => $fields ]);

        if (count($form->getPath()) === 0) {
            $schema = array_merge($schema, [
                'append' => $this->appendData
            ]);
        }

        return $schema;
    }

    public function processField(Field $field): string
    {
        return '';
    }

    public function append(array $data): Renderer
    {
        $this->appendData = $data;
        return $this;
    }

    protected function processSingleField(Element $field): array {
        $payload = [
            'name' => $field->getName(),
            'group' => $field->getGroup()
        ];

        if ($field instanceof Field) {
            $fieldPath = $field->getPath();
            array_shift($fieldPath);
            array_push($fieldPath, $field->getName());
            $fieldPath = implode('.', $fieldPath);

            $payload = array_merge($payload, [
                'type' => $field->getType(),
                'location' => $field->getLocation(),
                'attributes' => $field->getAttributes(),
                'value' => Arr::get($this->formData, $fieldPath, null)
            ]);
        } elseif($field instanceof Form) {
            $payload = array_merge($payload, $this->process($field));
        }

        return $payload;
    }

}
