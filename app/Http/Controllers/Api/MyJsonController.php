<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Termwind\Components\Hr;
use Illuminate\Support\Facades\Auth;


class MyJsonController extends Controller
{
    public function fetch()
    {
        if (!auth()->user()->isAdmin()){
            abort(403, 'Unauthorized');
            //forbidden
        }

        $userIds = [1, 2, 3, 4, 5];
        $allPosts = [];

        foreach($userIds as $id){
            $response = Http::get('https://jsonplaceholder.typicode.com/posts', ['userId' => $id
            ]);

            if ($response->successful()){
                $allPosts[$id] = $response->json();
            } else {
                $allPosts[$id] = ['error' => 'Failed to fetch'];
            }
         }
        


        return view('admin.apiview', ['postsByUser' => $allPosts]);
    }
}
