<?php

declare(strict_types=1);

namespace App\Http\Controllers\Live;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lee\Live\Application\Search\SearchQuery\SearchQueryFactory;
use Lee\Live\Application\Search\SearchQueryService;
use Lee\Live\Application\Search\SearchViewModel;

class LiveIndexActionController extends Controller
{
    /**
     * @param  Request            $request
     * @param  SearchQueryService $searchService
     * @return void
     */
    public function __invoke(Request $request, SearchQueryService $searchService)
    {
        $searchQuery = (new SearchQueryFactory([$request->all()]))->factory();
        $response    = $searchService->search($searchQuery);

        return [
            'status' => 200,
            'data'   => [
                'lives' => array_map(fn (SearchViewModel $aViewModel) => $aViewModel->jsonSerialize(), $response),
            ],
        ];
    }
}
