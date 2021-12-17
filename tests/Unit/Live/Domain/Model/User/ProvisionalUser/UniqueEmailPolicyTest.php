<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Domain\Model\User\ProvisionalUser;

use Lee\Live\Domain\Model\User\Email;
use Lee\Live\Domain\Model\User\Password;
use Lee\Live\Domain\Model\User\ProvisionalUser\ProvisionalUserFactory;
use Lee\Live\Domain\Model\User\ProvisionalUser\UniqueEmailPolicy;
use Lee\Live\Infrastructure\DataResource\UserRepository\NonConnectionUserRepository;
use PHPUnit\Framework\TestCase;

class UniqueEmailPolicyTest extends TestCase
{
    public function test_satisfied_by(): void
    {
        $repository             = new NonConnectionUserRepository;
        $repository->returnBool = true;
        $policy                 = new UniqueEmailPolicy($repository);
        $provisionalUser        = (new ProvisionalUserFactory)->createNew(new Email('test@test.com'), Password::createNew('test@123'));

        $this->assertFalse($policy->satisfiedBy($provisionalUser));

        $repository->returnBool = false;
        $this->assertTrue($policy->satisfiedBy($provisionalUser));
    }
}
