<?php

namespace App\Http\Controllers\Admin;

use App\Models\Active;
use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $candidates = Candidate::orderBy('start', 'DESC')->with('active')->get();
        $candidatesData = Candidate::where('active_id', 2)->where('total_votes', '>=', 1)->get();
        $data = [];
        foreach ($candidatesData as $item) {
            $data['label'][] = $item->name;
            $data['data'][] = (int) $item->total_votes;
        }
        $data['chart_data'] = json_encode($data);
        return view('dashboard.index', compact('candidates'), $data);
    }

    public function create()
    {
        return view('dashboard.create');
    }

    public function store(Request $request)
    {
        $url = 'https://www.timeapi.io/api/Time/current/zone?timeZone=Asia/Jakarta';
        $content = file_get_contents($url);
        $date = json_decode($content, true);

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'visi' => 'required',
            'misi' => 'required',
            'image_path' => 'nullable|image',
            'start' => 'required',
            'end' => 'required',
        ]);

        if ($request->file('image_path')) {
            $validatedData['image_path'] = $request->file('image_path')->store('candidates-images');
        }
        if ($validatedData['end'] >= $date['date'] && $validatedData['start'] <= $date['date']) {
            $validatedData['active_id'] = 1;
        } else {
            $validatedData['active_id'] = 2;
        }
        Candidate::create($validatedData);
        return redirect('/dashboard')->with('berhasil', 'Kandidat telah dibuat');
    }

    public function edit(Candidate $candidate)
    {
        return view('dashboard.edit', [
            'candidate' => $candidate,
            'actives' => Active::all(),
        ]);
    }

    public function update(Request $request, Candidate $candidate)
    {
        $rules = [
            'name' => 'required|max:255',
            'visi' => 'required',
            'misi' => 'required',
            'image_path' => 'nullable|image',
            'start' => 'required',
            'end' => 'required',
            'active_id' => 'required',
        ];
        $validatedData = $request->validate($rules);

        if ($request->file('image_path')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);

                $validatedData['image_path'] = $request->file('image_path')->store('candidates-images');
            }
        }
        Candidate::where('id', $candidate->id)->update($validatedData);
        return redirect('/dashboard')->with('berhasil', 'Kandidat telah diupdate');
    }

    public function destroy(Candidate $candidate)
    {
        if ($candidate->image_path) {
            Storage::delete($candidate->image_path);
        }
        Candidate::destroy($candidate->id);
        return redirect('/dashboard')->with('berhasil', 'Kandidat telah dihapus');
    }
}
