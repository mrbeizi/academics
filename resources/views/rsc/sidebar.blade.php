<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

                
    <div class="app-brand demo mt-3">
    <a href="{{route('dashboard')}}" class="app-brand-link">
        <span class="app-brand-logo demo"><img src="{{asset('images/svg/Aanew.png')}}" width="32px" height="32px" alt=""></span>
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
        <a href="{{route('dashboard')}}" class="menu-link {{set_active('dashboard')}}">
        <i class="menu-icon tf-icons bx bx-home-circle bx-tada-hover"></i>
        <div data-i18n="Dashboards">Dashboards</div>
        </a>
    </li>

    <!-- Apps & Pages -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Main Menus</span></li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle {{set_active('gol-kelas.index')}}">
        <i class='menu-icon tf-icons bx bx-dock-top bx-tada-hover'></i>
        <div data-i18n="Perkuliahan">Perkuliahan</div>
        </a>
        <ul class="menu-sub">
        <li class="menu-item">
            <a href="{{route('gol-kelas.index')}}" class="menu-link {{set_active('gol-kelas.index')}}">
            <div data-i18n="Kelompok Mahasiswa">Kelompok Mahasiswa</div>
            </a>
        </li>
        </ul>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle {{set_active('periode.index')}} OR {{set_active('kurikulum.index')}} OR {{set_active('matakuliah.index')}} OR {{set_active('gol-matakuliah.index')}}">
        <i class='menu-icon tf-icons bx bx-buildings bx-tada-hover'></i>
        <div data-i18n="Universitas">Universitas</div>
        </a>
        <ul class="menu-sub">
        <li class="menu-item">
            <a href="{{route('periode.index')}}" class="menu-link {{set_active('periode.index')}}">
            <div data-i18n="Periode">Periode</div>
            </a>
        </li>
        <li class="menu-item">
            <a class="menu-link menu-toggle {{set_active('kurikulum.index')}} OR {{set_active('matakuliah.index')}} OR {{set_active('gol-matakuliah.index')}}" href="javascript:void(0)">
            <div data-i18n="Kurikulum">Kurikulum</div></a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{route('kurikulum.index')}}" class="menu-link {{set_active('kurikulum.index')}}">
                    <div data-i18n="Daftar Kurikulum">Daftar Kurikulum</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('matakuliah.index')}}" class="menu-link {{set_active('matakuliah.index')}}">
                    <div data-i18n="Daftar Matakuliah">Daftar Matakuliah</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('gol-matakuliah.index')}}" class="menu-link {{set_active('gol-matakuliah.index')}}">
                    <div data-i18n="Gol. Matakuliah">Gol. Matakuliah</div>
                    </a>
                </li> 
            </ul>
        </li>
             
        </ul>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle {{set_active('pegawai.index')}} OR {{set_active('mahasiswa.index')}} OR {{set_active('status-pegawai.index')}} OR {{set_active('status-mahasiswa.index')}} OR {{set_active('api-mahasiswa.index')}} OR {{set_active('calon-mahasiswa.index')}}  OR {{set_active('api-mahasiswa-prodi.index')}} OR {{set_active('user.index')}}">
        <i class="menu-icon tf-icons bx bx-user bx-tada-hover"></i>
        <div data-i18n="Users">Users</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{route('pegawai.index')}}" class="menu-link {{set_active('pegawai.index')}}">
                <div data-i18n="Pegawai">Pegawai</div>
                </a>
            </li>        
            <li class="menu-item">
                <a href="{{route('mahasiswa.index')}}" class="menu-link {{set_active('mahasiswa.index')}}">
                <div data-i18n="Mahasiswa">Mahasiswa</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{route('status-pegawai.index')}}" class="menu-link {{set_active('status-pegawai.index')}}">
                <div data-i18n="Status Pegawai">Status Pegawai</div>
                </a>
            </li>               
            <li class="menu-item">
                <a href="{{route('status-mahasiswa.index')}}" class="menu-link {{set_active('status-mahasiswa.index')}}">
                <div data-i18n="Status Mahasiswa">Status Mahasiswa</div>
                </a>
            </li> 
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle {{set_active('api-mahasiswa.index')}} OR {{set_active('calon-mahasiswa.index')}}  OR {{set_active('api-mahasiswa-prodi.index')}}">
                <div data-i18n="Data API">Data API</div>
                </a>
                <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{route('api-mahasiswa.index')}}" class="menu-link {{set_active('api-mahasiswa.index')}}">
                    <div data-i18n="All Mahasiswa">All Mahasiswa</div>
                    </a>
                </li>      
                </ul>
            </li>        
            <li class="menu-item">
                <a href="{{route('user.index')}}" class="menu-link {{set_active('user.index')}}">
                <div data-i18n="Administrator">Administrator</div>
                </a>
            </li>
        </ul>
    </li>
    
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle {{set_active('jabatan.index')}} OR {{set_active('pendidik.index')}} OR {{set_active('jabatan-pegawai.index')}}">
        <i class='menu-icon tf-icons bx bx-briefcase-alt bx-tada-hover'></i>
        <div data-i18n="Jabatan">Jabatan</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{route('jabatan.index')}}" class="menu-link {{set_active('jabatan.index')}}">
                <div data-i18n="Jabatan">Jabatan</div>
                </a>
            </li> 
            <li class="menu-item">
                <a href="{{route('pendidik.index')}}" class="menu-link {{set_active('pendidik.index')}}">
                <div data-i18n="Pendidik (Dosen)">Pendidik (Dosen)</div>
                </a>
            </li> 
            <li class="menu-item">
                <a href="{{route('jabatan-pegawai.index')}}" class="menu-link {{set_active('jabatan-pegawai.index')}}">
                <div data-i18n="Jabatan Pegawai">Jabatan Pegawai</div>
                </a>
            </li>       
                 
        </ul>
    </li>
    
    
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle {{set_active('fakultas.index')}} OR {{set_active('prodi.index')}} OR {{set_active('data-formulir.index')}}">
        <i class='menu-icon tf-icons bx bx-data bx-tada-hover'></i>
        <div data-i18n="Data Master">Data Master</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{route('fakultas.index')}}" class="menu-link {{set_active('fakultas.index')}}">
                <div data-i18n="Daftar Fakultas">Daftar Fakultas</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{route('prodi.index')}}" class="menu-link {{set_active('prodi.index')}}">
                <div data-i18n="Daftar Prodi">Daftar Prodi</div>
                </a>
            </li>  
            <li class="menu-item">
                <a href="{{route('data-formulir.index')}}" class="menu-link {{set_active('data-formulir.index')}}">
                <div data-i18n="Data Formulir">Data Formulir</div>
                </a>
            </li>      
        </ul>
    </li>
    

    <!-- Keuangan -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Keuangan</span></li>
    <li class="menu-item">
        <a href="{{route('payment.index')}}" class="menu-link {{set_active('payment.index')}}">
        <i class="menu-icon tf-icons bx bx-money bx-tada-hover"></i>
        <div data-i18n="Payments">Payments</div>
        </a>
    </li>
    <li class="menu-item">
        <a href="{{route('biaya-kuliah.index')}}" class="menu-link {{set_active('biaya-kuliah.index')}}">
        <i class="menu-icon tf-icons bx bx-wallet bx-tada-hover"></i>
        <div data-i18n="Tuition Fees">Tuition Fees</div>
        </a>
    </li>
    <li class="menu-item">
        <a href="{{route('custom-biaya.index')}}" class="menu-link {{set_active('custom-biaya.index')}}">
        <i class="menu-icon tf-icons bx bx-wallet-alt bx-tada-hover"></i>
        <div data-i18n="Customize Cost">Customize Cost</div>
        </a>
    </li>    
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle {{set_active('setup-biaya.index')}} OR {{set_active('payment-list.index')}}">
        <i class='menu-icon tf-icons bx bx-data bx-tada-hover'></i>
        <div data-i18n="Data Master">Data Master</div>
        </a>
        <ul class="menu-sub">
        <li class="menu-item">
            <a href="{{route('setup-biaya.index')}}" class="menu-link {{set_active('setup-biaya.index')}}">
            <div data-i18n="Setup Cost">Setup Cost</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{route('payment-list.index')}}" class="menu-link {{set_active('payment-list.index')}}">
            <div data-i18n="Payment List">Payment List</div>
            </a>
        </li>
        </ul>
    </li>
    <!-- End of Sidebar Keuangan -->
    </ul>
    
    

</aside>
<!-- / Menu -->