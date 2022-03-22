<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/">SPK Objek Wisata</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-nav bg-dark w-100">
    <div class="nav-item text-nowrap d-md-flex justify-content-end">
      <form action="/signout" method="POST" class="d-inline">
        @csrf
        <span role="button" class="nav-link px-3 btnSignOut">
          <span data-feather="log-out"></span>
          Sign Out
        </span>
      </form>
    </div>
  </div>
</header>