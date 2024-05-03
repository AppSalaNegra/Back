<?php

namespace Tests\Posts\Infrastructure;

use App\Events\Domain\Event;
use App\Posts\Domain\Post;
use App\Posts\Domain\PostEncodeFailed;
use App\Posts\Domain\PostsRepository;
use App\Posts\Infrastructure\PostEncoder;
use App\Posts\Infrastructure\PostsDbUpdater;
use App\Shared\Infrastructure\ActuaApiFailed;
use App\Shared\Infrastructure\ActuaApiHandler;
use Mockery;
use Tests\TestCase;

class PostsDbUpdaterTest extends TestCase
{
    private array $posts = [
        [
            "dateTime" => "2024-05-03T22:30:00",
            "title" => "TupperSex Magic 3/05",
            "excerpt" => "",
            "url" => "https://sala-negra.com/evento/tupper-magic/tuppersex305/",
            "slug" => "tuppersex305",
            "thumbnail_url" => false,
            "cats" => false,
            "status" => "other",
        ]
    ];

    public function testItShouldPersistPostData(): void
    {
        $apiHandler = Mockery::mock(ActuaApiHandler::class);
        $encoder = Mockery::mock(PostEncoder::class);
        $repository = Mockery::mock(PostsRepository::class);
        $updater = new PostsDbUpdater($repository, $apiHandler, $encoder);
        $post = Mockery::mock(Post::class);

        $apiHandler->shouldReceive('getPostsData')->once()->andReturn($this->posts);
        $repository->shouldReceive('findByTitle')->once()->andReturnNull();
        $encoder->shouldReceive('parseDataToPost')->once()->andReturn($post);
        $repository->shouldReceive('save')->once()->andReturnNull();

        $updater->persistIfNotExists();

        $this->assertTrue(true);
    }

    public function testItShouldThrowExceptionWhenEncodePostFailed(): void
    {
        $this->expectException(PostEncodeFailed::class);

        $repository = Mockery::mock(PostsRepository::class);
        $apiHandler = Mockery::mock(ActuaApiHandler::class);
        $encoder = Mockery::mock(PostEncoder::class);
        $updater = new PostsDbUpdater($repository, $apiHandler, $encoder);

        $apiHandler->shouldReceive('getPostsData')->once()->andReturn($this->posts);
        $repository->shouldReceive('findByTitle')->once()->andReturn(null);
        $encoder->shouldReceive('parseDataToPost')
            ->withArgs($this->posts)
            ->once()
            ->andThrow(PostEncodeFailed::class);

        $updater->persistIfNotExists();
    }
    public function testItShouldThrowExceptionWhenApiFailsOnPostGetPosts(): void
    {
        $this->expectException(ActuaApiFailed::class);

        $repository = Mockery::mock(PostsRepository::class);
        $apiHandler = Mockery::mock(ActuaApiHandler::class);
        $encoder = Mockery::mock(PostEncoder::class);
        $updater = new PostsDbUpdater($repository, $apiHandler, $encoder);

        $apiHandler->shouldReceive('getPostsData')->once()->andThrow(ActuaApiFailed::class);

        $updater->persistIfNotExists();
    }
}
