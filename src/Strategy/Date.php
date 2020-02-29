<?php

namespace Exolnet\Bento\Strategy;

use Illuminate\Support\Carbon;
use InvalidArgumentException;

class Date extends StrategyBase
{
    /**
     * @var \Illuminate\Support\Carbon
     */
    protected static $now;

    /**
     * @var \Illuminate\Support\Carbon
     */
    protected $date;

    /**
     * @var string
     */
    protected $operator;

    /**
     * @param \DateTime|string|int $date
     * @param string $operator
     */
    public function __construct($date, string $operator = '>=')
    {
        $this->date = Carbon::parse($date);
        $this->operator = $operator;
    }

    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        $now = static::getNow();

        if ($this->operator === '<') {
            return $now->gt($this->date);
        } elseif ($this->operator === '<=') {
            return $now->gte($this->date);
        } elseif ($this->operator === '>=') {
            return $now->lte($this->date);
        } elseif ($this->operator === '>') {
            return $now->lt($this->date);
        } elseif ($this->operator === '=') {
            return $now->isSameDay($this->date);
        }

        throw new InvalidArgumentException(
            'Invalid '. $this->operator .' operator for strategy '. static::class
        );
    }

    /**
     * @return \Illuminate\Support\Carbon
     */
    protected static function getNow(): Carbon
    {
        if (! static::$now) {
            static::$now = Carbon::now()->startOfDay();
        }

        return static::$now;
    }
}
