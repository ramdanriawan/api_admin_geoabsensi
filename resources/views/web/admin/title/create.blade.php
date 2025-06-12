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
                    <form method="post" action="{{ url(route('web.admin.title.store')) }}"
                          enctype="multipart/form-data">
                        @csrf

                        {{-- Name --}}
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Name"
                                   value="{{ old('name') }}"
                                   required>
                            @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Basic Salary --}}
                        <div class="form-group">
                            <label>Basic Salary</label>
                            <input type="number"
                                   step="0.01"
                                   name="basic_salary"
                                   class="form-control @error('basic_salary') is-invalid @enderror"
                                   value="{{ old('basic_salary', 0) }}">
                            @error('basic_salary')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Penalty per Late --}}
                        <div class="form-group">
                            <label>Penalty per Late</label>
                            <input type="number"
                                   step="0.01"
                                   name="penalty_per_late"
                                   class="form-control @error('penalty_per_late') is-invalid @enderror"
                                   value="{{ old('penalty_per_late', 0) }}">
                            @error('penalty_per_late')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Meal Allowance per Present --}}
                        <div class="form-group">
                            <label>Meal Allowance per Present</label>
                            <input type="number"
                                   step="0.01"
                                   name="meal_allowance_per_present"
                                   class="form-control @error('meal_allowance_per_present') is-invalid @enderror"
                                   value="{{ old('meal_allowance_per_present', 0) }}">
                            @error('meal_allowance_per_present')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Transport Allowance per Present --}}
                        <div class="form-group">
                            <label>Transport Allowance per Present</label>
                            <input type="number"
                                   step="0.01"
                                   name="transport_allowance_per_present"
                                   class="form-control @error('transport_allowance_per_present') is-invalid @enderror"
                                   value="{{ old('transport_allowance_per_present', 0) }}">
                            @error('transport_allowance_per_present')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Overtime Pay per Hour --}}
                        <div class="form-group">
                            <label>Overtime Pay per Hour</label>
                            <input type="number"
                                   step="0.01"
                                   name="overTime_pay_per_hours"
                                   class="form-control @error('overTime_pay_per_hours') is-invalid @enderror"
                                   value="{{ old('overTime_pay_per_hours', 0) }}">
                            @error('overTime_pay_per_hours')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Submit & Reset --}}
                        <div class="form-group mt-3">
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

