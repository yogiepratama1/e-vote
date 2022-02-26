<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Candidate $candidate)
    {
        // $query = Candidate::query();
        // $query->when('end' >= $date['date'] && 'start' <= $date['date'], function ($q) {
        //     return $q->where('isActive', 1);
        // });
        // $candidates = $query->get();

        $url = 'https://www.timeapi.io/api/Time/current/zone?timeZone=Asia/Jakarta';
        $content = file_get_contents($url);
        $date = json_decode($content, true);

        $candidates = Candidate::with('active')->where('active_id', 1)->get();

        if (count($candidates)) {
            $end = Carbon::parse($candidates[0]['end'])->format('m/d/Y');
            $start = Carbon::parse($candidates[0]['start'])->format('m/d/Y');

            if ($end >= $date['date'] && $start <= $date['date']) {
                return view('home', compact('candidates', 'date'));
            } else {
                DB::table('candidates')->where('active_id', 1)->update(['active_id' => 2]);
                return view('novote');
            }
        } else {
            return view('novote');
        }
    }

    public function vote(Candidate $candidate)
    {
        $id = Auth::user()->id;
        $user = User::findorfail($id);
        $user->status_id = 1;
        $user->save();
        if (auth()->user()->status_id == 1) {
            return redirect('/')->with('berhasil', 'Terima kasih atas suara anda');
        } else {
            $candidate->update([
                'total_votes' => DB::raw('total_votes + 1'),
            ]);
            return redirect('/')->with('berhasil', 'Terima kasih atas suara anda');
        }
    }
}
