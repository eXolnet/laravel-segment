<?php

namespace Exolnet\Bento\Strategy;

use Illuminate\Contracts\Config\Repository as ConfigRepository;

class Environment extends StrategyBase
{
    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @var array
     */
    protected $environments;

    /**
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param array|string $environments
     */
    public function __construct(ConfigRepository $config, $environments)
    {
        $this->config = $config;
        $this->environments = (array)$environments;
    }

    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        $environment = $this->config->get('app.env');

        return in_array($environment, $this->environments);
    }
}
