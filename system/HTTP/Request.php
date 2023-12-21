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

namespace CodeIgniter\HTTP;

use Config\App;
use PHPUnit\Framework\Attributes\CodeCoverageIgnore;

/**
 * Representation of an incoming, server-side HTTP request.
 *
 * @see \CodeIgniter\HTTP\RequestTest
 */
class Request extends OutgoingRequest implements RequestInterface
{
    use RequestTrait;

    /**
     * Proxy IPs
     *
     * @var array<string, string>
     *
     * @deprecated 4.0.5 No longer used. Check the App config directly
     */
    protected $proxyIPs;

    /**
     * Constructor.
     *
     * @param App $config
     *
     * @deprecated 4.0.5 The $config is no longer needed and will be removed in a future version
     */
    public function __construct($config = null) // @phpstan-ignore-line
    {
        if (empty($this->method)) {
            $this->method = $this->getServer('REQUEST_METHOD') ?? Method::GET;
        }

        if (empty($this->uri)) {
            $this->uri = new URI();
        }
    }

    /**
     * Sets the request method. Used when spoofing the request.
     *
     * @return $this
     *
     * @deprecated 4.0.5 Use withMethod() instead for immutability
     */
    #[CodeCoverageIgnore]
    public function setMethod(string $method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Returns an instance with the specified method.
     *
     * @param string $method
     *
     * @return static
     */
    public function withMethod($method)
    {
        $request = clone $this;

        $request->method = $method;

        return $request;
    }

    /**
     * Retrieves the URI instance.
     *
     * @return URI
     */
    public function getUri()
    {
        return $this->uri;
    }
}
