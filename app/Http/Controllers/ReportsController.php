<?php

namespace App\Http\Controllers;

use App\Site;
use DateTime;

class ReportsController extends Controller
{
    public function index()
    {
        $sites = Site::latest()->get();

        return view('reports.index', compact('sites'));
    }

    public function store()
    {
        $this->validate(request(), [
            'site_name' => 'required',
        ]);

        Site::create([
            'site_name' => request('site_name'),
            'username' => auth()->user()->name,
        ]);

        flash('Thanks!', 'success');

        return back();
    }

    public function show()
    {
        $firstDayOfLastMonth = date("Y-m-d", mktime(0, 0, 0, date("m") - 1, 1));
        $lastDayOfLastMonth = date("Y-m-d", mktime(0, 0, 0, date("m"), 0));
        $firstDayOfThisMonth = date('Y-m-01');
        $today = date('Y-m-d');
        $yesterday = date("Y-m-d", time() - 60 * 60 * 24);

        // $json = json_decode(file_get_contents('https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A146699891&start-date=2017-05-01&end-date=2017-05-31&metrics=ga%3Asessions&dimensions=ga%3Asource%2Cga%3Amedium&sort=-ga%3Asessions&filters=ga%3Asource%3D%3D' . $user . '&access_token=ya29.GltXBLaRLIwlRZTAGm12hGL275OMiyG-MlTi3382uL_Q99J-f6_BBZgXPmRaAmXkLT-O1MrvxnV-d8EU49Lsz7fR8xpRYxDZQ4WPvM0fv4kDhZ9XhIMzfLMrwENG'), true);

        $thisMonthViews = json_decode(file_get_contents('https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A146699891&start-date=' . $firstDayOfThisMonth . '&end-date=' . $today . '&metrics=ga%3Asessions&dimensions=ga%3Asource%2Cga%3Amedium&sort=-ga%3Asessions&filters=ga%3Asource%3D%3D&access_token=ya29.GltXBLaRLIwlRZTAGm12hGL275OMiyG-MlTi3382uL_Q99J-f6_BBZgXPmRaAmXkLT-O1MrvxnV-d8EU49Lsz7fR8xpRYxDZQ4WPvM0fv4kDhZ9XhIMzfLMrwENG'), true);

        $yesterdayViews = json_decode(file_get_contents('https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A146699891&start-date=' . $yesterday . '&end-date=' . $yesterday . '&metrics=ga%3Asessions&dimensions=ga%3Asource%2Cga%3Amedium&sort=-ga%3Asessions&filters=ga%3Asource%3D%3D&access_token=ya29.GltXBLaRLIwlRZTAGm12hGL275OMiyG-MlTi3382uL_Q99J-f6_BBZgXPmRaAmXkLT-O1MrvxnV-d8EU49Lsz7fR8xpRYxDZQ4WPvM0fv4kDhZ9XhIMzfLMrwENG'), true);

        $todayViews = json_decode(file_get_contents('https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A146699891&start-date=' . $today . '&end-date=' . $today . '&metrics=ga%3Asessions&dimensions=ga%3Asource%2Cga%3Amedium&sort=-ga%3Asessions&filters=ga%3Asource%3D%3D&access_token=ya29.GltXBLaRLIwlRZTAGm12hGL275OMiyG-MlTi3382uL_Q99J-f6_BBZgXPmRaAmXkLT-O1MrvxnV-d8EU49Lsz7fR8xpRYxDZQ4WPvM0fv4kDhZ9XhIMzfLMrwENG'), true);

        // $lastMonthViews = json_decode(file_get_contents('https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A146699891&start-date=' . $firstDayOfLastMonth . '&end-date=' . $lastDayOfLastMonth . '&metrics=ga%3Asessions&dimensions=ga%3Asource%2Cga%3Amedium&sort=-ga%3Asessions&filters=ga%3Asource%3D%3D&access_token=ya29.GltXBLaRLIwlRZTAGm12hGL275OMiyG-MlTi3382uL_Q99J-f6_BBZgXPmRaAmXkLT-O1MrvxnV-d8EU49Lsz7fR8xpRYxDZQ4WPvM0fv4kDhZ9XhIMzfLMrwENG'), true);

        $thisMonth = ($thisMonthViews['totalsForAllResults']['ga:sessions']);
        $yesterday = ($yesterdayViews['totalsForAllResults']['ga:sessions']);
        $today = ($todayViews['totalsForAllResults']['ga:sessions']);
        $lastmonth = ($lastMonthViews['totalsForAllResults']['ga:sessions']);

        return view('reports.show', compact('thisMonth', 'yesterday', 'today'));
    }
}
