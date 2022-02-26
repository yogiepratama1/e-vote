<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardUserController extends Controller
{
    public function index()
    {
        return view('dashboard.user-index');
    }

    public function update()
    {
        DB::table('users')->where('status_id', 1)->update(['status_id' => 2]);
        return redirect('/dashboard/user')->with('berhasil', 'Status telah di update');
    }

    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect('/dashboard/user')->with('berhasil', 'User telah dihapus');
    }

    public function admin(User $user)
    {
        $user = User::find($user->id);
        $user->isAdmin = 1;
        $user->save();
        return redirect('/dashboard/user')->with('berhasil', 'User telah menjadi admin');
    }
}
