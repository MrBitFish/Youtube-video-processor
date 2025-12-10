<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\YouTubeService;

class VideoController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function fetch(Request $request, YouTubeService $service)
    {
        $request->validate([
            'video_id' => ['required', 'regex:/^[A-Za-z0-9_-]{11}$/']
        ]);

        $data = $service->fetchVideo($request->video_id);

        if (!$data) {
            return back()
                ->withErrors(['video_id' => 'Video not found or API error.'])
                ->withInput();
        }

        return view('result', ['data' => $data]);
    }
}
