@extends('web.admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-6 col-md-6 col-lg-6">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <!-- Nav tabs -->
                    <h3>Edit</h3>

                    @if(session()->has('success'))
                        @if(!session()->get('success'))
                            <strong style="color: red;">{{ session()->get('message') }}</strong>
                        @endif
                    @endif

                    <!-- Tab panes -->
                    <form method="post"
                          action="{{ url(route('web.admin.application.update', $application->id)) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" value="{{ $application->id }}">

                        <div class="form-group">
                            <label>Version</label>
                            <input type="text" class="form-control" name="version"
                                   value="{{ old('version', $application->version) }}" required>
                            @error('version')
                            <span class="bg-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name"
                                   value="{{ old('name', $application->name) }}" required>
                            @error('name')
                            <span class="bg-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone"
                                   value="{{ old('phone', $application->phone) }}" required>
                            @error('phone')
                            <span class="bg-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email"
                                   value="{{ old('email', $application->email) }}" required>
                            @error('email')
                            <span class="bg-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Developer Name</label>
                            <input type="text" class="form-control" name="developer_name"
                                   value="{{ old('developer_name', $application->developer_name) }}" required>
                            @error('developer_name')
                            <span class="bg-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Brand</label>
                            <input type="text" class="form-control" name="brand"
                                   value="{{ old('brand', $application->brand) }}" required>
                            @error('brand')
                            <span class="bg-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Website</label>
                            <input type="url" class="form-control" name="website"
                                   value="{{ old('website', $application->website) }}" required>
                            @error('website')
                            <span class="bg-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Release Date</label>
                            <input type="date" class="form-control" name="release_date"
                                   value="{{ old('release_date', $application->release_date) }}" required>
                            @error('release_date')
                            <span class="bg-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Last Update</label>
                            <input type="date" class="form-control" name="last_update"
                                   value="{{ old('last_update', $application->last_update) }}" required>
                            @error('last_update')
                            <span class="bg-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Terms URL</label>
                            <input type="url" class="form-control" name="terms_url"
                                   value="{{ old('terms_url', $application->terms_url) }}" required>
                            @error('terms_url')
                            <span class="bg-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Privacy Policy URL</label>
                            <input type="url" class="form-control" name="privacy_policy_url"
                                   value="{{ old('privacy_policy_url', $application->privacy_policy_url) }}" required>
                            @error('privacy_policy_url')
                            <span class="bg-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Maximum Radius In Meters</label>
                            <input type="number" class="form-control" name="maximum_radius_in_meters"
                                   value="{{ old('maximum_radius_in_meters', $application->maximum_radius_in_meters) }}"
                                   required>
                            @error('maximum_radius_in_meters')
                            <span class="bg-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Is Active?</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_active" id="is_active_yes"
                                       value="1"
                                       {{ old('is_active', $application->is_active) == '1' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="is_active_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_active" id="is_active_no"
                                       value="0"
                                       {{ old('is_active', $application->is_active) == '0' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="is_active_no">No</label>
                            </div>
                            @error('is_active')
                            <span class="bg-danger d-block mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Minimum Visits In Minutes</label>
                            <input type="number" class="form-control" placeholder="minimum_visit_in_minutes" name="minimum_visit_in_minutes"
                                   value="{{ old('minimum_visit_in_minutes', $application->minimum_visit_in_minutes) }}"
                                   required>

                            @if ($errors->has('minimum_visit_in_minutes'))
                                <span class="bg-danger">{{ $errors->first('minimum_visit_in_minutes') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
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
        $(document).ready(function () {
        });
    </script>
@endsection

