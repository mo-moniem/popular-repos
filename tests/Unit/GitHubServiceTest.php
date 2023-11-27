<?php

namespace Tests\Unit;

use App\Services\GitHubService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use Illuminate\Contracts\Config\Repository as ConfigRepository;


class GitHubServiceTest extends TestCase
{
    protected $gitHubService;
    protected $mockHandler;

    public function setUp(): void
    {
        parent::setUp();
        // Create a mock handler for Guzzle client
        $this->mockHandler = new MockHandler();
        $handlerStack = HandlerStack::create($this->mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        // Create a mock instance of the ConfigRepository
        $config = $this->createMock(ConfigRepository::class);
        $config->method('get')->willReturn('token');
        // Create an instance of GitHubService using the mocked client and config
        $this->gitHubService = new GitHubService($client, $config);
    }

    public function testGetPopularRepositories()
    {
        // Define the expected response data
        $responseBody = json_encode([
            'items' => [
                ['name' => 'repo1'],
                ['name' => 'repo2'],
                ['name' => 'repo3'],
            ]
        ]);

        // Create a mocked response with the expected data
        $this->mockHandler->append(new Response(200, [], $responseBody));
        // Call the getPopularRepositories method
        $req = new Request();
        $req->merge([
            'language' => 'php',
            'order' => 'desc',
            'per_page' => 3,
        ]);
        $repositories = $this->gitHubService->getPopularRepositories($req);

        // Assert that the returned repositories match the expected data
        $this->assertEquals([
            ['name' => 'repo1'],
            ['name' => 'repo2'],
            ['name' => 'repo3'],
        ], $repositories);
    }
}
