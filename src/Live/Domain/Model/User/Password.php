<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\User;

use InvalidArgumentException;
use Lee\Live\Shared\ValueObject;

/**
 * [パスワード仕様]
 * 文字数：8文字以上20字以内
 * 文字種類：半角英数字か_-@$%&の記号
 * 制限:半角英と半角数字と記号を一文字ずつ
 */
final class Password implements ValueObject
{
    private function __construct(
        private string $value,
        private bool $isHash = false,
    ) {
        if (!$isHash && preg_match('/^(?=.*[A-Za-z])(?=.*[0-9])(?=.*[_\-@$%&])[0-9a-zA-Z_\-@$%&]{8,20}$/', $value) === 0) {
            throw new InvalidArgumentException('');
        }
    }

    public static function createNew(string $password): self
    {
        return new self($password);
    }

    public static function createHashed(string $hashedPassword): self
    {
        return new self($hashedPassword, true);
    }

    public function hashed(): self
    {
        if ($this->isHash) {
            return $this;
        }

        return new self(password_hash($this->value, PASSWORD_DEFAULT), true);
    }

    public function authorize(Password $password): bool
    {
        if (!$this->isHash || $password->isHash) {
            return false;
        }

        return password_verify($password->value, $this->value);
    }

    public function isRawPassword(): bool
    {
        return !$this->isHash;
    }

    public function equal(ValueObject $value): bool
    {
        return get_class($this) === get_class($value) &&
            $this->value === $value->value;
    }

    public function getValue(): string
    {
        if ($this->isRawPassword()) {
            throw new InvalidArgumentException('GetValue method cannot use to hashed.');
        }

        return $this->value;
    }

    public function __toString(): string
    {
        return str_repeat('*', mb_strlen($this->value, 'UTF8'));
    }
}
