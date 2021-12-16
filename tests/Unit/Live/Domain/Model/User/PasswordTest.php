<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Domain\Model\User;

use InvalidArgumentException;
use Lee\Live\Domain\Model\User\Password;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    /**
     * @dataProvider validateDataProvider
     * @param string $password
     * @return void
     */
    public function test_validate(string $password): void
    {
        $this->expectException(InvalidArgumentException::class);
        Password::createNew($password);
    }

    public function validateDataProvider(): array
    {
        return [
            '半角英数、記号以外が使用されている' => ['ああああああああ'],
            '文字数が8文字より少ない' => ['abcde1-'],
            '文字数が20文字より多い' => ['abcde1-aaaaaaaaaaaaaa'],
            '半角英が使用されていない' => ['12345678-'],
            '数字が使用されていない' => ['aaaaaaaa-'],
            '記号が使用されていない' => ['aaaaaaaa1'],
        ];
    }

    public function test_equal(): void
    {
        $password = Password::createNew('testPassword1@');
        $this->assertTrue($password->equal(Password::createNew('testPassword1@')));
    }

    /**
     * @dataProvider authorizeDataProvider
     * @param  Password $password1
     * @param  Password $password2
     * @param  bool     $expect
     * @return void
     */
    public function test_authorize(Password $password1, Password $password2, bool $expect): void
    {
        $this->assertEquals($expect, $password1->authorize($password2));
    }

    public function authorizeDataProvider(): array
    {
        return [
            '正常系' => [(Password::createNew('testPassword1@'))->hashed(), Password::createNew('testPassword1@'), true],
            'パスワードが間違っている' => [(Password::createNew('testPassword1@'))->hashed(), Password::createNew('testPassword11@'), false],
            'パスワードがハッシュされていない' => [(Password::createNew('testPassword1@')), Password::createNew('testPassword11@'), false],
            '判定用のパスワードがハッシュされている' => [(Password::createNew('testPassword1@'))->hashed(), (Password::createNew('testPassword1@'))->hashed(), false],
            'ハッシュの関係が逆' => [Password::createNew('testPassword1@'), (Password::createNew('testPassword1@'))->hashed(), false],
        ];
    }

    public function test_to_string(): void
    {
        $password = Password::createNew('testPassword1@', false);
        $this->assertEquals('**************', $password);
    }
}
