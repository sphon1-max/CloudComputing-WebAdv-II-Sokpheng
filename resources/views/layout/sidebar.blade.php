<style>
  .modern-sidebar {
    background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%);
    box-shadow: 4px 0 20px rgba(0, 0, 0, 0.05);
    border-right: 1px solid rgba(102, 126, 234, 0.1);
    position: relative;
    z-index: 1;
    overflow-x: hidden;
  }

  .sidebar-nav {
    padding: 0;
  }

  .nav-item {
    margin: 0.25rem 0.5rem;
  }

  .nav-link {
    border-radius: 8px;
    padding: 10px 12px;
    color: #2d3748;
    font-weight: 500;
    transition: all 0.2s ease;
    border: 1px solid transparent;
    display: flex;
    align-items: center;
    text-decoration: none;
    position: relative;
    overflow: hidden;
  }

  .nav-link:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white !important;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
    border-radius: 8px;
    text-decoration: none;
  }

  .nav-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white !important;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    border-radius: 8px;
  }

  .nav-icon {
    margin-right: 10px;
    font-size: 14px;
    width: 18px;
    text-align: center;
    flex-shrink: 0;
    color: inherit;
  }

  .sidebar-section {
    margin: 1rem 0;
    padding: 0 0.5rem;
  }

  .sidebar-section-title {
    color: #374151;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.75rem;
    padding: 0 12px;
  }

  /* Responsive adjustments */
  @media (max-width: 767.98px) {
    .modern-sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
      z-index: 1050;
      padding-top: 60px;
    }
  }

  /* Ensure sidebar doesn't interfere with main content */
  .sidebar {
    max-width: 100%;
  }
</style>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block modern-sidebar sidebar collapse">
  <div class="position-sticky pt-3">

    <!-- Main Navigation -->
    <div class="sidebar-section">
      <div class="sidebar-section-title">Main Menu</div>
      <ul class="nav flex-column sidebar-nav">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
            <i class="fas fa-chart-line nav-icon"></i>
            Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('current-events') ? 'active' : '' }}" href="/current-events">
            <i class="fas fa-calendar-check nav-icon"></i>
            Current Events
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('request-events') ? 'active' : '' }}" href="/request-events">
            <i class="fas fa-clock nav-icon"></i>
            Requested Events
          </a>
        </li>
      </ul>
    </div>

    <!-- Management Section -->
    <div class="sidebar-section">
      <div class="sidebar-section-title">Management</div>
      <ul class="nav flex-column sidebar-nav">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('category') ? 'active' : '' }}" href="/category">
            <i class="fas fa-tags nav-icon"></i>
            Categories
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('organizer') ? 'active' : '' }}" href="/organizer">
            <i class="fas fa-users nav-icon"></i>
            Organizers
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('user') ? 'active' : '' }}" href="/user">
            <i class="fas fa-user-friends nav-icon"></i>
            Users
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('city') ? 'active' : '' }}" href="/city">
            <i class="fas fa-map-marker-alt nav-icon"></i>
            Cities
          </a>
        </li>
      </ul>
    </div>

    <!-- Reports Section -->
    <div class="sidebar-section">
      <div class="sidebar-section-title">Reports</div>
      <ul class="nav flex-column sidebar-nav">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('payments') ? 'active' : '' }}" href="/payments">
            <i class="fas fa-credit-card nav-icon"></i>
            Payments
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>