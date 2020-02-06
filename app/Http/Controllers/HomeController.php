<?php

namespace App\Http\Controllers;use App\Models\Users;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    public function home() {
        $users = Users::all();
        return view('home', compact('users'));
    }

    public function user(Request $request, $id) {
        $request->session()->put('id', $id);
        return redirect('/');
    }

    public function save(Request $request) {
        echo 'dsfjd';
        $user = new Users([
            'user_id' => session('id'),
            'total_time_worked' => $request->total,
            'hours_left' => $request->left,
            'total_breaks' => $request->breaks
        ]);

        DB::beginTransaction();
        try {
            $user->save();
            DB::commit();
        }
        catch(\Exception $e) {
            DB::rollback();
        }
        // return redirect('/');
    }
}
