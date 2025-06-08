<div class="container mt-3">
    <h2>API Posts by User</h2>

    @foreach ($postsByUser as $userId => $posts)
        <div class="mb-4 p-3 border bg-light">
            <h4>User ID: {{ $userId }}</h4>
            @if(isset($posts['error']))
                <p class="text-danger">{{ $posts['error'] }}</p>
            @else
                <ul>
                    @foreach ($posts as $post)
                        <li><strong>{{ $post['title'] }}</strong></li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endforeach
</div>