<div class="row">
  <div class="col">
    <h1>{!! App::title() !!}</h1>
    @if (has_excerpt())
      <p>{{ get_post()->post_excerpt }}</p>
    @endif
  </div>
</div>
