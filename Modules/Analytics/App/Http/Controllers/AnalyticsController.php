<?php

namespace Modules\Analytics\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;

class AnalyticsController extends Controller
{
    /**
     * List of traits used in this controller.
     */
    use \Modules\Core\Traits\ApiResponder;


    /**
     * First trial
     */
    public function analyticsData()
    {
            $dir = dirname(__FILE__,6);
            $ranges = new DateRange(['start_date' => '2025-01-01', 'end_date' => '2025-05-14']);
            $date_range = [$ranges];
            $dimensions = [
                new Dimension(['name'=>'browser']),
                new Dimension(['name'=>'country']),
                new Dimension(['name'=>'city'])
            ];
            $metrics = [
                new Metric(['name'=>'activeUsers']),
                new Metric(['name'=>'newUsers']),
                new Metric(['name'=>'totalUsers']),
                new Metric(['name'=>'bounceRate'])
            ];
            $client = new BetaAnalyticsDataClient([
               'credentials' => $dir . '/storage/app/analytics/analytics-credentials.json'
            ]);

            $request = new RunReportRequest([
                'property' => 'properties/' . env('ANALYTICS_PROPERTY'),
                'date_ranges' => $date_range,
                'dimensions' => $dimensions,
                'metrics' => $metrics,
                'limit' => 100
            ]);
            $response = $client->runReport($request);
            $res = [];
            foreach ($response->getRows() as $row) {
                $dimensionValue = $row->getDimensionValues();
                array_push($res,[
                    "Browser"=>$dimensionValue[0]->getValue(),
                    "Country"=>$dimensionValue[1]->getValue(),
                    "City"=>$dimensionValue[2]->getValue()
                ]);
                $metricsValue = $row->getMetricValues();
                array_push($res,[
                    "Active Users"=>$metricsValue[0]->getValue(),
                    "New Users"=>$metricsValue[1]->getValue(),
                    "Total Users"=>$metricsValue[2]->getValue(),
                    "Bounce Rate"=>$metricsValue[3]->getValue()
                ]);
            }
           // array_push($res,env('APP_URL'));
           // return response(["status"=>"success","data"=>$res],200);
           return $this->success($res, 'Analytics data retrieved successfully',201);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('analytics::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('analytics::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('analytics::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('analytics::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
