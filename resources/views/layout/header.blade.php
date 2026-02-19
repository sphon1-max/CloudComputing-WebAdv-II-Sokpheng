<style>
  .modern-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    position: sticky;
    top: 0;
    z-index: 1030;
    height: 60px;
  }

  .brand-logo {
    transition: transform 0.3s ease;
  }

  .brand-logo:hover {
    transform: scale(1.05);
  }

  .search-container {
    position: relative;
    max-width: 350px;
    width: 100%;
  }

  .search-input {
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #2d3748;
    border-radius: 20px;
    padding: 8px 15px;
    transition: all 0.3s ease;
    width: 100%;
    font-size: 14px;
  }

  .search-input:focus {
    background: rgba(255, 255, 255, 1);
    border-color: rgba(255, 255, 255, 0.5);
    box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
    color: #2d3748;
    outline: none;
  }

  .search-input::placeholder {
    color: #6b7280;
    font-size: 14px;
  }

  .admin-dropdown {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 25px;
    color: white;
    padding: 8px 15px;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
  }

  .admin-dropdown:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-1px);
  }

  .admin-dropdown:focus {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.4);
    box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
    color: white;
  }

  .admin-dropdown option {
    background: #343a40;
    color: white;
  }

  .notification-badge {
    background: #ff4757;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: -5px;
    right: -5px;
  }

  .header-icon {
    color: rgba(255, 255, 255, 0.8);
    font-size: 18px;
    margin: 0 8px;
    transition: all 0.3s ease;
    cursor: pointer;
  }

  .header-icon:hover {
    color: white;
    transform: translateY(-2px);
  }

  .admin-section {
    min-width: 200px;
  }

  @media (max-width: 768px) {
    .search-container {
      display: none !important;
    }

    .admin-section {
      min-width: 150px;
    }

    .modern-header {
      padding: 0.5rem 1rem;
    }
  }

  @media (max-width: 992px) {
    .header-icon {
      margin: 0 5px;
    }

    .search-container {
      max-width: 250px;
    }

    .search-input {
      font-size: 13px;
      padding: 6px 12px;
    }
  }

  @media (min-width: 1200px) {
    .search-container {
      max-width: 400px;
    }
  }
</style>

<header class="navbar navbar-dark sticky-top modern-header flex-md-nowrap p-2 shadow-lg">
  <!-- Brand/Logo Section -->
  <div class="col-md-3 col-lg-2 me-0 px-2 d-flex align-items-center">
    <a href="/dashboard" class="brand-logo d-flex align-items-center text-decoration-none">
      <img src="assets/image/mylogo.png" width="35" height="35" class="me-2 rounded-circle">
      <span class="text-white fw-bold d-none d-lg-block">EventAdmin</span>
      <span class="text-white fw-bold d-none d-md-block d-lg-none">EA</span>
    </a>
  </div>

  <!-- Mobile Toggle Button -->
  <button class="navbar-toggler position-absolute d-md-none collapsed border-0"
    type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu"
    aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation"
    style="right: 15px; top: 15px; background: rgba(255,255,255,0.1); border-radius: 8px;">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="nav-item me-3 d-flex align-items-center text-white">
    <form id="logoutForm" action="{{ route('admin.logout') }}" method="GET">
      <select id="admin-action" class="form-select form-select-sm border-0"
              style="width: auto; font-size: 20px;" onchange="handleAdminAction(this)">
        <option value="" disabled selected hidden>{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</option>
        <option value="logout">Logout</option>
      </select>
    </form>
  </div>
  <script>
    function handleAdminAction(select) {
      if (select.value === "logout") {
        document.getElementById('logoutForm').submit();
      }
    }
  </script>


  <script>
    function handleAdminAction(select) {
      if (select.value === "logout") {
        document.getElementById('logoutForm').submit();
      }
    }
  </script>

    
  
</header>

