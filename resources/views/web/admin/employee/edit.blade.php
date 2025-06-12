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
                          action="{{ url(route('web.admin.employee.update', ['employee' => $employee->id])) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="form-group">
                            <label>User</label>

                            <select name="user_id" class="form-control" id="select2-1">

                                <option selected
                                    value="{{ $employee->user_id }}"> {{ $employee->user->name }}
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
                            <label>Title</label>

                            <select name="title_id" class="form-control" id="select2-2">
                                <option selected
                                    value="{{ $employee->title_id }}"> {{ $employee->title->name }}
                                </option>

                                <option
                                    value="">-- Select Title --
                                </option>
                            </select>

                            @if ($errors->has('title_id'))
                                <span class="bg-danger">{{ $errors->first('title_id') }}</span>
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
                    url: "{{ url(route('api.v1.web.admin.user.select2')) }}",
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
                placeholder: "Pilih Title",
                ajax: {
                    url: "{{ url(route('api.v1.web.admin.title.select2')) }}",
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

