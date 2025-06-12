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
                          action="{{ url(route('web.admin.application.store')) }}"
                          enctype="multipart/form-data">
                        @csrf


                        <div class="form-group">
                            <label>Version</label>
                            <input type="version" class="form-control" placeholder="version" name="version"
                                   value="{{ old('version') == '' ? '' : old('version') }}" required>

                            @if ($errors->has('version'))
                                <span class="bg-danger">{{ $errors->first('version') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="name" class="form-control" placeholder="name" name="name"
                                   value="{{ old('name') == '' ? '' : old('name') }}" required>

                            @if ($errors->has('name'))
                                <span class="bg-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="number" class="form-control" placeholder="phone" name="phone"
                                   value="{{ old('phone') == '' ? '' : old('phone') }}" required>

                            @if ($errors->has('phone'))
                                <span class="bg-danger">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="email" name="email"
                                   value="{{ old('email') == '' ? '' : old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="bg-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Developer Name</label>
                            <input type="text" class="form-control" placeholder="developer_name" name="developer_name"
                                   value="{{ old('developer_name') == '' ? '' : old('developer_name') }}" required>

                            @if ($errors->has('developer_name'))
                                <span class="bg-danger">{{ $errors->first('developer_name') }}</span>
                            @endif
                        </div>


                        <div class="form-group">
                            <label>Brand</label>
                            <input type="text" class="form-control" placeholder="brand" name="brand"
                                   value="{{ old('brand') == '' ? '' : old('brand') }}" required>

                            @if ($errors->has('brand'))
                                <span class="bg-danger">{{ $errors->first('brand') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Website</label>
                            <input type="url" class="form-control" placeholder="website" name="website"
                                   value="{{ old('website') == '' ? '' : old('website') }}" required>

                            @if ($errors->has('website'))
                                <span class="bg-danger">{{ $errors->first('website') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Release Date</label>
                            <input type="date" class="form-control" placeholder="release date" name="release_date"
                                   value="{{ old('release_date') == '' ? '' : old('release_date') }}" required>

                            @if ($errors->has('release_date'))
                                <span class="bg-danger">{{ $errors->first('release_date') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Last Update</label>
                            <input type="date" class="form-control" placeholder="last update" name="last_update"
                                   value="{{ old('last_update') == '' ? '' : old('last_update') }}" required>

                            @if ($errors->has('last_update'))
                                <span class="bg-danger">{{ $errors->first('last_update') }}</span>
                            @endif
                        </div>


                        <div class="form-group">
                            <label>Terms url</label>
                            <input type="url" class="form-control" placeholder="terms_url" name="terms_url"
                                   value="{{ old('terms_url') == '' ? '' : old('terms_url') }}" required>

                            @if ($errors->has('terms_url'))
                                <span class="bg-danger">{{ $errors->first('terms_url') }}</span>
                            @endif
                        </div>


                        <div class="form-group">
                            <label>Privacy Policy Url</label>
                            <input type="url" class="form-control" placeholder="privacy_policy_url" name="privacy_policy_url"
                                   value="{{ old('privacy_policy_url') == '' ? '' : old('privacy_policy_url') }}"
                                   required>

                            @if ($errors->has('privacy_policy_url'))
                                <span class="bg-danger">{{ $errors->first('privacy_policy_url') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Maximum Radius In Meters</label>
                            <input type="number" class="form-control" placeholder="maximum_radius_in_meters" name="maximum_radius_in_meters"
                                   value="{{ old('maximum_radius_in_meters') == '' ? '' : old('maximum_radius_in_meters') }}"
                                   required>

                            @if ($errors->has('maximum_radius_in_meters'))
                                <span class="bg-danger">{{ $errors->first('maximum_radius_in_meters') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Minimum Visits In Minutes</label>
                            <input type="number" class="form-control" placeholder="minimum_visit_in_minutes" name="minimum_visit_in_minutes"
                                   value="{{ old('minimum_visit_in_minutes') == '' ? '' : old('minimum_visit_in_minutes') }}"
                                   required>

                            @if ($errors->has('minimum_visit_in_minutes'))
                                <span class="bg-danger">{{ $errors->first('minimum_visit_in_minutes') }}</span>
                            @endif
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
        $(document).ready(function () {

        });
    </script>
@endsection

