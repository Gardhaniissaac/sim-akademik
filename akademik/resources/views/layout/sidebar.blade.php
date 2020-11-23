<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link">
      <img src="{{asset('/adminlte/dist/img/akademik_public_adminlte_dist_img_AdminLTELogo.png')}}"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">SIM AKADEMIK</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          @if(Auth::user()->getProfile)
            <a href="{{route('profile.show', ['profile' => Auth::user()->getProfile->id])}}" class="d-block">
            <i class="fas fa-users mr-3 ml-2"></i>
            @auth
                {{Auth::user()->username}}
            @endauth
            </a>
          @else
            <a href="{{route('profile.create')}}" class="d-block">
            Guest</i>
          @endif
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @if (Auth::user()->getProfile)
            <li class="nav-item has-treeview">
              <a href="/mahasiswa" class="nav-link">
                <i class="fas fa-graduation-cap mr-3"></i>
                <p>
                  DATA MAHASISWA
                </p>
              </a>
            </li>
            @if(Auth::user()->getProfile)
              @if(Auth::user()->getProfile->status == 'Admin')
                <li class="nav-item has-treeview">
                  <a href="/profile" class="nav-link">
                    <i class="fas fa-graduation-cap mr-3"></i>
                    <p>
                      DATA PROFILE
                    </p>
                  </a>
                </li>
              @endif
            @endif
            <li class="nav-item has-treeview">
              <a href="/dosen" class="nav-link">
                <i class="fas fa-chalkboard-teacher mr-3"></i>
                <p>
                  DATA DOSEN
                </p>
              </a>
            </li>   
            <li class="nav-item has-treeview">
              <a href="/tu" class="nav-link">
                <i class="fas fa-user-shield mr-3"></i>
                <p>
                  DATA STAFF TATA USAHA
                </p>
              </a>
            </li> 
            <li class="nav-item has-treeview">
              <a href="/fakultas" class="nav-link">
                <i class="fas fa-university mr-3"></i>
                <p>
                  DATA FAKULTAS
                </p>
              </a>
            </li> 
            <li class="nav-item has-treeview">
              <a href="/jurusan" class="nav-link">
                <i class="fas fa-university mr-3"></i>
                <p>
                  DATA JURUSAN
                </p>
              </a>
            </li> 
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-align-justify mr-3"></i>
                <p>
                  DATA LAIN
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/kelas" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>DATA KELAS KULIAH</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/rencana" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>DATA RENCANA STUDY</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/transkrip" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>DATA TRANSKRIP</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>