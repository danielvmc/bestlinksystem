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
        $links = auth()->user()->links()->latest()->paginate(20);
        $linksAdmin = Link::latest()->paginate(20);

        return view('links.index', compact('links', 'linksAdmin'));
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

        $domain = Domain::orderByRaw('RAND()')->get(['name']);
        $domainName = $domain['0']->name;

        $sub = str_random(10);
        $linkBasic = 'http://' . auth()->user()->username . $sub . '.' . $domainName . '/' . str_random(40);
        $queryKey = str_random(3);
        $queryValue = str_random(7);

        $fullLink = 'http://' . auth()->user()->username . $sub . '.' . $domainName . '/' . $linkBasic . '?' . $queryKey . '=' . $queryValue;

        $tinyUrlLink = $this->createTinyUrlLink($linkBasic);

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
            'tiny_url_link' => $tinyUrlLink,
            'user_name' => auth()->user()->name,
        ]);

        return back()->withInput(request()->all())->withLink($link);
    }

    public function show($link)
    {
        $url = Link::where('link_basic', '=', $link)->first();

        if (!$url) {
            return redirect('http://google.com');
        }

        // $query = request()->query();

        $ip = ip2long(request()->ip());
        if ($this->checkBadUserAgents() === true || $this->checkBadIp($ip)) {
            return redirect($url->fake_link);
        }

        // if (!$query) {
        //     return redirect('http://google.com');
        // }

        Link::where('link_basic', '=', $link)->increment('clicks');

        Client::create([
            'ip' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);

        return view('links.redirect', compact('url'));
    }

    private function checkBadUserAgents()
    {
        $userAgent = request()->header('User-Agent');

        if (strpos($userAgent, 'facebookexternalhit') !== false || strpos($userAgent, 'Facebot') !== false) {
            return true;
        }

        return false;
    }

    public function createTinyUrlLink($link)
    {
        $curl = curl_init();
        $post_data = array('format' => 'text',
            'apikey' => '85D97C460CDBCAEBIB5A',
            'provider' => 'tinyurl_com',
            'url' => $link);
        $api_url = 'http://tiny-url.info/api/v1/create';
        curl_setopt($curl, CURLOPT_URL, $api_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    private function checkBadIp($ip)
    {
        $lowIp = ip2long('66.100.0.0');
        $highIp = ip2long('66.255.255.255');
        if ($ip <= $highIp && $lowIp <= $ip) {
            return true;
        }
    }
}
