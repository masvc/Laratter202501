<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTweetRequest;
// 🔽 追加
use App\Http\Requests\UpdateTweetRequest;
use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Services\TweetService;
// 🔽 追加
use Illuminate\Support\Facades\Gate;


class TweetController extends Controller
{
    // 🔽 追加
    protected $tweetService;

    // 🔽 追加
    public function __construct(TweetService $tweetService)
    {
        $this->tweetService = $tweetService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 🔽 追加
        Gate::authorize('viewAny', Tweet::class);

        $tweets = $this->tweetService->allTweets();
        return view('tweets.index', compact('tweets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 🔽 追加
        Gate::authorize('create', Tweet::class);

        return view('tweets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTweetRequest $request)
    {
        // 🔽 追加
        Gate::authorize('create', Tweet::class);

        $tweet = $this->tweetService->createTweet($request);
        return redirect()->route('tweets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
        // 🔽 追加
        Gate::authorize('view', $tweet);

        return view('tweets.show', compact('tweet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet)
    {
        // 🔽 追加
        Gate::authorize('update', $tweet);

        return view('tweets.edit', compact('tweet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTweetRequest $request, Tweet $tweet)
    {
        // 🔽 追加
        Gate::authorize('update', $tweet);

        $updatedTweet = $this->tweetService->updateTweet($request, $tweet);
        return redirect()->route('tweets.show', $tweet);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        // 🔽 追加
        Gate::authorize('delete', $tweet);

        $this->tweetService->deleteTweet($tweet);
        return redirect()->route('tweets.index');
    }
}
