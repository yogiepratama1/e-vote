<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{
    use WithPagination;
    public $searchTerm;
    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $users = User::orderBy('status_id', 'ASC')->where('name', 'like', $searchTerm)->paginate(10);
        $totals = DB::table('users')
            ->selectRaw('count(*) as total')
            ->selectRaw("count(case when status_id = '1' then 1 end) as voted")
            ->selectRaw("count(case when status_id = '2' then 1 end) as unvoted")
            ->first();
        return view('livewire.search', compact('users', 'totals'));
    }
}
