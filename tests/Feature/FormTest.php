<?php


namespace Feature;


use Lighthouse\Contract\Form\Request;
use Mockery\MockInterface;
use Tests\Classes\SimpleForm;
use Tests\TestCase;

class FormTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        $mock = $this->mock(Request::class, function (MockInterface $mock) {
            $mock->shouldReceive('get')
                ->with('title')
                ->once()
                ->andReturn('hello-world');
        });
        $this->instance(Request::class, $mock);
    }

    public function test_it_should_handle_the_form()
    {
        $request = app()->make(Request::class);

        $simpleForm = new SimpleForm();
        $simpleForm->setName('simple');
        $simpleForm->build();
        $simpleForm->handle($request);

        $this->assertEquals('hello-world', $request->get('title'));
    }

}
