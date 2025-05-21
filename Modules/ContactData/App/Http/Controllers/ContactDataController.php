<?php

namespace Modules\ContactData\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\ContactData\App\Models\Contacts;
use Modules\ContactData\App\Models\ContactTypes;
use Illuminate\Support\Facades\DB;


class ContactDataController extends Controller
{
    /**
     * List of traits used by the controller.
     *
     * @return void
     */
    use \App\Traits\ApiResponder;
    
    /**
     * Get top five pharmacies.
     *
     * @return Response
     */
    public function topFiveAreaPharmacies(Request $request)
    {
       /*  $res = [
            '11245' => 1000,
            '11246' => 900,
            '11247' => 800,
            '11248' => 700,
            '11249' => 600
        ]; */
        $res = ContactTypes::find(1)->contacts;
       return $this->successResponse($res,'Top five area pharmacies',200);
    }
    /**
     * Get top five purchase pharmacies.
     *
     * @return Response
     */
    public function topFivePurchasePharmacies(Request $request)
    {
        $res = [
            'Papaveraceae Pharmaceutical' => 1200000,
            'Psilocybin Pharmaceutical' => 1600000,
            'Amphetamine Pharmaceutical' => 750000,
            'Nicotiana Pharmaceutical' => 125000,
            'Cannabinaceae Pharmacetical' => 600000
        ];
       return $this->successResponse($res,'Top five purchase pharmacies',200);
    }
    /**
     * Get contact growth.
     *
     * @return Response
     */
    public function contactGrowth(Request $request)
    {
        $now = date('Y');
        $supplier_total_month_05 = ContactTypes::find(1)->contacts()
        ->whereMonth('created_date', 5)
        ->whereYear('created_date', $now)
        ->count();

        $res = [
          'Pharmacies' => [
            'January' => 100,
            'February' => 200,
            'March' => 300,
            'April' => 400,
            'May' => 500,
            'June' => 600,
            'July' => 700,
            'August' => 800,
            'September' => 900,
            'October' => 1000,
            'November' => 1100,
            'December' => 1200
          ],
          'Distributors' => [
            'January' => 50,
            'February' => 100,
            'March' => 150,
            'April' => 200,
            'May' => 250,
            'June' => 300,
            'July' => 350,
            'August' => 400,
            'September' => 450,
            'October' => 500,
            'November' => 550,
            'December' => 600
          ],
          'Suppliers' => [
            'January' => 20,
            'February' => 40,
            'March' => 60,
            'April' => 80,
            'May' => $supplier_total_month_05,
            'June' => 120,
            'July' => 140,
            'August' => 160,
            'September' => 180,
            'October' => 200,
            'November' => 220,
            'December' => 240
          ],
          'Pharmacy Contacts' => [
            'January' => 10,
            'February' => 20,
            'March' => 30,
            'April' => 40,
            'May' => 50,
            'June' => 60,
            'July' => 70,
            'August' => 80,
            'September' => 90,
            'October' => 100,
            'November' => 110,
            'December' => 120
          ]
        ];
       return $this->successResponse($res,'Contact growth',200);
    }
    /**
     * Get top contact card.
     *
     * @return Response
     */
    public function topContactCard(Request $request)
    {
        $res = [];
        if($request->type == 'pharmacies'){
            array_push($res, [
                'total' => 1000,
                'delta' => '+100',
            ]);
        }
        else if($request->type == 'distributors'){
            array_push($res, [
                'total' => 500,
                'delta' => '-20',
            ]);
        }
        else if($request->type == 'subscribers'){
            array_push($res, [
                'total' => 20000,
                'delta' => '+20',
            ]);
        }
        else if($request->type == 'pharmacy-contacts'){
            array_push($res, [
                'total' => 150,
                'delta' => '-50',
            ]);
        }
        else {
            return $this->error('Invalid type',400);
        }
            
       return $this->successResponse($res,'Top contact card',200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('contactdata::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contactdata::create');
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
        return view('contactdata::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('contactdata::edit');
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
