
<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="searchModal">
  <div class="modal-dialog full-size" role="document">
    <div class="modal-content">
      <div class="modal-header" style="display:block">
        <div class="container">
		  <div class="row">
		    <div class="col-2 col-sm-1 d-block d-md-none text-left button-wrapper">
              <button type="button" class="close ricerca_sezione_generale" data-dismiss="modal" aria-hidden="false">
                <svg class="icon icon-lg"><use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-arrow-left"></use></svg>
              </button>
              <button type="button" id="bBackBaseSearchSm" class="close ricerca_sezione_filtri">
                <svg class="icon icon-lg"><use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-arrow-left"></use></svg>
              </button>
		    </div>
		    <div class="offset-md-1 col-9 col-sm-10 text-center">
              <h3 class="modal-title" id="searchModalTitle">
                <span aria-hidden="false" class="ricerca_sezione_generale">Cerca</span>
                <span aria-hidden="true" class="ricerca_sezione_filtri">Filtri</span>
              </h3>
            </div>
            <div class="col-1 d-none d-md-block text-right button-wrapper">
              <button type="button" class="close ricerca_sezione_generale" data-dismiss="modal" aria-label="Chiudi filtri di ricerca" aria-hidden="false">
			          <svg class="icon icon-lg"><use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-close"></use></svg>
			        </button>
              <button type="button" id="bBackBaseSearchMd" class="close ricerca_sezione_filtri" aria-hidden="false">
                <svg class="icon icon-lg"><use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-close"></use></svg>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row">
            <div class="offset-md-1 col-md-10 col-sm-12">
              <form role="search" class="searchform-modal" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <div class="form-group">
                  <div class="input-group">
                    <label for="search-field" class="sr-only active">Cerca servizi, informazioni, persone ...</label>
                    <input type="text" class="form-control" id="search-field" name="s" placeholder="Cerca servizi, informazioni, persone ...">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col text-center">
                    <button type="submit" class="btn btn-primary" id="searchbutton-modal">Cerca&nbsp;<svg class="icon icon-sm icon-light"><use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-search"></use></svg></button>
                  </div>
                </div>

                <div class="ricerca_sezione_generale">
                <div class="form-group form-filter">
                  <div class="btn-group-toggle" data-toggle="buttons">
                    <label for="tutte_le_categorie" class="btn btn-primary ctrl-btn-label border border-primary active">
                      <input type="checkbox" checked="1" autocomplete="off" id="tutte_le_categorie" name="tutte_le_categorie" value="0">
                      <svg class="icon">
                        <use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-check-circle"></use>
                      </svg> Tutto
                    </label>
                  </div>
                  @foreach (\app\Controllers\Search::main_category() as $cat)
                    <div class="btn-group-toggle" data-toggle="buttons">
                      <label for="g-cat-{{$cat->slug}}" class="btn btn-primary ctrl-btn-label border border-primary">
                        <input type="checkbox" autocomplete="off" id="g-cat-{{$cat->slug}}" name="cat" value="{{$cat->term_id}}">
                        <svg class="icon">
                          <use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#{{ $cat->icon_cat_id }}"></use>
                        </svg> {{ $cat->name }}
                      </label>
                    </div>
                  @endforeach
                  <div class="btn-group-toggle" data-toggle="buttons">
                    <label id="attiva_filtri" for="cb_attiva_filtri" class="btn btn-primary ctrl-btn-label border border-primary">
                      <input type="checkbox" autocomplete="off" id="cb_attiva_filtri" name="cb_attiva_filtri" value="1">
                      ...
                    </label>
                  </div>
                </div>
                </div>
                <div class="ricerca_sezione_filtri">
                  <ul class="nav nav-tabs" id="searchFiltri" role="tablist" style="overflow: hidden">
                      <li role="presentation" class="nav-item">
                          <a class="nav-link active" id="data-ex-categorie-tab" data-toggle="tab" href="#categorie" role="tab" aria-controls="categorie" aria-selected="true">Categoria</a>
                      </li>
                      <li role="presentation" class="nav-item">
                          <a class="nav-link" id="data-ex-termini-tab" data-toggle="tab" href="#termini" role="tab" aria-controls="termini" aria-selected="false">Argomenti</a>
                      </li>
                      <li role="presentation" class="nav-item">
                          <a class="nav-link" id="data-ex-opzioni-tab" data-toggle="tab" href="#opzioni" role="tab" aria-controls="opzioni" aria-selected="false">Opzioni</a>
                      </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div class="tab-pane active" id="categorie" role="tabpanel" aria-labelledby="data-ex-categorie-tab">
                        <div class="container-fluid">
                          <div class="row pt-3">
                            @foreach (\app\Controllers\Search::all_category() as $m_cat)
                              <div class="col col-md-6 col-lg-6 col-xl-12 mb-4">
                                <div class="form-check form-check-group cb-main border-bottom">
                                  <input id="cat-{{$m_cat->slug}}" value="{{$m_cat->term_id}}" name="cat" type="checkbox">
                                  <label for="cat-{{$m_cat->slug}}">{{$m_cat->name}}</label>
                                </div>
                                @foreach ($m_cat->sub as $cat)
                                    <div class="form-check form-check-group">
                                      <input id="cat-{{$cat->slug}}" value="{{$cat->term_id}}" name="cat" type="checkbox">
                                      <label for="cat-{{$cat->slug}}">{{$cat->name}}</label>
                                    </div>
                                @endforeach
                              </div>
                            @endforeach
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="termini" role="tabpanel" aria-labelledby="data-ex-termini-tab">
                        <div class="container-fluid">
                          <div class="row pt-3">
                            @foreach (array_chunk(\app\Controllers\Search::all_terms(), 5) as $gterms)
                              <div class="col col-md-6 col-lg-6 col-xl-12 mb-4">
                                <div class="it-list-wrapper">
                                  <ul class="it-list">
                                    @foreach ($gterms as $term)
                                    <li>
                                      <div class="form-check">
                                        <input id="{{$term->term_id}}" type="checkbox">
                                        <label for="{{$term->term_id}}">{{$term->name}}</label>
                                      </div>
                                    </li>
                                    @endforeach
                                  </ul>
                                </div>
                              </div>
                            @endforeach
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="opzioni" role="tabpanel" aria-labelledby="data-ex-opzioni-tab">
                        <div class="container-fluid">
                          <div class="row pt-3">...Opzioni...</div>
                        </div>
                      </div>
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

