<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

                
    <div class="app-brand demo mt-3">
    <a href="{{route('dashboard')}}" class="app-brand-link">
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
        <a href="{{route('dashboard')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Dashboards">Dashboards</div>
        </a>
    </li>

    <!-- Apps & Pages -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Master Datas</span></li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class='menu-icon tf-icons bx bx-bookmark'></i>
        <div data-i18n="Kurikulum">Kurikulum</div>
        </a>
        <ul class="menu-sub">
        <li class="menu-item">
            <a href="{{route('matakuliah.index')}}" class="menu-link">
            <div data-i18n="Daftar Matakuliah">Daftar Matakuliah</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{route('kurikulum.index')}}" class="menu-link">
            <div data-i18n="Daftar Kurikulum">Daftar Kurikulum</div>
            </a>
        </li>
        </ul>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class='menu-icon tf-icons bx bx-buildings'></i>
        <div data-i18n="Universitas">Universitas</div>
        </a>
        <ul class="menu-sub">
        <li class="menu-item">
            <a href="{{route('fakultas.index')}}" class="menu-link">
            <div data-i18n="Daftar Fakultas">Daftar Fakultas</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{route('prodi.index')}}" class="menu-link">
            <div data-i18n="Daftar Prodi">Daftar Prodi</div>
            </a>
        </li>       
        </ul>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class='menu-icon tf-icons bx bx-cog'></i>
        <div data-i18n="Settings">Settings</div>
        </a>
        <ul class="menu-sub">
        <li class="menu-item">
            <a href="{{route('periode.index')}}" class="menu-link">
            <div data-i18n="Periode">Periode</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{route('mk-kurikulum.index')}}" class="menu-link">
            <div data-i18n="Matakuliah Kurikulum">Matakuliah Kurikulum</div>
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
            <a href="{{route('profile')}}" class="menu-link">
            <div data-i18n="Profile">Profile</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{route('user.index')}}" class="menu-link">
            <div data-i18n="All Users">All Users</div>
            </a>
        </li>
        </ul>
    </li>
    </ul>
    
    

</aside>
<!-- / Menu -->