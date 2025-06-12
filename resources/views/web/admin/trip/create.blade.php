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
                    <form method="post" action="{{ url(route('web.admin.trip.store')) }}" enctype="multipart/form-data">
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
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="email" name="email"
                                   value="{{ old('email') == '' ? '' : old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="bg-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Password (Default: trip1234)</label>
                            <input type="password" class="form-control" placeholder="password" name="password"
                                   value="{{ old('password') == '' ? 'trip1234' : old('password') }}" required>

                            @if ($errors->has('password'))
                                <span class="bg-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Password Confirmation</label>
                            <input type="password" class="form-control" placeholder="password" name="password_confirmation"
                                   value="{{ old('password_confirmation') == '' ? 'trip1234' : old('password_confirmation') }}" required>

                            @if ($errors->has('password_confirmation'))
                                <span class="bg-danger">{{ $errors->first('password_confirmation') }}</span>
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

