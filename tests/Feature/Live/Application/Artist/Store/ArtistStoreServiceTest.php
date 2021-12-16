<?php

declare(strict_types=1);

namespace Tests\Feature\Live\Application\Artist\Store;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Lee\Live\Application\Artist\Store\ArtistStoreRequest;
use Lee\Live\Application\Artist\Store\ArtistStoreService;
use Lee\Live\Infrastructure\DataResource\ArtistRepository\NonConnectionDataResourceArtistRepository;
use Tests\TestCase;

class ArtistStoreServiceTest extends TestCase
{
    public function test_store_success(): void
    {
        $request  = new ArtistStoreRequest('アーティスト名');
        $service  = new ArtistStoreService($repository = new NonConnectionDataResourceArtistRepository);
        $response = $service->execute($request);

        $this->assertTrue($response->getResult());

        $this->assertEquals(1, count($repository->storeArtist));
        $this->assertEquals('アーティスト名', $repository->storeArtist[0]->getName());
    }
}
