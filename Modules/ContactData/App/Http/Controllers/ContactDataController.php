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
     * list of contact type names 
     */

    private $contact_pharmacy = 0;
    private $contact_supplier = 0;
    private $contact_community = 0;
    private $contact_general_newsletter = 0;
    private $contact_pharmacy_db = 0;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->contact_pharmacy = ContactTypes::where('contact_type_name', 'PHARMACY')->first();
        $this->contact_supplier = ContactTypes::where('contact_type_name', 'SUPPLIER')->first();
        $this->contact_community = ContactTypes::where('contact_type_name', 'COMMUNITY')->first();
        $this->contact_general_newsletter = ContactTypes::where('contact_type_name', 'GENERAL NEWSLETTER')->first();
        $this->contact_pharmacy_db = ContactTypes::where('contact_type_name', 'PHARMACY DATABASE')->first();
    }
    
    /**
     * Get top five pharmacies.
     *
     * @return Response
     */
    public function topFiveAreaPharmacies(Request $request)
    {
        $results = ContactTypes::find(1)->contacts()
        ->selectRaw("contacts.post_code,COUNT(contacts.post_code) AS total_pharmacies")
        ->orderBy('total_pharmacies', 'desc')
        ->groupBy('contacts.post_code')
        ->take(5)->get();
        $res = [];
        foreach( $results as $result ){
            $res[] = [
                'post_code' => $result->post_code,
                'total_pharmacies' => (int) $result->total_pharmacies
            ];
        }
       return $this->successResponse($res,'Top five area pharmacies',200);
    }
    /**
     * Get top five purchase pharmacies.
     *
     * @return Response
     */
    public function topFivePurchasePharmacies(Request $request)
    {
       
        $results = ContactTypes::find(1)->contacts()
        ->select('contacts.contact_name','contacts.total_purchase')
        ->orderBy('total_purchase', 'desc')
        ->take(5)
        ->get();
        $res = [];
        foreach( $results as $result ){
            $res[] = [
                'pharmacy_name' => $result->contact_name,
                'total_purchase' => (int) $result->total_purchase
            ];
        }
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
        $months = [
            1 => 'January',
            2 => 'February',   
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];

        //pharmacy
        $pharmacy = [];
        for($i = 1; $i <= 12; $i++){
            $pharmacy[$i] = ContactTypes::find($this->contact_pharmacy->id)->contacts()
            ->whereMonth('created_date', $i)
            ->whereYear('created_date', $now)
            ->count();
        }
        $pharmacy_result = [];
        foreach($pharmacy as $key => $value){
            $pharmacy_result[$months[$key]] = (int) $value;
        }

        //supplier
        $supplier = [];
        for($i = 1; $i <= 12; $i++){
            $supplier[$i] = ContactTypes::find($this->contact_supplier->id)->contacts()
            ->whereMonth('created_date', $i)
            ->whereYear('created_date', $now)
            ->count();
        }
        $supplier_result = [];
        foreach($supplier as $key => $value){
            $supplier_result[$months[$key]] = (int) $value;
        }

        //community
        $community = [];
        for($i = 1; $i <= 12; $i++){
            $community[$i] = ContactTypes::find($this->contact_community->id)->contacts()
            ->whereMonth('created_date', $i)
            ->whereYear('created_date', $now)
            ->count();
        }
        $community_result = [];
        foreach($community as $key => $value){
            $community_result[$months[$key]] = (int) $value;
        }

        //general newsletter
        $general_newsletter = [];
        for($i = 1; $i <= 12; $i++){
            $general_newsletter[$i] = ContactTypes::find($this->contact_general_newsletter->id)->contacts()
            ->whereMonth('created_date', $i)
            ->whereYear('created_date', $now)
            ->count();
        }
        $general_newsletter_result = [];
        foreach($general_newsletter as $key => $value){
            $general_newsletter_result[$months[$key]] = (int) $value;
        }

        //pharmacy db
        $pharmacy_db = [];
        for($i = 1; $i <= 12; $i++){
            $pharmacy_db[$i] = ContactTypes::find($this->contact_pharmacy_db->id)->contacts()
            ->whereMonth('created_date', $i)
            ->whereYear('created_date', $now)
            ->count();
        }
        $pharmacy_db_result = [];
        foreach($pharmacy_db as $key => $value){
            $pharmacy_db_result[$months[$key]] = (int) $value;
        }

        $res = [
          'Pharmacies' => $pharmacy_result,
          'Suppliers' => $supplier_result,
          'General Newsletter' => $general_newsletter_result,
          'Community' => $community_result,
          'Pharmacy Database' => $pharmacy_db_result
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
