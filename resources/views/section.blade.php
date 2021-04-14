<div class="section row" data-section-path="{{ implode('_', $path) }}">
    @foreach($sections as $section)
        <div class="col {{ \Illuminate\Support\Arr::get($section, 'attributes.class', '') }}">
            @foreach($section['items'] ?? [] as $item)
                <div class="field @unless($loop->first) mt-3 @endunless">
                    @if($item instanceof \Lighthouse\Contract\Form\Form)
                        {!! $renderer->process($item) !!}
                    @elseif($item instanceof \Lighthouse\Contract\Form\Field)
                        {!! $renderer->processField($item) !!}
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach
</div>
