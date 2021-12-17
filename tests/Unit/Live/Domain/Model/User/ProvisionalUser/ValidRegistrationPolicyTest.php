<?php

namespace Tests\Unit\Live\Domain\Model\User\ProvisionalUser;

use Carbon\Carbon;
use Lee\Live\Domain\Model\User\Email;
use Lee\Live\Domain\Model\User\Password;
use Lee\Live\Domain\Model\User\ProvisionalUser\ProvisionalDate;
use Lee\Live\Domain\Model\User\ProvisionalUser\ProvisionalUserFactory;
use Lee\Live\Domain\Model\User\ProvisionalUser\ValidFormalRegistrationDatePolicy;
use Lee\Live\Domain\Model\User\UserId;
use PHPUnit\Framework\TestCase;

class ValidRegistrationPolicyTest extends TestCase
{
    public function test_satisfied_by(): void
    {
        $provisionalUser = (new ProvisionalUserFactory)->create(
            UserId::issueNewId(),
            new Email('test@test.com'),
            Password::createHashed('test'),
            new ProvisionalDate('2021/01/01 00:00:00'),
        );

        $policy = new ValidFormalRegistrationDatePolicy(Carbon::createFromTimeString('2021/01/01 01:00:00'));
        $this->assertTrue($policy->satisfiedBy($provisionalUser));

        $policy = new ValidFormalRegistrationDatePolicy(Carbon::createFromTimeString('2021/01/01 01:00:01'));
        $this->assertFalse($policy->satisfiedBy($provisionalUser));
    }
}
