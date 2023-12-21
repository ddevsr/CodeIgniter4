<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\Session\Exceptions;

use CodeIgniter\Exceptions\FrameworkException;
use PHPUnit\Framework\Attributes\CodeCoverageIgnore;

class SessionException extends FrameworkException
{
    public static function forMissingDatabaseTable()
    {
        return new static(lang('Session.missingDatabaseTable'));
    }

    public static function forInvalidSavePath(?string $path = null)
    {
        return new static(lang('Session.invalidSavePath', [$path]));
    }

    public static function forWriteProtectedSavePath(?string $path = null)
    {
        return new static(lang('Session.writeProtectedSavePath', [$path]));
    }

    public static function forEmptySavepath()
    {
        return new static(lang('Session.emptySavePath'));
    }

    public static function forInvalidSavePathFormat(string $path)
    {
        return new static(lang('Session.invalidSavePathFormat', [$path]));
    }

    /**
     * @deprecated
     */
    #[CodeCoverageIgnore]
    public static function forInvalidSameSiteSetting(string $samesite)
    {
        return new static(lang('Session.invalidSameSiteSetting', [$samesite]));
    }
}
