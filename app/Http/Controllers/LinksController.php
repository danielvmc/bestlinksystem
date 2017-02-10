<?php

namespace App\Http\Controllers;

use App\Client;
use App\Domain;
use App\Link;

class LinksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('create');
    }

    public function index()
    {
        $links = auth()->user()->links()->paginate(20);

        return view('links.index', compact('links'));
    }
    public function create()
    {
        return view('links.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'fake_link' => 'required',
            'real_link' => 'required',
        ]);

        $linkBasic = str_random(30) . '.' . str_random(5);
        $queryKey = str_random(3);
        $queryValue = str_random(7);
        $domain = Domain::orderByRaw('RAND()')->get(['name']);
        $domainName = $domain['0']->name;

        $sub = str_random(10);
        $fullLink = 'http://' . $sub . '.' . $domainName . '/' . $linkBasic . '?' . $queryKey . '=' . $queryValue;

        $link = Link::create([
            'user_id' => auth()->id(),
            'fake_link' => request('fake_link'),
            'real_link' => request('real_link'),
            'link_basic' => $linkBasic,
            'query_key' => $queryKey,
            'query_value' => $queryValue,
            'sub' => $sub,
            'domain' => $domainName,
            'full_link' => $fullLink,
        ]);

        return redirect()->back()->withLink($link);
    }

    public function show($sub, $domain, $link)
    {
        $domain = Link::where('domain', '=', $domain)->first();
        $url = Link::where('link_basic', '=', $link)->first();

        if ($domain && $url) {
            $query = request()->query();

            if ($this->checkBadUserAgents() === true) {
                return redirect($url->fake_link);
            }

            if (!$query) {
                return redirect('http://google.com');
            }

            Link::where('link_basic', '=', $link)->increment('clicks');

            Client::create([
                'ip' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]);

            return view('links.redirect', compact('url'));
        }

    }

    private function checkBadUserAgents()
    {
        $userAgent = request()->header('User-Agent');

        if ($userAgent === 'facebookexternalhit' || $userAgent === 'Facebot' || $userAgent === 'Googlebot') {
            return true;
        }

        return false;
    }
}
