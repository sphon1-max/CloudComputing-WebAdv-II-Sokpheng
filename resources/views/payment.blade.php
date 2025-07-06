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
        <h1 class="h2">City</h1>
      </div>

      <h2>All Events</h2>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          
                  
            <thead>
                  <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Event</th>
                        <th>Ticket Type</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Commission (10%)</th>
                  </tr>
            </thead>
            <tbody>
                  @php $totalCommission = 0; @endphp
                  @foreach($payments as $index => $p)
                        @php
                        $amount = $p->payment->amount ?? 0;
                        $commission = $amount * 0.10;
                        $totalCommission += $commission;
                        @endphp
                        <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $p->users->first_name ?? 'N/A' }}</td>
                        <td>{{ $p->ticket->event->event_name ?? 'N/A' }}</td>
                        <td>{{ $p->ticket->ticket_type ?? 'N/A' }}</td>
                        <td>{{ $p->quantity ?? 1 }}</td>
                        <td>${{ number_format($amount, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->created_at)->format('Y-m-d H:i') }}</td>
                        <td>${{ number_format($commission, 2) }}</td>
                        </tr>
                  @endforeach
            </tbody>
            <tfoot>
                  <tr>
                        <td colspan="6"></td>
                        <th>Total Commission</th>
                        <td><strong>${{ number_format($totalCommission, 2) }}</strong></td>
                  </tr>
            </tfoot>
            </table>

      </div>
    </main>
  </div>
</div>


    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="assets/js/dashboard.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
