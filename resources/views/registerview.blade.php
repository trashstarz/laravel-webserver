<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Very Cool Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" 
    crossorigin="anonymous">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
</head>
<body>
  <div class="container" style="max-width: 500px; padding-top:30px;">
    <h2 class="mt-1">Register</h2>
    <form action="/register" method="POST">
      @csrf
      <div class="mb-1">
        <label for="name" class="form-label">Name</label>
          <input name="name" id="registername"  type="text" class="form-control">
      </div>
      <div class="mb-1">
        <label for="email" class="form-label">E-mail</label>
          <input name="email" id="email" type="text" class="form-control">
      </div>
      <div class="mb-1">
        <label for="password" class="form-label">Password</label>
        <input name="password" id="password" type="password" class="form-control">
      </div>

      <div class="d-flex justify-content-end">
        <div class="col-12 col-sm-6">
          <button class="btn btn-outline-success mt-2 mb-5 w-100">Register</button>
        </div>
      </div>
  </form>
  </div>

</body>
</html>