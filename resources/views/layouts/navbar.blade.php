@php
  $role_menus = App\Http\Models\Master\RoleMenu::where('role_id', Session::get('_role_id'))->pluck('menu_id')->all();

  $menus = App\Http\Models\Master\Menu::whereIn('id', $role_menus)->with(['children' => function($q) use($role_menus){
            $q->whereIn('id', $role_menus);
          }])->get();
@endphp

<nav class="bottom-navbar">
  <div class="container">
    <ul class="nav page-navigation">
      @foreach($menus as $menu)
        @if($menu->parent < 1)
        <li class="nav-item">
          <a href="{{$menu->url != '-' ? url($menu->url) : '#'}}" class="nav-link">
            <img src="{{ URL::asset($menu->icon) }}" height="25">&nbsp;
            <span class="menu-title">{{$menu->name}}</span>
            @if(count($menu->children) > 0)
              <i class="menu-arrow"></i>
            @endif
          </a>
          @if(count($menu->children) > 0)
          <div class="submenu">
            <ul class="submenu-item">
              @foreach($menu->children as $menu_children)
                <li class="nav-item"><a class="nav-link" href="{{url($menu_children->url)}}">{{$menu_children->name}}</a></li>
              @endforeach
            </ul>
          </div>
          @endif
        </li>
        @endif
      @endforeach
    </ul>
  </div>
</nav>