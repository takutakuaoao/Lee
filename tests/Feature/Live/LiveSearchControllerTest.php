<?php

declare(strict_types=1);

namespace Tests\Feature\Live;

use Lee\Live\Application\Search\SearchQueryService;
use Lee\Live\Infrastructure\DataResource\LiveSearchQueryService\InMemoryLiveSearchQueryService;
use Tests\TestCase;

class LiveSearchControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->app->bind(SearchQueryService::class, function () {
            return $this->makeTestData();
        });
    }

    public function test_success_response(): void
    {
        $response = $this->get(route('get.lives', ['live_house_name' => '武道館']));
        $data     = $response['data'];

        $this->assertEquals(200, $response['status']);
        $this->assertEquals(1, $data['lives'][0]['id']);
    }

    public function test_not_find_result(): void
    {
        $response = $this->get(route('get.lives', ['prefecture' => '埼玉']));
        $data     = $response['data'];

        $this->assertEquals(0, count($data['lives']));
    }

    public function test_invalid_query(): void
    {
        $response = $this->get(route('get.lives', ['live_house_name' => '武道館', 'not-exists' => 'test']));
        $data     = $response['data'];

        $this->assertEquals(200, $response['status']);
        $this->assertEquals(1, $data['lives'][0]['id']);
    }

    public function test_all_search(): void
    {
        $response = $this->get(route('get.lives'));
        $data     = $response['data'];

        $this->assertEquals(2, count($data['lives']));
        $this->assertEquals(1, $data['lives'][0]['id']);
        $this->assertEquals(2, $data['lives'][1]['id']);
    }

    private function makeTestData(): InMemoryLiveSearchQueryService
    {
        $database = [
            [
                'id'                     => '1',
                'live_house_name'        => '武道館',
                'ticket_sale_start_date' => '2021/10/10 00:00:00',
                'live_start_date'        => '2021/11/10 19:00:00',
                'actors'                 => ['artist1', 'artist2'],
                'prefecture'             => '東京',
            ],
            [
                'id'                     => '2',
                'live_house_name'        => 'サウンドクルー',
                'ticket_sale_start_date' => '2021/9/10 00:00:00',
                'live_start_date'        => '2021/11/10 19:00:00',
                'actors'                 => ['artist3', 'artist4', 'artist5'],
                'prefecture'             => '北海道',
            ],
        ];

        return (new InMemoryLiveSearchQueryService())->insert($database[0])->insert($database[1]);
    }
}
