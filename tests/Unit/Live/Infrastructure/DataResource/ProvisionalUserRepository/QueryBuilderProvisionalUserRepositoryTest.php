<?php

namespace Tests\Unit\Live\Infrastructure\DataResource\ProvisionalUserRepository;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Lee\Live\Domain\Model\User\ProvisionalUser\ProvisionalUserDto;
use Lee\Live\Infrastructure\DataResource\ProvisionalUserRepository\QueryBuilderProvisionalUserRepository;
use Tests\TestCase;

class QueryBuilderProvisionalUserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private QueryBuilderProvisionalUserRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new QueryBuilderProvisionalUserRepository;
    }

    public function test_store(): void
    {
        $dto = new ProvisionalUserDto(
            'test',
            'test@test.com',
            'test',
            '2021/01/01 00:00:00',
        );

        $this->repository->store($dto);

        $result = DB::table('provision_users')->where([
            'id' => 'test',
            'email' => 'test@test.com',
            'password' => 'test',
            'created_at' => '2021/01/01 00:00:00',
        ])->exists();

        $this->assertTrue($result);
    }
}
