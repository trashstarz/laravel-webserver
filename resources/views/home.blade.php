<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" 
   rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" 
   crossorigin="anonymous">
   <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
   <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

  <title>Very Cool Blog</title>
</head>


<body>
  
  @if (session()->has('message'))
  <div class="container">
    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
      {{ session('message') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  </div>
@endif

@auth
  {{-- LOGGED IN --}}

  <div class="container">

    <div class="d-flex flex-column justify-content-between flex-sm-row align-items-start mb-4">

      <div class="mb-1 mb-md-0 text-break">
        <h1>Welcome, <small>{{ auth()->user()->name }}</small></h1>
      </div>
    
      <div class="d-flex flex-column flex-sm-row align-items-center w-auto">
        @if(auth()->user()->isAdmin())
          <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline-warning mb-2 mt-2 me-1 p-2 uniform-btn">Admin</a>
        @endif
    
        <form action="/logout" method="POST">
          @csrf
          <button type="submit" class="btn btn-outline-danger mb-2 mt-0 mt-sm-2 p-2 uniform-btn text-break">Logout</button>
        </form>
      </div>
    
    </div>


   <button id="backToTop" class="btn btn-outline-dark" onclick="scrollToTop()">↑</button>
   
   {{-- add post --}}
   <div class="container shadow p-3 border rounded-3 bg-light border-dark text-break">
    <div class="row">
      <div class="col-12">
        <h2>Create new post</h2>
      </div>
    </div>
          <form action="/create-post" method="POST" enctype="multipart/form-data">
            @csrf
  
            <div class="mb-1">
                <label for="title" class="form-label">Post Title</label>
                <input type="text" id="title" name="title" class="form-control" required>  
            </div>
  
            <div class="mb-1">
                <label for="body" class="form-label">Post Body</label>
                <textarea id="body" name="body" class="form-control"1 rows="5" required></textarea>  
            </div>
  
            <label for="image" class="form-label">Attach an image</label><br>
            <div class="row">
              <div class="col-12 col-sm-6">
                <input type="file" id="image" name="image" class="form-control text-wrap mt-2 mb-2 w-xxs-100 w-sm-100">
              </div>
              <div class="col-12 col-sm-6 text-start text-sm-end">
                <button type="submit" class="btn btn-outline-success shadow w-xxs-100 w-sm-50 mt-2 p-3 uniform-btn">Save post</button>
              </div>
            </div>
          </form>

    </div>
   </div>

  <br>
 
   {{-- all post display --}}
   <div class="container">
    <div class="row mb-2 p-5">
      <div class="row ">
        <div class="col-12 text-break">
          <h2>All Posts</h2>
        </div>
      </div>
      @foreach ($posts as $post)
        <div class="p-3 mb-3 rounded bg-light border shadow ">

          <div class="row mb-3">

            <div class="col-12 col-sm-9 text-break">
              <h4 class="mb-1"> {{$post['title']}}</h4>
              <h5><small class="text-muted">{{$post->user->name}}</small></h5>
            </div>

            <div class="col-12 col-sm-3 text-start text-sm-end text-break">
              <h6>
                <small class="text-muted">
                  {{ $post->created_at->format('F j, Y') }}<br>
                  {{ $post->created_at->format('g:i a') }}
                </small>
              </h6>
            </div>

          </div>


        <p class="mb-2 text-break">{{$post['body']}}</p>

        @if ($post->path)
          {{-- asset() - laravel helper function that returns a full URL to a file in the public/ directory--}}
          {{-- storage - to access em in the browser, they need to be symlinked to public/storage --}}
          {{-- so asset(storage/) means "give the full url to the file in public/storage --}}
          <div class="row">
            <div class="col-12">
              <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{$post->id}}">
                <img src="{{ asset('storage/' . $post->path) }}" alt="Post image" class="img-fluid mb-2 rounded shadow-sm w-100" style="cursor:pointer">
              </a>
            </div>
          </div>

          <div class="modal fade imageModal" id="imageModal{{$post->id}}" tabindex="-1" aria-labelledby="imageModalLabel{{$post->id}}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
              <div class="modal-content">
                <div class="modal-body">
                  <img src="{{asset('storage/' . $post->path)}}" alt="Post image" class="img-fluid" style="width:100vw; height:auto; max-width: 100%; object-fit: contain">
                </div>
              </div>
            </div>
          </div>
        @endif
        <br>

        @foreach($post->comments as $comment)
            <div class="comment">
                <strong>{{ $comment->user->name}}</strong> <small>{{ $comment->created_at }}</small>
                <p>{{ $comment->body }}</p>
            </div>

            @if(auth()->id() === $comment->user_id)
            {{-- Edit/Delete for post owner --}}
            <div class="d-flex flex-column flex-sm-row justify-content-start gap-2 mt-2">
              <div>
                <a href="/edit-comment/{{$comment->id}}" class="btn btn-outline-secondary uniform-btn">Edit</a>
              </div>
    
              <div>
                <form action="/delete-comment/{{$comment->id}}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-outline-danger uniform-btn">Delete</button>
                </form>
              </div>

            </div>
    
            @endif
            
        @endforeach

        <form action="/add-comment" method="POST" class="mt-2 mb-2">
          @csrf
          <input type="hidden" name="post_id" value="{{ $post->id }}">

          <div class="row g-2 align-items-start">
            <div class="col-12 col-sm-10">
              <textarea name="body" id="body" class="form-control" rows="1" placeholder="Write a comment..." required></textarea>
            </div>
            <div class="col-12 col-sm-2 text-md-end">
              <button type="submit" class="btn btn-outline-success w-100">Send</button>
            </div>
          </div>
        </form>

        @if(auth()->id() === $post->user_id)
        {{-- Edit/Delete for post owner --}}
        <div class="d-flex justify-content-start gap-2 mt-2">
          <a href="/edit-post/{{$post->id}}" class="btn btn-outline-secondary uniform-btn">Edit</a>

          <form action="/delete-post/{{$post->id}}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger uniform-btn">Delete</button>
          </form>
        </div>

        @endif
        
        @if(auth()->user()->isAdmin() && auth()->id() !== $post->user_id)
        {{-- Admin Delete (when not post owner) --}}
        <div class="d-flex flex-column flex-sm-row justify-content-end align-items-end mt-3">
          <form action="/delete-post/{{$post->id}}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger">Delete</button>
          </form>
        </div>
      @endif


      

      </div>
    @endforeach
  </div>
@else
how did we get here
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" 
  crossorigin="anonymous"></script>
<script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
