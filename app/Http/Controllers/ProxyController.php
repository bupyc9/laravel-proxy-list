<?php

namespace App\Http\Controllers;

use App\Proxy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProxyController extends Controller
{
    public const COUNT_ITEMS = 20;

    /**
     * @param Request $request
     * @return View
     * @throws \InvalidArgumentException
     */
    public function index(Request $request): View
    {
        $country = $request->query('country');
        $anonymity = $request->query('anonymity');
        $available = $request->query('available');

        $where = [];
        !empty($country) && $where['country'] = $country;
        !empty($anonymity) && $where['anonymity'] = $anonymity;

        $builder = Proxy::query()
            ->with('checkProxy')
            ->where($where)
            ->orderBy('id', 'asc');

        if (!empty($available)) {
            $builder->whereHas(
                'checkProxy', function (Builder $query) use ($available) {
                $query->where('status', '=', $available);
            }
            );
        }

        $proxies = $builder
            ->paginate(self::COUNT_ITEMS);

        $countries = Proxy::query()->select(['country'])->groupBy('country')->orderBy('country', 'asc')->get();
        $anonymous = Proxy::query()->select(['anonymity'])->groupBy('anonymity')->orderBy('anonymity', 'asc')->get();

        return view(
            'proxy.index',
            [
                'proxies' => $proxies,
                'countries' => $countries,
                'anonymous' => $anonymous,
            ]
        );
    }
}
