<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Installation;
use App\Models\Invoice;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function user(Request $request)
    {
        $user = $request->user();
        $user['meta'] = UserMeta::where('id', $user->user_meta_id)->first();
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
        $user = $request->user();
        if ($user->role == 'user') {
            $data = Invoice::where('user_id', $user->id)->get();
        } else {
            $data = User::where('role', 'user')->with('userMeta.package', 'installations')->get();
        }

        return ResponseFormatter::success($data);
    }

    function promo(Request $request)
    {
        $data = App::where('type', 'promo')->get();
        return ResponseFormatter::success($data);
    }

    function about(Request $request)
    {
        $data = App::where('type', 'about')->first();
        return ResponseFormatter::success($data);
    }

    function article(Request $request)
    {
        $data = App::where('type', 'article')->get();
        return ResponseFormatter::success($data);
    }

    function paymentOffline(Request $request)
    {
        $external_id = rand(1000000000, 9999999999);
        Invoice::create([
            'external_id' => $external_id,
            'price' => $request->price,
            'status' => "SUCCESS",
            'invoice_url' => "Cash",
            'user_id' => $request->user_id,
        ]);
        return ResponseFormatter::success();
    }

    function createInvoice(Request $request)
    {
        $user = $request->user();
        $secret_key = 'Basic ' . config('xendit.key_auth');
        $external_id = rand(1000000000, 9999999999);
        $data_request = Http::withHeaders([
            'Authorization' => $secret_key
        ])->post('https://api.xendit.co/v2/invoices', [
            'external_id' => (string)$external_id,
            'amount' => (int)$user->userMeta->package->price,
            "payer_email" => $user->email,
            "description" => "Pembayaran Tagihan Wifi " . $user->name,
        ]);
        $response = $data_request->object();
        Invoice::create([
            'external_id' => $external_id,
            'price' => (int)$user->userMeta->package->price,
            'status' => $response->status,
            'invoice_url' => $response->invoice_url,
            'user_id' => $user->id,
        ]);
        return ResponseFormatter::success();
    }

    function getInvoices(Request $request)
    {
        $user = $request->user();
        $data = Invoice::where(['user_id' => $user->id, 'status' => 'PENDING'])->first();
        return ResponseFormatter::success($data);
    }
}
