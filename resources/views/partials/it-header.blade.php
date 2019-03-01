<header id="mainheader" class="it-header-wrapper fixed-top-section" role="banner">
  <section class="it-header-slim-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="it-header-slim-wrapper-content">
            <a class="d-none d-lg-block navbar-brand" href="#">Regione Abruzzo</a>
            <span class="nav-mobile">
              <nav>
                <a class="it-opener d-lg-none" data-toggle="collapse" href="#menu-servizi" role="button" aria-expanded="false" aria-controls="menu-servizi">
                  <span class="font-weight-bold">Regione Abruzzo</span>
                  <svg class="icon">
                    <use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-expand"></use>
                  </svg>
                </a>
                <div class="link-list-wrapper collapse" id="menu-servizi">
                  <?php wp_nav_menu(array( 'theme_location' => 'menu-servizi', 'container' => 'ul', 'menu_class' => 'link-list' )); ?>
                </div>
              </nav>
            </span>
            <div class="header-slim-right-zone">
              <div class="it-access-top-wrapper">
                <button class="btn btn-primary btn-sm" href="#" type="button">Accedi</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
    <section class="it-header-center-wrapper it-small-header">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="it-header-center-content-wrapper row">
              <div class="it-brand-wrapper col">
                <a class="p-0" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>" rel="home">
                  {!! App::wpdi_the_custom_logo() !!}
                    <div class="it-brand-text">
                      <h2 class="no_toc">{{ esc_html(get_bloginfo( 'name' )) }}</h2>
                      @if (get_theme_mod('tagline_visibility')=="")
                      <h3 class="no_toc d-none d-lg-block">{{ bloginfo("description") }}</h3>
                      @endif
                    </div>
                </a>
              </div>
              <div class="it-right-zone">
                <div class="it-socials d-none d-md-flex">
                  {!! App::social_links() !!}
                </div>
                <div class="it-search-wrapper">
                  <span class="d-none d-md-block">Cerca</span>
                  <a class="search-link rounded-icon" aria-label="Cerca" href="#" data-toggle="modal" data-target="#searchModal">
                    <svg class="icon"><use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-search"></use></svg>
                  </a>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  <div id="" class="it-nav-wrapper">
  <div class="it-header-navbar-wrapper d-none d-lg-block">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav class="navbar navbar-expand-sm" id="menu-main-bar" role="navigation">
              <div class="navbar-collapsable" id="nav2" style="display: none;">
                <div class="menu-wrapper">
               <?php wp_nav_menu(array( 'theme_location' => 'menu-main', 'depth' => 2, 'container' => 'ul', 'menu_class' => 'navbar-nav', 'walker' => new App\WP_Bootstrap_Navwalker() )); ?>
                </div>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </div>

  </div>
  <nav class="fixed-bottom toolbar d-lg-none" style="position:fixed!important;">
    <ul style="bottom:0px; top:auto;">
      <li>
        <a href="#" class="active">
          <svg class="icon"><use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-pa"></use></svg>
          <span class="toolbar-label">Amministrazione</span>
        </a>
      </li>
      <li>
        <a href="#">
          <svg class="icon"><use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-tool"></use></svg>
          <span class="toolbar-label">Servizi</span>
        </a>
      </li>
      <li>
        <a href="#">
          <svg class="icon"><use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-note"></use></svg>
          <span class="toolbar-label">Novità</span>
        </a>
      </li>
      <li>
        <div class="dropup">
          <button class="btn btn-dropdown dropdown-toggle toolbar-more" type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <svg class="icon"><use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-more-actions"></use></svg>
            <span class="toolbar-label">Altro</span>
          </button>
          <div class="dropdown-menu shadow-sm bg-white" aria-labelledby="dropdownMenuButton5">
            <div class="link-list-wrapper text-right">
              <ul class="link-list ">
                <li class="text-nowrap"><a class="list-item large right-icon" href="#"><span>Label</span><svg class="icon mt-1 ml-1" aria-hidden="true"><use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-link"></use></svg></a></li>
                <li class="text-nowrap"><a class="list-item large right-icon" href="#"><span>Label</span><svg class="icon mt-1 ml-1" aria-hidden="true"><use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-mail"></use></svg></a></li>
                <li class="text-nowrap"><a class="list-item large right-icon" href="#"><span>Label</span><svg class="icon mt-1 ml-1" aria-hidden="true"><use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-settings"></use></svg></a></li>
                <li class="text-nowrap"><a class="list-item large right-icon" href="#"><span>Documenti</span><svg class="icon mt-1 ml-1" aria-hidden="true"><use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-file"></use></svg></a></li>
              </ul>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </nav>
</header>


