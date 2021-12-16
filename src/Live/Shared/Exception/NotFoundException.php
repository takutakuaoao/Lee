<?php

namespace Lee\Live\Shared\Exception;

use LogicException;

/**
 * データソースに問い合わせした際などに該当のデータが存在しなかった場合に返す例外
 */
final class NotFoundException extends LogicException
{
}
