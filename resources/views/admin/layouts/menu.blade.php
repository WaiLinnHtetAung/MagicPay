<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <img src="{{ asset('images/logo.png') }}" style="width: 45px" alt="">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Magic Pay</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('admin') ? 'active' : '' }}">
            <a href="{{ route('admin.home') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-dashboard'></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- User management -->
        <li
            class="menu-item {{ request()->is('admin/admin-users') || request()->is('admin/admin-users/*') || request()->is('admin/users') || request()->is('admin/users/*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bx-user'></i>
                <div data-i18n="Layouts">User Management</div>
            </a>

            <ul class="menu-sub">
                <li
                    class="menu-item {{ request()->is('admin/admin-users') || request()->is('admin/admin-users/*') ? 'active open' : '' }}">
                    <a href="{{ route('admin.admin-users.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Admin Users</div>
                    </a>
                </li>
                <li
                    class="menu-item {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active open' : '' }}">
                    <a href="{{ route('admin.users.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Users</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Wallet</span>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-wallet'></i>
                <div data-i18n="Account Settings">Wallet</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('admin.wallet.index') }}" class="menu-link">
                        <div data-i18n="Account">Wallet</div>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</aside>
