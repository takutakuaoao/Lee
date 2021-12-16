<?php

declare(strict_types=1);

namespace Lee\Live\Infrastructure\DataResource\ProvisionalUserRepository;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Lee\Live\Domain\Model\User\ProvisionalUser\ProvisionalUserDto;

final class QueryBuilderProvisionalUserRepository
{
    private Builder $builder;

    public function __construct()
    {
        $this->builder = DB::table('provision_users');
    }

    public function store(ProvisionalUserDto $dto): void
    {
        $this->builder->insert([
            'id'         => $dto->getId(),
            'email'      => $dto->getEmail(),
            'password'   => $dto->getPassword(),
            'created_at' => $dto->getDate(),
        ]);
    }
}
