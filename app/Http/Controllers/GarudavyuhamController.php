<?php

namespace App\Http\Controllers;

use App\Garudavyuham;
use App\News;
use Illuminate\Http\Request;

class GarudavyuhamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $Sapiname = "Garudavyuham";
        if(isset($request->apiname)){
            $Aspiname = $request->apiname;
        }else{
             $Aspiname = null;
        }
        if(isset($request->devicemodel) && isset($request->macaddress)){
            if(($request->devicemodel != "") && ($request->macaddress != "")){
                if($Sapiname == $Aspiname){
                    if (Garudavyuham::where('macaddress', '=', $request->macaddress)->count() == 0) {
                        $registers = Garudavyuham::all();
                        $register = new Garudavyuham;
                        $register->devicemodel = $request->devicemodel;
                        $register->macaddress = $request->macaddress;
                        $respose = $register->save();
                    }
                }
            }
        }
        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Garudavyuham  $garudavyuham
     * @return \Illuminate\Http\Response
     */
    public function showDevices(Garudavyuham $garudavyuham)
    {
        $registers = Garudavyuham::all();
        return $registers;
    }

        public function showNews(Garudavyuham $garudavyuham)
    {
        $registers = News::all();
        return $registers;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Garudavyuham  $garudavyuham
     * @return \Illuminate\Http\Response
     */
    public function edit(Garudavyuham $garudavyuham)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Garudavyuham  $garudavyuham
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Garudavyuham $garudavyuham)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Garudavyuham  $garudavyuham
     * @return \Illuminate\Http\Response
     */
    public function destroy(Garudavyuham $garudavyuham)
    {
        //
    }
}