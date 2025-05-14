<?php

namespace Modules\Analytics\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\RunReportRequest;

class AnalyticsController extends Controller
{
    /**
     * First trial
     */
    public function analyticsData()
    {
            $client = new BetaAnalyticsDataClient();

            $request = new RunReportRequest([
                'property' => 'properties/' . env('ANALYTICS_PROPERTY')
            ]);
            $response = $client->runReport($request);
            $res = [];
            foreach ($response->getRows() as $row) {
                foreach ($row->getDimensionValues() as $dimensionValue) {
                    array_push($res,$dimensionValue->getValue());
                }
            }
            return response(["status"=>"success","data"=>$res],200);
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
