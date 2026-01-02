<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- BRAND -->
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bold ms-2 text-capitalize">
                {{ config('app.name') }} Admin
            </span>
        </a>

        <a href="javascript:void(0);"
           class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <!-- MENU -->
    <ul class="menu-inner py-1">

        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <!-- Institutes -->
        @can('manage users')
        <li class="menu-item {{ request()->is('admin/institutes*') ? 'active' : '' }}">
            <a href="{{ route('admin.institutes.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-buildings"></i>
                <div>Institutes</div>
            </a>
        </li>
        @endcan

        <!-- Subscription Plans -->
        @can('manage subscriptions')
        <li class="menu-item {{ request()->is('admin/subscription-plans*') ? 'active' : '' }}">
            <a href="{{ route('admin.subscription.plans.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-rupee"></i>
                <div>Subscription Plans</div>
            </a>
        </li>
        @endcan

        <!-- Institute Subscriptions -->
        @can('manage subscriptions')
        <li class="menu-item {{ request()->is('admin/institute-subscriptions*') ? 'active' : '' }}">
            <a href="{{ route('admin.institute.subscriptions.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-receipt"></i>
                <div>Institute Subscriptions</div>
            </a>
        </li>
        @endcan

        <!-- Role & Permission Management -->
        @canany(['manage roles','manage permissions'])
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Access Control</span>
        </li>
        @endcanany

        <!-- Roles -->
        @can('manage roles')
        <li class="menu-item {{ request()->is('admin/roles*') ? 'active' : '' }}">
            <a href="{{ route('admin.roles.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-shield"></i>
                <div>Roles</div>
            </a>
        </li>
        @endcan

        <!-- Permissions -->
        @can('manage permissions')
        <li class="menu-item {{ request()->is('admin/permissions*') ? 'active' : '' }}">
            <a href="{{ route('admin.permissions.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-lock"></i>
                <div>Permissions</div>
            </a>
        </li>
        @endcan

    </ul>
</aside>
