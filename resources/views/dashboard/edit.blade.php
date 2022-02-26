@extends('layouts.admin')
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
            <form method="POST" action="/dashboard/update/{{ $candidate->id }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="@error('name') is-invalid @enderror form-control" value="{{ old('name', $candidate->name) }}" autofocus required>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="visi" class="form-label">Visi</label>
                    <input id="visi" required class="@error('visi') is-invalid @enderror form-control" type="hidden" name="visi" value="{{ old('visi', $candidate->visi) }}" />
                    <trix-editor input="visi"></trix-editor>
                    @error('visi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="misi" class="form-label">Misi</label>
                    <input id="misi" required class="@error('misi') is-invalid @enderror form-control" type="hidden" name="misi" value="{{ old('misi', $candidate->misi) }}" />
                    <trix-editor input="misi"></trix-editor>
                    @error('misi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image_path" class="form-label">Image</label>
                    <input type="hidden" name="oldImage" value="{{ $candidate->image_path }}">
                    @if($candidate->image_path)
                    <img class="img-preview img-fluid" src="{{ asset('storage/' . $candidate->image_path) }}">
                    @else
                    <img class="img-preview img-fluid">
                    @endif
                    <input class="form-control @error('image_path') is-invalid @enderror" name="image_path" id="image" type="file" onchange="previewImage()">
                    @error('image_path')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="start">Start</label>
                    <input type="date" id="start" name="start" class="form-control @error('start') is-invalid @enderror" value="{{ old('start', $candidate->start->format('Y-m-d')) }}" required>
                    @error('start')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="end">End</label>
                    <input type="date" id="end" name="end" class="form-control @error('end') is-invalid @enderror" value="{{ old('end', $candidate->end->format('Y-m-d')) }}" required>
                    @error('end')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="active_id" class="form-label">Status Active</label>
                    <select name="active_id" id="active_id" class="form-control">
                        @foreach ($actives as $active)
                        @if(old('active_id', $candidate->active_id) == $active->id)
                        <option value="{{ $active->id }}" selected>{{ $active->name }}</option>
                        @else
                        <option value="{{ $active->id }}">{{ $active->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
    function previewImage() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>