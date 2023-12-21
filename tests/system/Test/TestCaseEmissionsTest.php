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

namespace CodeIgniter\Test;

use CodeIgniter\HTTP\Response;
use Config\App;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;

/**
 * This test suite has been created separately from
 * TestCaseTest because it messes with output
 * buffering from PHPUnit, and the individual
 * test cases need to be run as separate processes.
 *
 * @internal
 */
#[Group('SeparateProcess')]
final class TestCaseEmissionsTest extends CIUnitTestCase
{
    #[PreserveGlobalState(false)]
    #[RunInSeparateProcess]
    public function testHeadersEmitted(): void
    {
        $response = new Response(new App());
        $response->pretend(false);

        $body = 'Hello';
        $response->setBody($body);

        $response->setCookie('foo', 'bar');
        $this->assertTrue($response->hasCookie('foo'));
        $this->assertTrue($response->hasCookie('foo', 'bar'));

        // send it
        ob_start();
        $response->send();
        if (ob_get_level() > 0) {
            ob_end_clean();
        }

        // and what actually got sent?; test both ways
        $this->assertHeaderEmitted('Set-Cookie: foo=bar;');
        $this->assertHeaderEmitted('set-cookie: FOO=bar', true);
    }

    #[PreserveGlobalState(false)]
    #[RunInSeparateProcess]
    public function testHeadersNotEmitted(): void
    {
        $response = new Response(new App());
        $response->pretend(false);

        $body = 'Hello';
        $response->setBody($body);

        // what do we think we're about to send?
        $response->setCookie('foo', 'bar');
        $this->assertTrue($response->hasCookie('foo'));
        $this->assertTrue($response->hasCookie('foo', 'bar'));

        // send it
        ob_start();
        $response->send(); // what really was sent
        if (ob_get_level() > 0) {
            ob_end_clean();
        }

        $this->assertHeaderNotEmitted('Set-Cookie: pop=corn', true);
    }
}
