<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Very Cool Blog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" 
  rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" 
  crossorigin="anonymous">
  <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
</head>
<body>
  <div class="container mt-4 ">
    <div class="p-3 rounded bg-light border shadow-sm">
      <h2 class="text-break">Edit Comment</h2>
      <form action="/edit-comment/{{$comment->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label for="body" class="form-label"></label>
          <textarea id="body" name="body" class="form-control" rows="5" required>{{$comment->body}}</textarea>
        </div>

        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">
          <button type="submit" class="btn p-3 btn-success text-break">Save Changes</button>
          <a href="/" class="btn btn-outline-secondary text-break p-3">Cancel</a>
        </div>

        <input type="hidden" name="post_id" value="{{ $comment->post_id }}">

      </form>

    </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" 
  crossorigin="anonymous"></script>
</body>
</html>