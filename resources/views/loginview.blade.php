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
<div class="container" style="max-width: 500px; padding-top: 30px;"> 
  <h2 class="mt-1 text-break">Login</h2>

  <form action="/login" method="POST">
    @csrf
    <div class="d-flex flex-column align-items-start mb-2">
      <label for="loginname" class="col-12 form-label text-wrap">Name</label>
      <input name="loginname" id="loginname" type="text" class="form-control">
    </div>

    <div class="d-flex flex-column align-items-start mb-2">
      <label for="loginpassword" class="col-12 form-label text-wrap">Password</label>
      <input name="loginpassword" id="loginpassword" type="password" class="form-control">
    </div>

    <div class="row">
      <div class="col-12 col-sm-6 mb-2">
        <a href="/registerview" class="btn btn-outline-secondary w-100 ">Register</a>
      </div>
      <div class="col-12 col-sm-6">
        <button class="btn btn-outline-success w-100">Login</button>
      </div>
    </div>
  </form>
</div>
</body>
</html>