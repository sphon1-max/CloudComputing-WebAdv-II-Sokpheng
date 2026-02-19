<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/image/mylogo.png') }}">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">

    

    <!-- Bootstrap core CSS -->
<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

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
        <h1 class="h2">Dashboard</h1>
      </div>
      <div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-3" style="background-color: #e0f7fa;">
            <div class="card-header border-0 fw-bold" style="color: #004d40;">Total Income</div> <div class="card-body">
                <h5 class="card-title" style="color: #00796b;">${{ number_format($totalCommission, 2) }}</h5> <p class="card-text" style="color: #26a69a;">Sum of all ticket prices sold.</p> </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-3" style="background-color: #e3f2fd;">
            <div class="card-header border-0 fw-bold" style="color: #0d47a1;">Total Users</div> <div class="card-body">
                <h5 class="card-title" style="color:rgb(44, 59, 73);">{{ $total_users }}</h5> <p class="card-text" style="color:rgb(53, 70, 83);">Registered users in the system.</p> </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-3" style="background-color: #fffde7;">
            <div class="card-header border-0 fw-bold" style="color: #f57f17;">Total Organizers</div> <div class="card-body">
                <h5 class="card-title" style="color:rgb(95, 75, 24);">{{ $total_organizers }}</h5> <p class="card-text" style="color:rgb(61, 61, 57);">Active event organizers.</p> </div>
        </div>
    </div>
</div>


      <h2>All Events</h2>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          
          <thead>
            <tr>
              <th scope="col">Event ID</th>
              <th scope="col">Event Name</th>
              <th scope="col">Category</th>
              <th scope="col">Location</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
          @foreach($v_evd as $evd)
            <tr>
              <td>{{ $evd->id }}</td>
              <td>{{ $evd->title }}</td>
              <td>{{ $evd->category->name }}</td>
              <td>{{ $evd->city->name }}</td>
              <td>{{ $evd->status }}</td>
              <td>
                <div class="d-flex gap-2">
                  <form action="{{ route('events.destroy', $evd->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                  </form>

                  <a href="{{ route('events.show', $evd->id) }}" class="btn btn-sm">See More</a>
                </div>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>


    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="assets/js/dashboard.js"></script>
      

  </body>
</html>
