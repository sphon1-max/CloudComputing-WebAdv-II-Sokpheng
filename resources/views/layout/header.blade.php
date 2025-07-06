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

  <!-- Search Section -->
  <div class="flex-grow-1 mx-3 d-none d-lg-block">
    <div class="search-container mx-auto">
      <input class="form-control search-input" type="text"
        placeholder="Search events, organizers, users..." aria-label="Search" id="headerSearch">
    </div>
  </div>

  <!-- Right Side - Compact Design -->
  <div class="d-flex align-items-center admin-section">
    <!-- Notifications - Only on larger screens -->
    <div class="position-relative me-2 d-none d-xl-block">
      <i class="fas fa-bell header-icon"></i>
      <span class="notification-badge">3</span>
    </div>

    <!-- Quick Stats - Only on very large screens -->
    <div class="d-none d-xxl-flex align-items-center me-2">
      <small class="text-white-50">
        <i class="fas fa-calendar-check me-1"></i>
        <span id="live-events-count">{{ session('events_count', '0') }}</span>
      </small>
    </div>

    <!-- Admin Section - Simplified -->
    <div class="d-flex align-items-center">
      <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-2"
        style="width: 32px; height: 32px;">
        <i class="fas fa-user-shield text-primary" style="font-size: 14px;"></i>
      </div>

      <div class="d-none d-md-block me-2">
        <small class="text-white fw-bold">{{ session('admin_first_name', 'Admin') }}</small>
      </div>

      <!-- Dropdown Menu -->
      <div class="dropdown">
        <button class="btn btn-sm text-white border-0" type="button"
          data-bs-toggle="dropdown" aria-expanded="false"
          style="background: rgba(255,255,255,0.1); border-radius: 20px; padding: 5px 10px;">
          <i class="fas fa-chevron-down"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" style="min-width: 150px;">
          <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
          <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}"
              onclick="return confirm('Are you sure you want to logout?')">
              <i class="fas fa-sign-out-alt me-2"></i>Logout
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</header>

<script>
  // Enhanced search functionality
  document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('headerSearch');

    if (searchInput) {
      // Enhanced search with debouncing
      let searchTimeout;
      searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase().trim();

        // Clear previous timeout
        clearTimeout(searchTimeout);

        // Debounce search by 300ms
        searchTimeout = setTimeout(() => {
          if (searchTerm.length >= 2) {
            performSearch(searchTerm);
          } else if (searchTerm.length === 0) {
            clearSearchResults();
          }
        }, 300);
      });

      // Handle Enter key
      searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
          e.preventDefault();
          const searchTerm = e.target.value.toLowerCase().trim();
          if (searchTerm.length >= 2) {
            performSearch(searchTerm);
          }
        }
      });
    }
  });

  function performSearch(searchTerm) {
    console.log('Searching for:', searchTerm);

    // Here you can add actual search functionality
    // For example: redirect to a search results page
    // window.location.href = `/search?q=${encodeURIComponent(searchTerm)}`;

    // Or show a dropdown with search results
    showSearchSuggestions(searchTerm);
  }

  function showSearchSuggestions(searchTerm) {
    // Placeholder for search suggestions
    // You can implement a dropdown with search results here
    console.log('Showing suggestions for:', searchTerm);
  }

  function clearSearchResults() {
    // Clear any search results or suggestions
    console.log('Clearing search results');
  }

  // Update live stats (placeholder)
  function updateLiveStats() {
    // This would fetch real-time data from your API
    // For now, it's just a placeholder
  }

  // Update stats every 30 seconds
  setInterval(updateLiveStats, 30000);
</script>