<div class="row">
  <div class="col-lg-8 px-lg-4 py-lg-2">
    <h1>{!! App::title() !!}</h1>
    @if (has_excerpt())
      <p>{{ get_post()->post_excerpt }}</p>
    @endif
    <div class="row mt-5 mb-4">
      <div class="col-6">
        <small>Data:</small>
        <p class="font-weight-semibold text-monospace">{{ the_date() }}</p>
      </div>
      <div class="col-6">
        <small>Tempo di lettura:</small>
        <p class="font-weight-semibold">{!! do_shortcode('[rt_reading_time postfix="minuti" postfix_singular="minuto"]') !!}</p>
      </div>
    </div>
  </div>
  <div class="col-lg-3 offset-lg-1">
    <div class="dropdown d-inline">
      <button
              class="btn btn-dropdown dropdown-toggle"
              type="button"
              id="shareActions"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
      >
        <svg class="icon">
          <use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-share"></use>
        </svg>
        <small>Condividi</small>
      </button>
      <div class="dropdown-menu shadow-lg" aria-labelledby="shareActions">
        <div class="link-list-wrapper">
          {!! $show_social_link !!}
        </div>
      </div>
    </div>
    <div class="dropdown d-inline">
      <button
              class="btn btn-dropdown dropdown-toggle"
              type="button"
              id="viewActions"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
      >
        <svg class="icon">
          <use
                  xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-more-items"
          ></use>
        </svg>
        <small>Vedi azioni</small>
      </button>
      <div class="dropdown-menu shadow-lg" aria-labelledby="viewActions">
        <div class="link-list-wrapper">
          <ul class="link-list">
            <li>
              <a class="list-item" href="#">
                <svg class="icon">
                  <use
                          xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-download"
                  ></use>
                </svg>
                <span>Scarica</span>
              </a>
            </li>
            <li>
              <a class="list-item" href="#">
                <svg class="icon">
                  <use
                          xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-print"
                  ></use>
                </svg>
                <span>Stampa</span>
              </a>
            </li>
            <li>
              <a class="list-item" href="#">
                <svg class="icon">
                  <use
                          xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-hearing"
                  ></use>
                </svg>
                <span>Ascolta</span>
              </a>
            </li>
            <li>
              <a class="list-item" href="#">
                <svg class="icon">
                  <use
                          xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-mail"
                  ></use>
                </svg>
                <span>Invia</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="mt-4 mb-4">
      <h6><small>Argomenti</small></h6>
      {!! $chip_categories !!}
    </div>

  </div>
</div>
