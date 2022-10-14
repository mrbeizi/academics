<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

                
    <div class="app-brand demo ">
    <a href="/" class="app-brand-link">
        <span class="app-brand-logo demo"><img src="{{asset('images/svg/Aa.svg')}}" width="32px" height="32px" alt=""></span>
        <span class="app-brand-text demo menu-text fw-bold ms-2">{{config('app.name')}}</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
        <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
    </a>
    </div>

    
    <div class="menu-divider mt-0  ">
    </div>

    <div class="menu-inner-shadow"></div>

    
    
    <ul class="menu-inner py-1">
    <!-- Dashboards -->
    <li class="menu-item">
        <a href="/" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Dashboards">Dashboards</div>
        </a>
    </li>

    <!-- Apps & Pages -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Master Datas</span></li>
    <li class="menu-item">
        <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-calendar"></i>
        <div data-i18n="Kurikulum">Kurikulum</div>
        </a>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class='menu-icon tf-icons bx bx-food-menu'></i>
        <div data-i18n="Setting">Setting</div>
        </a>
        <ul class="menu-sub">
        <li class="menu-item">
            <a href="{{route('fakultas.index')}}" class="menu-link">
            <div data-i18n="Fakultas">Fakultas</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="app-invoice-list.html" class="menu-link">
            <div data-i18n="Mata Kuliah">Mata Kuliah</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="app-invoice-preview.html" class="menu-link">
            <div data-i18n="Prodi">Prodi</div>
            </a>
        </li>
        </ul>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Users">Users</div>
        </a>
        <ul class="menu-sub">
        <li class="menu-item">
            <a href="app-user-list.html" class="menu-link">
            <div data-i18n="List">List</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <div data-i18n="View">View</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="app-user-view-account.html" class="menu-link">
                <div data-i18n="Account">Account</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="app-user-view-security.html" class="menu-link">
                <div data-i18n="Security">Security</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="app-user-view-billing.html" class="menu-link">
                <div data-i18n="Billing & Plans">Billing & Plans</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="app-user-view-notifications.html" class="menu-link">
                <div data-i18n="Notifications">Notifications</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="app-user-view-connections.html" class="menu-link">
                <div data-i18n="Connections">Connections</div>
                </a>
            </li>
            </ul>
        </li>
        </ul>
    </li>
    </ul>
    
    

</aside>
<!-- / Menu -->