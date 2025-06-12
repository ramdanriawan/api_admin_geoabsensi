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
                          action="{{ url(route('web.admin.userShift.update', ['userShift' => $userShift->id])) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="form-group">
                            <label>User</label>

                            <select name="user_id" class="form-control" id="select2-1">

                                <option selected
                                        value="{{ $userShift->user_id }}"> {{ $userShift->user->name }}
                                </option>
                                <option
                                    value="">-- Select User --
                                </option>
                            </select>

                            @if ($errors->has('user_id'))
                                <span class="bg-danger">{{ $errors->first('user_id') }}</span>
                            @endif
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label>Shift</label>

                            <select name="shift_id" class="form-control" id="select2-2">
                                <option selected
                                        value="{{ $userShift->shift_id }}"> {{ $userShift->shift->name }}
                                </option>

                                <option
                                    value="">-- Select Shift --
                                </option>
                            </select>

                            @if ($errors->has('shift_id'))
                                <span class="bg-danger">{{ $errors->first('shift_id') }}</span>
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
            // Inisialisasi Select2
            $('#select2-1').select2({
                placeholder: "Pilih User",
                ajax: {
                    url: "{{ url(route('api.v1.web.admin.userShift.getUserSelect2')) }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {

                        return {
                            results: data.items.map(function (item) {
                                return {id: item.id, text: item.name};
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#select2-2').select2({
                placeholder: "Pilih Shift",
                ajax: {
                    url: "{{ url(route('api.v1.web.admin.userShift.getShiftSelect2')) }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {

                        return {
                            results: data.items.map(function (item) {
                                return {id: item.id, text: item.name};
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
@endsection

