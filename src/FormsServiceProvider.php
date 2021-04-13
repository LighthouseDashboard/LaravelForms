<?php


namespace Lighthouse\Laravel\Forms;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Lighthouse\Contract\Form\Form;
use Lighthouse\Contract\Form\Renderer;
use Lighthouse\Contract\Form\Request;

class FormsServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', '@lighthouse-forms');

        Blade::directive('form', function ($form) {
            View::share('renderer', app()->make(Renderer::class));

            return "<?php echo \$renderer->process($form); ?>";
        });

        Blade::directive('formField', function (string $fieldName, Form $form) {
            return $fieldName;
        });
    }

    public function register()
    {
        $this->app->bind(Request::class, LaravelRequest::class);
        $this->app->bind(Renderer::class, JsonRenderer::class);
    }

}
