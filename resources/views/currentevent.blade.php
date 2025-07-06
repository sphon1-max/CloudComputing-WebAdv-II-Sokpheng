<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.84.0">
  <title>Dashboard Template · Bootstrap v5.0</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">



  <!-- Bootstrap core CSS -->
  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="assets/css/dashboard.css" rel="stylesheet">
</head>

<body>

  @include('layout.header')

  <div class="container-fluid">
    <div class="row">
      @include('layout.sidebar')
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Current Event</h1>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fas fa-check-circle"></i> {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <h2>
          <i class="fas fa-calendar-check text-success"></i>
          Published Events
          <small class="text-muted">({{ count($events) }} events)</small>
        </h2>

        @if(empty($events))
        <div class="alert alert-info">
          <i class="fas fa-info-circle"></i> No published events found.
        </div>
        @else
        <div class="table-responsive">
          <table class="table table-striped table-sm">

            <thead>
              <tr>
                <th scope="col">Event ID</th>
                <th scope="col">Event Name</th>
                <th scope="col">Category</th>
                <th scope="col">Location</th>
                <th scope="col">Status</th>
                <th scope="col">Ticket Price</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($events as $crev)
              {{-- Debug: {{ json_encode(array_keys($crev)) }} --}}
              <tr>
                <td>{{ $crev['id'] ?? 'N/A' }}</td>
                <td>
                  <strong>{{ $crev['title'] ?? $crev['event_name'] ?? 'N/A' }}</strong>
                  <br>
                  <small class="text-muted">{{ Str::limit($crev['description'] ?? '', 50) }}</small>
                </td>
                <td>{{ $crev['category']['name'] ?? $crev['category']['category_name'] ?? 'N/A' }}</td>
                <td>{{ $crev['city']['name'] ?? $crev['city'] ?? 'N/A' }}</td>
                <td>
                  <span class="badge bg-success">
                    <i class="fas fa-check"></i> {{ ucfirst($crev['status'] ?? 'unknown') }}
                  </span>
                </td>
                <td>
                  <strong>${{ number_format($crev['ticket_price'] ?? 0, 2) }}</strong>
                </td>
                <td>
                  <div class="d-flex gap-2">
                    <form action="{{ route('events.destroy', $crev['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Delete
                      </button>
                    </form>

                    <a href="{{ route('events.show', $crev['id']) }}" class="btn btn-sm btn-primary">
                      <i class="fas fa-eye"></i> See More
                    </a>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif
      </main>
    </div>
  </div>


  <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
  <script src="assets/js/dashboard.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>