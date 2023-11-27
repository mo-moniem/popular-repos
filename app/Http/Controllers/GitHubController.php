<?php

namespace App\Http\Controllers;

use App\Http\Resources\RepoResource;
use App\Services\GitHubService;
use Illuminate\Http\Request;

class GitHubController extends Controller
{
    protected $gitHubService;

    public function __construct(GitHubService $gitHubService)
    {
        $this->gitHubService = $gitHubService;
    }

    public function getPopularRepositories(Request $request)
    {
        $repositories = $this->gitHubService->getPopularRepositories($request);

        return response()->json(['status'=>true,'repositories' => RepoResource::collection($repositories)]);
    }
}
