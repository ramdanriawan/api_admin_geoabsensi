@extends('web.admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-6 col-md-6 col-lg-6">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <!-- Nav tabs -->
                    <h3>Add</h3>

                    @if(session()->has('success'))
                        @if(!session()->get('success'))
                            <strong style="color: red;">{{ session()->get('message') }}</strong>
                        @endif
                    @endif

                    <!-- Tab panes -->
                    <form method="post"
                          action="{{ url(route('web.admin.organization.store')) }}"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Name</label>
                            <input type="name" class="form-control" placeholder="name" name="name"
                                   value="{{ old('name') == '' ? '' : old('name') }}" required>

                            @if ($errors->has('name'))
                                <span class="bg-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="logo">Upload Logo</label>
                            <input type="file" class="form-control" name="logo" id="logo" accept="image/*"
                                   onchange="previewLogo(event)" required>

                            @if ($errors->has('logo'))
                                <span class="bg-danger d-block mt-2">{{ $errors->first('logo') }}</span>
                            @endif

                            <div class="mt-3">
                                <img id="logo-preview" src="#" alt="Preview" style="max-height: 200px; display: none;"
                                     class="img-thumbnail">
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" placeholder="description" name="description"
                                      required>{{ old('description') == '' ? '' : old('description') }}</textarea>

                            @if ($errors->has('description'))
                                <span class="bg-danger">{{ $errors->first('description') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Location (Latitude & Longitude)</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Latitude" name="lat"
                                           value="{{ old('lat') ?? '' }}" required>
                                    @if ($errors->has('lat'))
                                        <span class="bg-danger d-block mt-1">{{ $errors->first('lat') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Longitude" name="lng"
                                           value="{{ old('lng') ?? '' }}" required>
                                    @if ($errors->has('lng'))
                                        <span class="bg-danger d-block mt-1">{{ $errors->first('lng') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Is Active?</label><br>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_active" id="is_active_yes"
                                       value="1"
                                       {{ old('is_active') === '1' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="is_active_yes">Yes</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_active" id="is_active_no"
                                       value="0"
                                       {{ old('is_active') === '0' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="is_active_no">No</label>
                            </div>

                            @if ($errors->has('is_active'))
                                <span
                                    class="bg-danger text-white p-1 d-block mt-1">{{ $errors->first('is_active') }}</span>
                            @endif
                        </div>

                        <!-- Submit Buttons -->
                        <div class="form-group">
                            <button type="submit" value="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" value="submit" class="btn btn-warning">Reset</button>
                        </div>
                    </form>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
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

    <script>
        $(document).ready(function () {
            // Inisialisasi Select2

        });
    </script>
@endsection

