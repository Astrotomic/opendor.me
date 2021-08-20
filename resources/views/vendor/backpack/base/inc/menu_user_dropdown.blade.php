<li class="nav-item dropdown pr-4">
  <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
    <img class="img-avatar" src="{{ backpack_auth()->user()->avatar_url }}" alt="{{ backpack_auth()->user()->name }}">
      {{ backpack_auth()->user()->name }}
  </a>
  <div class="dropdown-menu {{ config('backpack.base.html_direction') == 'rtl' ? 'dropdown-menu-left' : 'dropdown-menu-right' }} mr-4 pb-1 pt-1">
    <a class="dropdown-item" href="{{ route('auth.signout') }}">
        <i class="la la-lock"></i>
        {{ trans('backpack::base.logout') }}
    </a>
  </div>
</li>
