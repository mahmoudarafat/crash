<li class="side-menus {{ Request::is('*') ? 'active' : '' }}">
    <a class="nav-link" href="/">
        <i class=" fas fa-building"></i><span>Dashboard</span>
    </a>
</li>

<li class="side-menus {{ Request::is('users*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-building"></i><span>Users</span></a>
</li><li class="{{ Request::is('regions*') ? 'active' : '' }}">
    <a href="{{ route('regions.index') }}"><i class="fa fa-edit"></i><span>@lang('models/regions.plural')</span></a>
</li>

