<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use App\Service\AccessControlService;

class MenuMiddleware  
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
     * @return mixed
     */

    protected $arrNavigation = [];
    protected $arrTemp       = [];

    public function handle($request, Closure $next)
    {
        $navigations = config('menu.navigation');

        foreach ($navigations as $navigation) {
            $this->addMenu($navigation);
        }
        View::share('navigations', $this->arrNavigation);
        return $next($request);
    }

    protected function addMenu($navigations)
    {
        $this->arrTemp = [];
        foreach ($navigations['children'] as $navigation) {
            if ($this->isMenuAllowed($navigation)) {
                $this->arrTemp[] = [
                    'label' => $navigation['label'],
                    'icon'  => $navigation['icon'],
                    'route' => !empty($navigation['route']) ? $navigation['route'] : '#',
                ];
            }
        }
        if(!empty($this->arrTemp)){
            $this->arrNavigation[] = [
                'label'     => $navigations['label'],
                'children'  => $this->arrTemp,
            ];
        }
    }

    protected function isMenuAllowed($navigation)
    {
        $allowed   = true;
        $resource  = !empty($navigation['resource']) ? $navigation['resource'] : '';
        if (!empty($resource)) {
            $allowed = AccessControlService::checkAccessControl($resource);
        }
        return $allowed;
    }
}
