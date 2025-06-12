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
                    <form method="post" action="{{ url(route('web.admin.motivational.store')) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Word</label>
                            <input type="word" class="form-control" placeholder="word" name="word"
                                   value="{{ old('word') == '' ? '' : old('word') }}" required>

                            @if ($errors->has('word'))
                                <span class="bg-danger">{{ $errors->first('word') }}</span>
                            @endif
                        </div>

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

