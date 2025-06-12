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
                          action="{{ url(route('web.admin.employeeOffDay.store')) }}"
                          enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div class="form-group">
                            <label>Employee</label>

                            <select name="employee_id" class="form-control" id="select2-1">
                                <option
                                    value="">-- Select Employee --
                                </option>
                            </select>

                            @if ($errors->has('employee_id'))
                                <span class="bg-danger">{{ $errors->first('employee_id') }}</span>
                            @endif
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label>Off Type</label>

                            <select name="off_type_id" class="form-control" id="select2-2">
                                <option
                                    value="">-- Select Off Type --
                                </option>
                            </select>

                            @if ($errors->has('off_type_id'))
                                <span class="bg-danger">{{ $errors->first('off_type_id') }}</span>
                            @endif
                        </div>


                        <div class="form-group">
                            <label>Quota</label>
                            <input type="number" class="form-control" placeholder="quota" name="quota"
                                   value="{{ old('quota') == '' ? '' : old('quota') }}" required>

                            @if ($errors->has('quota'))
                                <span class="bg-danger">{{ $errors->first('quota') }}</span>
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
                placeholder: "Pilih Employee",
                ajax: {
                    url: "{{ url(route('api.v1.web.admin.employeeOffDay.getEmployeeSelect2')) }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {

                        return {
                            results: data.items.map(function (item) {
                                return {id: item.id, text: item.user.name};
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#select2-2').select2({
                placeholder: "Pilih OffDay",
                ajax: {
                    url: "{{ url(route('api.v1.web.admin.employeeOffDay.getOffTypeSelect2')) }}",
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

