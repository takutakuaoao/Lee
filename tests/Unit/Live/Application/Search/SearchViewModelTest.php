<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Application\Search;

use Lee\Live\Application\Search\SearchViewModel;
use Lee\Live\Shared\Date;
use Lee\Live\Domain\Model\Live\Id;
use Lee\Live\Domain\Model\Live\Name;
use Lee\Live\Domain\Model\Live\LiveHouse\Prefecture;
use Lee\Live\Domain\Model\Live\LiveId;
use PHPUnit\Framework\TestCase;

class SearchViewModelTest extends TestCase
{
    public function test_get_values(): void
    {
        $viewModel = new SearchViewModel(
            new LiveId('1'),
            new Name('サウンドクルー'),
            new Date(2021, 1, 1, 12, 10),
            new Date(2021, 1, 2, 0, 0),
            [new Name('artistName1'), new Name('artistName2')],
            new Prefecture('北海道'),
        );
        $json = $viewModel->jsonSerialize();

        $this->assertEquals($json['id'], '1');
        $this->assertEquals($json['liveHouseName'], 'サウンドクルー');
        $this->assertEquals($json['ticketSaleStartDate'], '2021年1月1日 12時10分');
        $this->assertEquals($json['liveStartDate'], '2021年1月2日 00時00分');
        $this->assertEquals($json['actors'][0], 'artistName1');
        $this->assertEquals($json['actors'][1], 'artistName2');
        $this->assertEquals($json['prefecture'], '北海道');
    }
}
