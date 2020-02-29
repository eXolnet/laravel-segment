<?php

namespace Exolnet\Bento\Middleware;

use Closure;
use Exolnet\Bento\Bento;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Await
{
    /**
     * @var \Exolnet\Bento\Bento
     */
    protected $bento;

    /**
     * @param \Exolnet\Bento\Bento $bento
     */
    public function __construct(Bento $bento)
    {
        $this->bento = $bento;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $feature
     * @return mixed
     */
    public function handle($request, Closure $next, string $feature)
    {
        if (! $this->bento->await($feature)) {
            throw new NotFoundHttpException;
        }

        return $next($request);
    }
}
