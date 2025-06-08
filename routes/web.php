<?php

use App\Models\Post;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\MyJsonController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\Api\PostApiController;

Route::get('/', function () {
    if (!auth()->check()) {
        return view('loginview');
    }
    //$posts = Post::where('user_id', auth()->id())->get();
    $posts = [];

    // check() checks if user is logged on by looking for valid session or token containing an user ID

    // Post maps to the posts table in DB. Can run queries, access relationships

    // with() performs eagerloading, so instead of a query to fetch all posts and then 
    //   a query for each individual user, its just one query for all posts and one query for all users
    // we need the user data cause post display involves displaying username
    // the data is passed to the returned view

    // 'user' as the arg to make it look for user() method
    $posts = Auth::check() ? Post::with(['user', 'comments.user'])->latest()->get() : [];
    return view('home', ['posts' => $posts]);
})->name('home');


Route::get('/getallposts', [PostApiController::class, 'getAllPosts']);

Route::get('/test-flash', function () {
    return redirect('/')->with('status', 'Test flash works.');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});


//[use this controller, run this method]
Route::get('/registerview', function () {
    return view('registerview');
});
Route::get('/loginview', function () {
    return view('loginview');
})->name('login');


Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout'])-> middleware('auth');
Route::post('/login', [UserController::class, 'login']);

//blog
Route::post('/create-post', [PostController::class, 'createPost'])-> middleware('auth');
Route::get('/edit-post/{post}', [PostController::class, 'showEditScreen'])-> middleware('auth');
Route::put('/edit-post/{post}', [PostController::class, 'updatePost'])-> middleware('auth');
Route::get('/edit-comment/{comment}', [PostController::class, 'showEditScreenComments'])-> middleware('auth');
Route::put('/edit-comment/{comment}', [PostController::class, 'updateComment'])-> middleware('auth');
Route::delete('/delete-post/{post}', [PostController::class, 'deletePost'])-> middleware('auth');
Route::delete('/delete-comment/{comment}', [PostController::class, 'deleteComment'])-> middleware('auth');

Route::post('/upload-file', [FileUploadController::class, 'uploadFile'])-> middleware('auth');


Route::get('/admin/dashboard', [AdminController::class, 'dashboard']) 
    -> middleware('auth');
    // look inside controller, run method, BUT first check if logged in using middleware

Route::get('/myjson', [MyJsonController::class, 'fetch']) -> middleware('auth');
Route::post('/add-comment', [PostController::class, 'addComment'])->middleware('auth');


require __DIR__ . '/auth.php';
