<?php

namespace Exolnet\Bento\Strategy;

use BadMethodCallException;
use Exolnet\Bento\Feature;
use Exolnet\Bento\StrategyFactory;
use InvalidArgumentException;

/**
 * @method $this callback(callable $callback)
 * @method $this config(string $key)
 * @method $this date(\DateTime|string|int $date, string $operator = '>=')
 * @method $this environment(array|string $environments)
 * @method $this everyone()
 * @method $this guest()
 * @method $this hostname(array|string $hostnames)
 * @method $this logicAnd(?callable $callback = null)
 * @method $this logicNot(?callable $callback = null)
 * @method $this logicOr(?callable $callback = null)
 * @method $this nobody()
 * @method $this stub(bool $state)
 * @method $this user(array|int|null $userIds = null)
 * @method $this userPercent(int $percent)
 * @method $this visitorPercent(int $percent)
 */
abstract class Builder extends StrategyBase implements StrategyFeatureAware
{
    /**
     * @var \Exolnet\Bento\Feature
     */
    protected $feature;

    /**
     * @var array|\Exolnet\Bento\Strategy\Strategy[]
     */
    protected $strategies = [];

    /**
     * @param \Exolnet\Bento\Feature $feature
     */
    public function __construct(Feature $feature)
    {
        $this->feature = $feature;
    }

    /**
     * @return \Exolnet\Bento\Feature
     */
    public function getFeature(): Feature
    {
        return $this->feature;
    }

    /**
     * @return array|\Exolnet\Bento\Strategy\Strategy[]
     */
    public function getStrategies(): array
    {
        return $this->strategies;
    }

    /**
     * @return int
     */
    public function countStrategies(): int
    {
        return count($this->strategies);
    }

    /**
     * @return bool
     */
    public function hasStrategies(): bool
    {
        return $this->countStrategies() > 0;
    }

    /**
     * @param \Exolnet\Bento\Strategy\Strategy $strategy
     * @return $this
     */
    public function aim(Strategy $strategy): self
    {
        $this->strategies[] = $strategy;

        return $this;
    }

    /**
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __call(string $method, array $parameters)
    {
        if ($strategy = $this->makeStrategy($method, $parameters)) {
            return $this->aim($strategy);
        }

        throw new BadMethodCallException(
            sprintf('Call to undefined method %s::%s()', static::class, $method)
        );
    }

    /**
     * @param string $name
     * @param array $parameters
     * @return \Exolnet\Bento\Strategy\Strategy|null
     */
    protected function makeStrategy(string $name, array $parameters): ?Strategy
    {
        try {
            return $this->newStrategyFactory()->make($this->getFeature(), $name, ...$parameters);
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * @return \Exolnet\Bento\StrategyFactory
     */
    protected function newStrategyFactory(): StrategyFactory
    {
        return app(StrategyFactory::class);
    }
}
