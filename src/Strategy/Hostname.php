<?php

namespace Exolnet\Bento\Strategy;

use Illuminate\Http\Request;

class Hostname extends StrategyBase
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $hostnames;

    /**
     * @param \Illuminate\Http\Request $request
     * @param array|string $hostnames
     */
    public function __construct(Request $request, $hostnames)
    {
        $this->request = $request;
        $this->hostnames = (array)$hostnames;
    }

    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        $host = $this->request->getHost();

        return in_array($host, $this->hostnames);
    }
}
