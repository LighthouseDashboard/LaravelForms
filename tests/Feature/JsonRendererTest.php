<?php


namespace Tests\Feature;


use Tests\TestCase;
use Lighthouse\Laravel\Forms\JsonRenderer;
use Tests\Classes\SimpleForm;
use Tests\Classes\SimpleFormWithGroups;
use Tests\Classes\SimpleFormWithLocations;
use Tests\Classes\SimpleFormWithLocationsAndGroups;

class JsonRendererTest extends TestCase
{

    public function test_it_should_generate_basic_array()
    {
        $data = [
            'title' => 'hello-world'
        ];

        $form = new SimpleForm();
        $form->setData($data);
        $form->setName('simple');
        $form->build();

        $expectedData = [
            'data' => [
                'title' => 'hello-world'
            ],
            'fields' => [
                'default' => [
                    'default' => [
                        [
                            'name' => 'title',
                            'type' => 'text',
                            'attributes' => [],
                            'value' => 'hello-world',
                        ]
                    ]
                ]
            ],
            'append' => []
        ];

        $renderer = new JsonRenderer();
        $data = $renderer->process($form);

        $this->assertEquals($expectedData, $data);
    }

    public function test_it_should_group_by_groups()
    {
        $form = new SimpleFormWithGroups();
        $form->setName('simple');
        $form->build();

        $expectedData = [
            'data' => [  ],
            'fields' => [
                'default' => [
                    'default' => [
                        [
                            'name' => 'title',
                            'type' => 'text',
                            'attributes' => [],
                            'value' => null,
                        ]
                    ],
                    'other-group' => [
                        [
                            'name' => 'slug',
                            'type' => 'text',
                            'attributes' => [],
                            'value' => null,
                        ]
                    ]
                ]
            ],
            'append' => []
        ];

        $renderer = new JsonRenderer();
        $data = $renderer->process($form);

        $this->assertEquals($expectedData, $data);
    }

    public function test_it_should_group_by_locations()
    {
        $form = new SimpleFormWithLocations();
        $form->setName('simple');
        $form->build();

        $expectedData = [
            'data' => [  ],
            'fields' => [
                'default' => [
                    'default' => [
                        [
                            'name' => 'title',
                            'type' => 'text',
                            'attributes' => [],
                            'value' => null,
                        ]
                    ]
                ],
                'other-location' => [
                    'default' => [
                        [
                            'name' => 'slug',
                            'type' => 'text',
                            'attributes' => [],
                            'value' => null,
                        ]
                    ],
                ]
            ],
            'append' => []
        ];

        $renderer = new JsonRenderer();
        $data = $renderer->process($form);

        $this->assertEquals($expectedData, $data);
    }

    public function test_it_should_group_by_locations_and_groups()
    {
        $form = new SimpleFormWithLocationsAndGroups();
        $form->setName('simple');
        $form->build();

        $expectedData = [
            'data' => [  ],
            'fields' => [
                'default' => [
                    'default' => [
                        [
                            'name' => 'title',
                            'type' => 'text',
                            'attributes' => [],
                            'value' => null,
                        ]
                    ]
                ],
                'other-location' => [
                    'other-group' => [
                        [
                            'name' => 'slug',
                            'type' => 'text',
                            'attributes' => [],
                            'value' => null,
                        ]
                    ],
                ]
            ],
            'append' => []
        ];

        $renderer = new JsonRenderer();
        $data = $renderer->process($form);

        $this->assertEquals($expectedData, $data);
    }

}
