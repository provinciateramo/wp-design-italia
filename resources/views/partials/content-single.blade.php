	@if ($use_hero)
		{!! $featured_image !!}
	@endif
  <div class="row border-top row-column-border row-column-menu-left">
	  <aside class="col-lg-4" style="position: relative;">
		  <div class="sticky-wrapper navbar-wrapper" style="">
			  <nav class="navbar it-navscroll-wrapper it-top-navscroll navbar-expand-lg">
				  <button class="custom-navbar-toggler" type="button" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" data-target="#navbarNav"><span class="it-list"></span>Descrizione</button>
				  <div class="navbar-collapsable" id="navbarNav">
					  <div class="overlay"></div>
					  <div class="close-div sr-only">
						  <button class="btn close-menu" type="button">
							  <span class="it-close"></span>Chiudi
						  </button>
					  </div>
					  <a class="it-back-button" href="#">
						  <svg class="icon icon-sm icon-primary align-top">
							  <use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-chevron-left"></use>
						  </svg>
						  <span>Torna indietro</span></a>
					  <div class="menu-wrapper">
						  <div class="link-list-wrapper menu-link-list">
							  <h3 class="no_toc">Indice della pagina</h3>

							  <?php echo do_shortcode('[ez-toc]'); ?>

						  </div>
					  </div>
				  </div>
			  </nav>
		  </div>
	  </aside>
	  <section class="col-lg-8 it-page-sections-container">
	@if (!$use_hero) {!! $featured_image !!} @endif
	@php the_content() @endphp
	  </section>
  </div>
  <footer>
	{!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
  </footer>
  @php comments_template('/partials/comments.blade.php') @endphp

