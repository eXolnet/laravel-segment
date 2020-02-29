<?php

namespace Exolnet\Bento;

use Exolnet\Bento\Strategy\LogicAnd;

class Feature extends LogicAnd
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @param callable|null $name
     */
    public function __construct($name)
    {
        $this->name = $name;

        parent::__construct($this, function () {
            // For a feature, strategies won't be added though a callback
        });
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        if (! $this->hasStrategies()) {
            return false;
        }

        return parent::__invoke();
    }
}
