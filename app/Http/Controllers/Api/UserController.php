<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Installation;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function user(Request $request)
    {
        $user = $request->user();
        $user['meta'] = UserMeta::where('id', $user->user_meta_id)->first();
        $user['installation'] = Installation::where('user_id', $user->id)->first();
        if ($user) {
            return ResponseFormatter::success(['user' => $user]);
        } else {
            return ResponseFormatter::error();
        }
    }

    function getUser()
    {
        $data = User::where('role', 'user')->get();
        return ResponseFormatter::success($data);
    }

    function createUser(Request $request)
    {
        $meta = UserMeta::create([
            'phone' => $request->phone,
            'address' => $request->address,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'longlat' => $request->longlat,
            'province_id' => "35",
            'province_name' => "JAWA TIMUR",
            'regencies_id' => "3511",
            'regencies_name' => "KAB. BONDOWOSO",
            'district_id' => $request->district_id,
            'district_name' => $request->district_name,
            'ward_id' => $request->ward_id,
            'ward_name' => $request->ward_name,
            'package_id' => $request->package_id,
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'user_meta_id' => $meta->id,
        ]);
        Installation::create([
            'status' => 'Aktif',
            'date_install' => now()->format('Y-m-d H:i:s'),
            'end_date' => now()->format('Y-m-d H:i:s'),
            'user_id' => $user->id,
        ]);
        return ResponseFormatter::success();
    }
}
