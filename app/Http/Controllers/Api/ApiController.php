<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Installation;
use App\Models\Invoice;
use App\Models\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function user(Request $request)
    {
        $user = $request->user();
        if ($user) {
            return ResponseFormatter::success(['user' => $user]);
        } else {
            return ResponseFormatter::error();
        }
    }

    function district()
    {
        $data_request = Http::get('https://ibnux.github.io/data-indonesia/kecamatan/3511.json');
        $response = $data_request->object();
        return ResponseFormatter::success($response);
    }

    function ward(Request $request)
    {
        $data_request = Http::get('https://ibnux.github.io/data-indonesia/kelurahan/' . $request->district_id . '.json');
        $response = $data_request->object();
        return ResponseFormatter::success($response);
    }

    function installation(Request $request)
    {
        UserMeta::create([
            'address' => $request->address,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'longlat' => $request->longlat,
            'province_id' => 35,
            'regencies_id' => 3511,
            'district_id' => $request->district_id,
            'ward_id' => $request->ward_id,
            'user_id' => $request->user()->id,
            'package_id' => $request->package_id,
        ]);

        Installation::create([
            'status' => "Antrian",
            'date_install' => $request->date_install,
            'user_id' => $request->user()->id,
        ]);

        return ResponseFormatter::success();
    }

    function updateInstallation(Request $request)
    {
        Installation::where('id', $request->id)->first()->update([
            'status' => $request->status,
            'date_install' => $request->date_install,
        ]);

        return ResponseFormatter::success();
    }

    function getInvoice(Request $request)
    {
        $data = Invoice::where('user_id', $request->user()->id)->first();

        return ResponseFormatter::success($data);
    }
}
