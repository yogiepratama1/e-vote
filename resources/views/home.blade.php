<x-guest-layout>
    <nav x-data="{ open: false }" class="border-b border-gray-100" style="background: #396EB0;">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Navigation Links -->
                    <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-jet-nav-link href="{{ route('vote.index') }}" :active="request()->routeIs('vote.index')">
                            Home
                        </x-jet-nav-link>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center text-3xl my-3 ">
            Pilih salah satu kandidat ini
        </h1>
        @if(session()->has('berhasil'))
        <div class="mx-auto w-80 bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 my-3 shadow-md" role="alert">
            <p class="font-bold text-center">{{ session('berhasil') }}</p>
        </div>
        @endif
        <div class="row">
            <div class="grid md:grid-cols-2 grid-cols-1 md:gap-0 gap-5">
                @foreach($candidates as $candidate)
                <div class="mx-auto md::w-4/5 sm:w-11/12 w-11/12 h-full text-white " style="background: linear-gradient(102.6deg, #396EB0 0%, #09C6F9 83.9%);border-radius: 5px;">
                    <h1 class="text-center mt-4 text-sm">{{ \Carbon\Carbon::parse($candidate->end)->translatedFormat('l, j F Y ') }}</h1>
                    <div class="w-4/5 h-full mx-auto md:p-7 p-2">
                        <img src="{{ $candidate->image_path) }}" alt="candidateimg">
                        <h1 class="text-center my-2 md:text-2xl text-xl">{{ $candidate->name }}</h1>
                        <div class="text-center my-6">
                            <h1>Visi</h1>
                            <p class="text-sm">{!! $candidate->visi !!}</p>
                        </div>
                        <div class="text-center">
                            <h1>Misi</h1>
                            <p class="text-sm">{!! $candidate->misi !!}</p>
                        </div>
                        <div class="flex justify-center my-5">
                            @if(auth()->user()->status_id === 2)
                            <form action="/vote/{{ $candidate->id }}" method="POST">
                                @method('PUT')
                                @csrf
                                <button class="p-3 w-36 md:text-xl" style="background: #396EB0;border-radius: 100px;">Pilih</button>
                            </form>
                            @else
                            <h1 class="text-red-700 text-sm text-center">Anda Sudah Memilih</h1>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-guest-layout>