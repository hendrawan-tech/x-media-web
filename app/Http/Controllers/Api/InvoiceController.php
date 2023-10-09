<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Installation;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\UserMeta;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InvoiceController extends Controller
{
    function listInvoice(Request $request)
    {
        $user = $request->user();
        if ($user->role == 'user') {
            $data = Invoice::where(['user_id' => $user->id, 'status' => 'Pending'])->with('user.userMeta.package', 'user.installations')->get();
        } else {
            $data = Invoice::where(['status' => 'Pending'])->with('user.userMeta.package', 'user.installations')->get();
        }
        return ResponseFormatter::success($data);
    }

    function paymentOffline(Request $request)
    {
        $invoice = Invoice::where('id', $request->invoice_id)->first();
        $invoice->update([
            'invoice_url' => "Cash",
            'status' => "SUCCESS",
        ]);
        $installation = Installation::where('user_id', $invoice->user_id)->first();
        $dateTime = new DateTime($installation->end_date);
        $dateTime->modify('+1 month');
        $newDate = $dateTime->format('Y-m-d');
        $installation->update([
            'end_date' => $newDate,
        ]);
        return ResponseFormatter::success();
    }

    function paymentXendit(Request $request)
    {
        $user = $request->user();
        $secret_key = 'Basic ' . config('xendit.key_auth');
        $invoice = Invoice::where('id', $request->id)->first();

        $data_request = Http::withHeaders([
            'Authorization' => $secret_key
        ])->post('https://api.xendit.co/v2/invoices', [
            'external_id' => (string)$invoice->external_id,
            'amount' => (int)$user->userMeta->package->price,
            "payer_email" => $user->email,
            "description" => "Pembayaran Tagihan Wifi " . $user->name,
        ]);
        $response = $data_request->object();
        $invoice->update([
            'invoice_url' => $response->invoice_url,
        ]);
        return ResponseFormatter::success($invoice);
    }

    function createInvoice(Request $request)
    {
        $user = $request->user();
        $secret_key = 'Basic ' . config('xendit.key_auth');

        $datePart = date("Ymd");
        $randomPart = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $external_id = "INV-$datePart-$randomPart";

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

    function bulkCreateInvoice()
    {
        $currentDate = now();
        $threeDaysAgo = $currentDate->subDays(3);
        $data = Installation::whereDate('end_date', $threeDaysAgo->format('Y-m-d'))->with('user')->get();

        foreach ($data as $item) {
            $datePart = date("Ymd");
            $randomPart = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $external_id = "INV-$datePart-$randomPart";
            $userMeta = UserMeta::where('id', $item['user']['user_meta_id'])->first();
            $package = Package::where('id', $userMeta['package_id'])->first();

            Invoice::create([
                'external_id' => $external_id,
                'price' => (int)$package->price,
                'status' => "PENDING",
                'invoice_url' => "-",
                'user_id' => $item['user']['id'],
            ]);
        }

        return ResponseFormatter::success();
    }

    function myInvoice(Request $request)
    {
        $user = $request->user();
        $data = Invoice::where(['user_id' => $user->id, 'status' => 'PENDING'])->first();
        return ResponseFormatter::success($data);
    }

    function checkStatus(Request $request)
    {
        $data = Invoice::where('id', $request->id)->with('user.userMeta.package', 'user.installations')->first();
        return ResponseFormatter::success($data);
    }

    public function handleCallback(Request $request)
    {
        $payload = $request->all();
        if ($payload['status'] === 'PAID') {
            $invoice = Invoice::where('external_id', $payload['external_id'])->first();
            $invoice->update([
                'status' => "SUCCESS",
            ]);
            $installation = Installation::where('user_id', $invoice->user_id)->first();
            $dateTime = new DateTime($installation->end_date);
            $dateTime->modify('+1 month');
            $newDate = $dateTime->format('Y-m-d');
            $installation->update([
                'end_date' => $newDate,
            ]);
        }
        return ResponseFormatter::success();
    }
}
