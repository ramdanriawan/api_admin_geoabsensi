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
                    <form method="post" action="{{ url(route('web.admin.visit.update', ['visit' => $visit->id])) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="form-group">
                            <label>Name</label>
                            <input type="name" class="form-control" placeholder="name" name="name"
                                   value="{{ old('name') == '' ? $visit->name : old('name') }}" required>
                            @if ($errors->has('name'))
                                <span class="bg-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="email" name="email"
                                   value="{{ old('email') == '' ? $visit->email : old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="bg-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <!-- Checkbox toggle -->
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="togglePasswordFields">
                            <label class="form-check-label" for="togglePasswordFields">Ganti Password</label>
                        </div>

                        <!-- Password Fields (Hidden by default) -->
                        <div id="passwordFields" style="display: none;">
                            <div class="form-group">
                                <label>Password (Default: visit1234)</label>
                                <input type="password" class="form-control" placeholder="password" name="password"
                                       value="{{ old('password') }}">
                                @if ($errors->has('password'))
                                    <span class="bg-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Password Confirmation</label>
                                <input type="password" class="form-control" placeholder="password"
                                       name="password_confirmation"
                                       value="{{ old('password_confirmation') }}">
                                @if ($errors->has('password_confirmation'))
                                    <span class="bg-danger">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>
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
    <style>
        #passwordFields {
            transition: all 0.3s ease;
        }
    </style>

    <script>
        document.getElementById('togglePasswordFields').addEventListener('change', function () {
            const passwordFields = document.getElementById('passwordFields');
            passwordFields.style.display = this.checked ? 'block' : 'none';

            // Set 'required' attribute sesuai toggle
            passwordFields.querySelectorAll('input').forEach(input => {
                input.required = this.checked;
            });
        });
    </script>
@endsection
