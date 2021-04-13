<div class="section row">
    @foreach($sections as $section)
        <div class="col {{ \Illuminate\Support\Arr::get($section, 'attributes.class', '') }}">
            @foreach($section['items'] ?? [] as $item)
                <div class="field @unless($loop->first) mt-3 @endunless">
                    @if($item instanceof \Lighthouse\Contract\Form\Form)
                        @if($item instanceof \Lighthouse\Contract\Form\Updatable)
                            {!! dd($data) !!}
                        @endif
                        {!! $renderer->process($item) !!}
                    @elseif($item instanceof \Lighthouse\Contract\Form\Field)
                        {!! $renderer->processField($item) !!}
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach
</div>
