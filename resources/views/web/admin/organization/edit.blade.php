@extends('web.admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-6 col-md-6 col-lg-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Edit Organization</h3>

                    @if(session()->has('success'))
                        @if(!session()->get('success'))
                            <strong style="color: red;">{{ session()->get('message') }}</strong>
                        @endif
                    @endif

                    <form method="post"
                          action="{{ url(route('web.admin.organization.update', $organization->id)) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="name" name="name"
                                   value="{{ old('name', $organization->name) }}" required>
                            @error('name')
                            <span class="bg-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="logo">Upload Logo</label>
                            <input type="file" class="form-control" name="logo" id="logo" accept="image/*"
                                   onchange="previewLogo(event)">
                            @error('logo')
                            <span class="bg-danger d-block mt-2">{{ $message }}</span>
                            @enderror

                            <div class="mt-3">
                                <img id="logo-preview"
                                     src="{{ $organization->logo ? asset('storage/' . $organization->logo) : '#' }}"
                                     alt="Preview"
                                     style="max-height: 200px; {{ $organization->logo ? '' : 'display:none;' }}"
                                     class="img-thumbnail">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" placeholder="description"
                                      required>{{ old('description', $organization->description) }}</textarea>
                            @error('description')
                            <span class="bg-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Location (Latitude & Longitude)</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Latitude" name="lat"
                                           value="{{ old('lat', $organization->lat) }}" required>
                                    @error('lat')
                                    <span class="bg-danger d-block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Longitude" name="lng"
                                           value="{{ old('lng', $organization->lng) }}" required>
                                    @error('lng')
                                    <span class="bg-danger d-block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Is Active?</label><br>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_active" id="is_active_yes"
                                       value="1"
                                       {{ old('is_active', $organization->is_active) == 1 ? 'checked' : '' }} required>
                                <label class="form-check-label" for="is_active_yes">Yes</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_active" id="is_active_no"
                                       value="0"
                                       {{ old('is_active', $organization->is_active) == 0 ? 'checked' : '' }} required>
                                <label class="form-check-label" for="is_active_no">No</label>
                            </div>

                            @error('is_active')
                            <span class="bg-danger text-white p-1 d-block mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script-in-this-page')
    <script>
        function previewLogo(event) {
            const reader = new FileReader();
            const imageField = document.getElementById('logo-preview');

            reader.onload = function () {
                imageField.src = reader.result;
                imageField.style.display = 'block';
            };

            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
