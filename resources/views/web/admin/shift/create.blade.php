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
                    <form method="post" action="{{ route('web.admin.shift.store') }}">
                        @csrf

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            @error('name') <span class="bg-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Start Time</label>
                            <input type="time" class="form-control" name="start_time" value="{{ old('start_time') }}"
                                   required>
                            @error('start_time') <span class="bg-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>End Time</label>
                            <input type="time" class="form-control" name="end_time" value="{{ old('end_time') }}"
                                   required>
                            @error('end_time') <span class="bg-danger">{{ $message }}</span> @enderror
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
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
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
                placeholder: "Pilih Shift",
                ajax: {
                    url: "{{ url(route('api.v1.web.admin.shift.select2')) }}",
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

