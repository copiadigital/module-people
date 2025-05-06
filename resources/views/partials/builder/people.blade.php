<div class="section people">
  @if($teams && $peoples)
    <div class="people__nav">
      @foreach ($teams as $team)
        <div class="people__nav-item" role="presentation">
          <a class="people__nav-link" data-filter="{{ $team->slug }}">{{ $team->name }}</a>
        </div>
      @endforeach
    </div>
    <div class="row js-flex-reorder">
      @foreach($peoples as $person)
        <section class="col-12 col-md-6 col-lg-4 js-flex-item js-flex-panel" data-teams="{{ $person['teams'] }}">
          <div role="article" class="collapsed" data-bs-toggle="collapse" data-bs-target="#personDropdown-{{ $person['slug'] }}" aria-expanded="false" aria-controls="personDropdown-{{ $person['slug'] }}">
            @if($person['photo'])
              <x-image-progressive
                width="{{ $person['photo']['width'] }}"
                height="{{ $person['photo']['height'] }}"
                size="full" sizes="{{ $person['photo']['id'] }}"
                src="{{ $person['photo']['id'] }}" srcset="{{ $person['photo']['id'] }}"
                alt="{{ !empty($person['photo']['alt']) ? $person['photo']['alt'] : App\get_filename($person['photo']['id']) }}"
              />
            @endif
            <div class="person__content">
              <h5 class="person__title text-primary">{!! $person['title'] !!}</h5>
              <p class="person__position">{{ $person['position'] }}</p>
              <a class="link panel__link -toggle"></a>
            </div>
          </div>
        </section>
        <div class="col-12 js-flex-item js-flex-dropdown">
          <div class="panel__dropdown collapse" id="personDropdown-{{ $person['slug'] }}" data-bs-parent=".main">
            <div class="person__description">
              {!! $person['descriptions'] !!}
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>