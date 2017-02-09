<?php

namespace App\Http\Controllers;

use App\Link;

class LinksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('create');
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
        $fullLink = $linkBasic . '?' . $queryKey . '=' . $queryValue;

        $link = Link::create([
            'user_id' => auth()->id(),
            'fake_link' => request('fake_link'),
            'real_link' => request('real_link'),
            'link_basic' => $linkBasic,
            'query_key' => $queryKey,
            'query_value' => $queryValue,
            'full_link' => $fullLink,
        ]);

        return redirect()->back()->withLink($link);
    }

    public function show($link)
    {
        $url = Link::where('link_basic', '=', $link)->first();

        Link::where('link_basic', '=', $link)->increment('clicks');

        $query = request()->query();

        if ($this->checkBadUserAgents() === true) {
            return redirect($url->fake_link);
        }

        if (!$query) {
            return redirect('http://google.com');
        }

        return view('links.redirect', compact('url'));
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
