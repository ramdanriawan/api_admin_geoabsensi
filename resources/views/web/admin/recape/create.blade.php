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
                    <form method="POST" action="{{ route('web.admin.recape.store') }}">
                        @csrf

                        <!-- User ID -->
                        <div class="form-group">
                            <label>User ID</label>
                            <input type="number" class="form-control" name="user_id" value="{{ old('user_id') }}"
                                   required>
                            @error('user_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Period Start -->
                        <div class="form-group">
                            <label>Period Start</label>
                            <input type="date" class="form-control" name="period_start"
                                   value="{{ old('period_start') }}" required>
                            @error('period_start') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Period End -->
                        <div class="form-group">
                            <label>Period End</label>
                            <input type="date" class="form-control" name="period_end" value="{{ old('period_end') }}"
                                   required>
                            @error('period_end') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Basic Salary -->
                        <div class="form-group">
                            <label>Basic Salary</label>
                            <input type="number" step="0.01" class="form-control" name="basic_salary"
                                   value="{{ old('basic_salary', 0) }}">
                        </div>

                        <!-- Meal Allowance -->
                        <div class="form-group">
                            <label>Meal Allowance</label>
                            <input type="number" step="0.01" class="form-control" name="meal_allowance"
                                   value="{{ old('meal_allowance', 0) }}">
                        </div>

                        <!-- Transport Allowance -->
                        <div class="form-group">
                            <label>Transport Allowance</label>
                            <input type="number" step="0.01" class="form-control" name="transport_allowance"
                                   value="{{ old('transport_allowance', 0) }}">
                        </div>

                        <!-- Overtime Pay -->
                        <div class="form-group">
                            <label>Overtime Pay</label>
                            <input type="number" step="0.01" class="form-control" name="overtime_pay"
                                   value="{{ old('overtime_pay', 0) }}">
                        </div>

                        <!-- Bonus -->
                        <div class="form-group">
                            <label>Bonus</label>
                            <input type="number" step="0.01" class="form-control" name="bonus"
                                   value="{{ old('bonus', 0) }}">
                        </div>

                        <!-- Deductions -->
                        <div class="form-group">
                            <label>BPJS Health Deduction</label>
                            <input type="number" step="0.01" class="form-control" name="deduction_bpjs_kesehatan"
                                   value="{{ old('deduction_bpjs_kesehatan', 0) }}">
                        </div>

                        <div class="form-group">
                            <label>BPJS Employment Deduction</label>
                            <input type="number" step="0.01" class="form-control" name="deduction_bpjs_ketenagakerjaan"
                                   value="{{ old('deduction_bpjs_ketenagakerjaan', 0) }}">
                        </div>

                        <div class="form-group">
                            <label>PPh21 Deduction</label>
                            <input type="number" step="0.01" class="form-control" name="deduction_pph21"
                                   value="{{ old('deduction_pph21', 0) }}">
                        </div>

                        <div class="form-group">
                            <label>Late/Leave Deduction</label>
                            <input type="number" step="0.01" class="form-control" name="deduction_late_or_leave"
                                   value="{{ old('deduction_late_or_leave', 0) }}">
                        </div>

                        <!-- Submit -->
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

