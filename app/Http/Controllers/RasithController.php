<?php

namespace App\Http\Controllers;

use App\Vazhipad;
use App\Prathishtta;
use App\Nakshatharam;
use App\Vazhipadcattegory;
use Illuminate\Http\Request;
use App\Http\Resources\Vazhipad as VazhipadResource;
use App\Http\Resources\Prathishtta as PrathishttaResource;
use App\Http\Resources\Nakshatharam as NakshatharamResource;
use App\Http\Resources\VazhipadCategory as VazhipadCategoryResource;
use Illuminate\Support\Facades\DB;

class RasithController extends Controller
{
    public function getdata()
    {
        $nakshatharam = Nakshatharam::all();
        $vazhipadCategories = Vazhipadcattegory::with('vazhipads')->get();

        return [
            'nakshatharams' => NakshatharamResource::collection($nakshatharam),
            'vazhipad_categories' => VazhipadCategoryResource::collection($vazhipadCategories)
        ];
    }

    public function getPrathishttas(Vazhipad $vazhipad)
    {
        return PrathishttaResource::collection(
            $vazhipad->prathishttas()->orderby('id')->get()
        );
    }

    public function getAllPrathishttas()
    {
        return PrathishttaResource::collection(
            Prathishtta::all()
        );
    }

    public function getVazhipads()
    {
        return VazhipadResource::collection(
            Vazhipad::all()
        );
    }

    public function allocations()
    {
        $allocations = DB::table('prathishtta_vazhipad')
            ->join('prathishttas', 'prathishttas.id',  '=', 'prathishtta_vazhipad.prathishtta_id')
            ->join('vazhipads', 'vazhipads.id', '=', 'prathishtta_vazhipad.vazhipad_id')
            ->select([
                'prathishtta_vazhipad.id as id', 'prathishtta_id', 'vazhipad_id', 'vazhipads.name as vazhipad', 'prathishttas.name as prathishtta'
            ])->get();

        return $allocations;
    }
}