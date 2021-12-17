<?php

namespace Tests\Unit\Live\Domain\Model\User\ProvisionalUser;

use Carbon\Carbon;
use Lee\Live\Domain\Model\User\Email;
use Lee\Live\Domain\Model\User\Password;
use Lee\Live\Domain\Model\User\ProvisionalUser\FormalRegisterPolicy;
use Lee\Live\Domain\Model\User\ProvisionalUser\ProvisionalDate;
use Lee\Live\Domain\Model\User\ProvisionalUser\ProvisionalUser;
use Lee\Live\Domain\Model\User\ProvisionalUser\ProvisionalUserFactory;
use Lee\Live\Domain\Model\User\ProvisionalUser\UniqueEmailPolicy;
use Lee\Live\Domain\Model\User\ProvisionalUser\ValidFormalRegistrationDatePolicy;
use Lee\Live\Domain\Model\User\UserId;
use Lee\Live\Infrastructure\DataResource\UserRepository\NonConnectionUserRepository;
use PHPUnit\Framework\TestCase;

class FormalRegisterPolicyTest extends TestCase
{
    private ProvisionalUser $testUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->testUser = (new ProvisionalUserFactory)->create(
            UserId::issueNewId(),
            new Email('test@tes.com'),
            Password::createHashed('test'),
            new ProvisionalDate('2021/01/01 00:00:00'),
        );
    }

    public function test_success_satisfied_by(): void
    {
        $policy = new FormalRegisterPolicy(
            new ValidFormalRegistrationDatePolicy(Carbon::createFromTimeString('2021/01/01 01:00:00')),
            new UniqueEmailPolicy(new NonConnectionUserRepository)
        );

        $this->assertTrue($policy->satisfiedBy($this->testUser));
    }

    public function test_failed_satisfied_by_when_not_unique_email(): void
    {
        $repository = new NonConnectionUserRepository;
        $repository->returnBool = true;

        $policy = new FormalRegisterPolicy(
            new ValidFormalRegistrationDatePolicy(Carbon::createFromTimeString('2021/01/01 01:00:00')),
            new UniqueEmailPolicy($repository),
        );

        $this->assertFalse($policy->satisfiedBy($this->testUser));
    }

    public function test_failed_satisfied_by_when_invalid_formal_date(): void
    {
        $policy = new FormalRegisterPolicy(
            new ValidFormalRegistrationDatePolicy(Carbon::createFromTimeString('2021/01/01 01:00:01')),
            new UniqueEmailPolicy(new NonConnectionUserRepository),
        );

        $this->assertFalse($policy->satisfiedBy($this->testUser));
    }
}
