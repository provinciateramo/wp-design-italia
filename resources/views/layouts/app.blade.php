<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class() @endphp>
    @include('partials.cookiebar')
    <div id="wrapper" class="hfeed">
      @php do_action('get_header') @endphp
      @include('partials.it-header')
      <section id="content" role="main">
        <div class="wrap container px-4 my-4" role="document">
          @if ( is_singular() )
            <div class="row">
              <div class="col px-lg-4">
               {!!  App::wp_breadcrumb() !!}
              </div>
            </div>
          @endif
          <div class="row">
            <div class="{!! App\wpdi_content_class() !!}">
              @yield('content')
            </div>
            @if (App\display_sidebar())
              <div class="col-md-4 offset-md-1">
                <aside id="sidebar" role="complementary">
                  @include('partials.sidebar')
                </aside>
              </div>
            @endif
          </div>
        </div>
      </section>
      @php do_action('get_footer') @endphp
      @include('partials.footer')
    </div>
    @php wp_footer() @endphp
    @include('partials.modal-search')
  </body>
</html>
