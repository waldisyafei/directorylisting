<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as MaintenanceMode;

class CheckForMaintenanceMode {

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->app->isDownForMaintenance() && ! $this->isIpWhiteListed($request)) {
            throw new HttpException(503);
        }

        return $next($request);
    }

    private function isIpWhiteListed(Request $request)
    {
        $ip = $request->getClientIp();
        $allowed = explode(',', getenv('WHEN_DOWN_WHITELIST_THIS_IPS'));

        return in_array($ip, $allowed);
    }
}