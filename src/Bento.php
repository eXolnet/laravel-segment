<?php

namespace Exolnet\Bento;

class Bento
{
    /**
     * @var array
     */
    protected $features = [];

    /**
     * @var int
     */
    protected $visitorId;

    /**
     * @param string $name
     * @return \Exolnet\Bento\Feature
     */
    public function feature(string $name): Feature
    {
        if (! isset($this->features[$name])) {
            $this->features[$name] = new Feature($name);
        }

        return $this->features[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function launch(string $name): bool
    {
        return $this->feature($name)->launch();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function await(string $name): bool
    {
        return $this->feature($name)->await();
    }

    /**
     * @return int
     */
    public function getVisitorId(): int
    {
        if (! $this->visitorId) {
            $this->visitorId = $this->makeVisitorId();
        }

        return $this->visitorId;
    }

    /**
     * @param int $visitorId
     * @return $this
     */
    public function setVisitorId(int $visitorId)
    {
        $this->visitorId = $visitorId;

        return $this;
    }

    /**
     * @return int
     */
    protected function makeVisitorId(): int
    {
        $request = request();

        return crc32($request->ip() . $request->header('user-agent'));
    }
}
