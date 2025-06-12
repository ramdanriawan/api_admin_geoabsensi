@extends('web.admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-6 col-md-6 col-lg-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Edit</h3>

                    @if(session()->has('success') && !session()->get('success'))
                        <strong style="color: red;">{{ session()->get('message') }}</strong>
                    @endif

                    <form id="form" method="POST" action="{{ url(route('web.admin.paySlip.update', $paySlip->id)) }}">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" value="{{ $paySlip->id }}">

                        <div class="form-group">
                            <label>User</label>
                            <select name="user_id" class="form-control" id="select2-1">
                                <option value="">-- Select User --</option>
                            </select>
                            @error('user_id')
                            <span class="bg-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Period Start</label>
                            <input id="periodStart" type="date" name="period_start"
                                   class="form-control @error('period_start') is-invalid @enderror"
                                   value="{{ old('period_start', $paySlip->period_start ? $paySlip->period_start : '') }}"
                                   required>
                            @error('period_start')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Period End</label>
                            <input id="periodEnd" type="date" name="period_end"
                                   class="form-control @error('period_end') is-invalid @enderror"
                                   value="{{ old('period_end', $paySlip->period_end ? $paySlip->period_end : '') }}"
                                   required>
                            @error('period_end')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Basic Salary</label>
                            <input type="number" step="0.01" name="basic_salary" id="basic_salary"
                                   class="form-control @error('basic_salary') is-invalid @enderror"
                                   value="{{ old('basic_salary', $paySlip->basic_salary) }}" required>
                            @error('basic_salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Extra Fields with Percentage Buttons --}}
                        <div class="form-group">
                            <label>BPJS Kesehatan</label>
                            <div class="field-with-button">
                                <input type="number" step="0.01" name="deduction_bpjs_kesehatan"
                                       id="deduction_bpjs_kesehatan"
                                       class="form-control @error('deduction_bpjs_kesehatan') is-invalid @enderror"
                                       value="{{ old('deduction_bpjs_kesehatan', $paySlip->deduction_bpjs_kesehatan) }}"
                                       readonly>
                                <div class="d-flex gap-1">
                                    <button type="button" class="percent-button deduction_bpjs_kesehatan"
                                            onclick="applyPercentage(this, 'deduction_bpjs_kesehatan', 1)">1%
                                    </button>
                                    <button type="button" class="percent-button deduction_bpjs_kesehatan"
                                            onclick="applyPercentage(this, 'deduction_bpjs_kesehatan', 2)">2%
                                    </button>
                                    <button type="button" class="percent-button deduction_bpjs_kesehatan"
                                            onclick="applyPercentage(this, 'deduction_bpjs_kesehatan', 3)">3%
                                    </button>
                                    <button type="button" class="percent-button deduction_bpjs_kesehatan"
                                            onclick="applyPercentage(this, 'deduction_bpjs_kesehatan', 4)">4%
                                    </button>
                                    <button type="button" class="percent-button deduction_bpjs_kesehatan"
                                            onclick="applyPercentage(this, 'deduction_bpjs_kesehatan', 5)">5%
                                    </button>
                                </div>
                            </div>
                            @error('deduction_bpjs_kesehatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>BPJS Ketenagakerjaan</label>
                            <div class="field-with-button">
                                <input type="number" step="0.01" name="deduction_bpjs_ketenagakerjaan"
                                       id="deduction_bpjs_ketenagakerjaan"
                                       class="form-control @error('deduction_bpjs_ketenagakerjaan') is-invalid @enderror"
                                       value="{{ old('deduction_bpjs_ketenagakerjaan', $paySlip->deduction_bpjs_ketenagakerjaan) }}"
                                       readonly>
                                <div class="d-flex gap-1">
                                    <button type="button" class="percent-button deduction_bpjs_ketenagakerjaan"
                                            onclick="applyPercentage(this, 'deduction_bpjs_ketenagakerjaan', 1)">1%
                                    </button>
                                    <button type="button" class="percent-button deduction_bpjs_ketenagakerjaan"
                                            onclick="applyPercentage(this, 'deduction_bpjs_ketenagakerjaan', 2)">2%
                                    </button>
                                    <button type="button" class="percent-button deduction_bpjs_ketenagakerjaan"
                                            onclick="applyPercentage(this, 'deduction_bpjs_ketenagakerjaan', 3)">3%
                                    </button>
                                    <button type="button" class="percent-button deduction_bpjs_ketenagakerjaan"
                                            onclick="applyPercentage(this, 'deduction_bpjs_ketenagakerjaan', 4)">4%
                                    </button>
                                    <button type="button" class="percent-button deduction_bpjs_ketenagakerjaan"
                                            onclick="applyPercentage(this, 'deduction_bpjs_ketenagakerjaan', 5)">5%
                                    </button>
                                </div>
                            </div>
                            @error('deduction_bpjs_ketenagakerjaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>PPH 21</label>
                            <div class="field-with-button">
                                <input type="number" step="0.01" name="deduction_pph21"
                                       id="deduction_pph21"
                                       class="form-control @error('deduction_pph21') is-invalid @enderror"
                                       value="{{ old('deduction_pph21', $paySlip->deduction_pph21) }}" readonly>
                                <div class="d-flex gap-1">
                                    <button type="button" class="percent-button deduction_pph21"
                                            onclick="applyPercentage(this, 'deduction_pph21', 5)">5%
                                    </button>
                                    <button type="button" class="percent-button deduction_pph21"
                                            onclick="applyPercentage(this, 'deduction_pph21', 10)">10%
                                    </button>
                                    <button type="button" class="percent-button deduction_pph21"
                                            onclick="applyPercentage(this, 'deduction_pph21', 15)">15%
                                    </button>
                                    <button type="button" class="percent-button deduction_pph21"
                                            onclick="applyPercentage(this, 'deduction_pph21', 20)">20%
                                    </button>
                                    <button type="button" class="percent-button deduction_pph21"
                                            onclick="applyPercentage(this, 'deduction_pph21', 35)">35%
                                    </button>
                                </div>
                            </div>
                            @error('deduction_pph21')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Repeat for all other fields with $paySlip->fieldname --}}
                        <div class="form-group">
                            <label>Deduction (Late or Leave)</label>
                            <input id="deductionLateOrLeave" type="number" step="100" name="deduction_late_or_leave"
                                   class="form-control @error('deduction_late_or_leave') is-invalid @enderror"
                                   value="{{ old('deduction_late_or_leave', $paySlip->deduction_late_or_leave) }}">
                            @error('deduction_late_or_leave')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Meal Allowance</label>
                            <input id="mealAllowance" type="number" step="0.01" name="meal_allowance"
                                   class="form-control @error('meal_allowance') is-invalid @enderror"
                                   value="{{ old('meal_allowance', $paySlip->meal_allowance) }}">
                            @error('meal_allowance')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Transport Allowance</label>
                            <input id="transportAllowance" type="number" step="0.01" name="transport_allowance"
                                   class="form-control @error('transport_allowance') is-invalid @enderror"
                                   value="{{ old('transport_allowance', $paySlip->transport_allowance) }}">
                            @error('transport_allowance')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Over Time Pay</label>
                            <input id="overTimePay" type="number" step="0.01" name="overTime_pay"
                                   class="form-control @error('overTime_pay') is-invalid @enderror"
                                   value="{{ old('overTime_pay', $paySlip->overTime_pay) }}">
                            @error('overTime_pay')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Bonus</label>
                            <input type="number" step="0.01" name="bonus"
                                   class="form-control @error('bonus') is-invalid @enderror"
                                   value="{{ old('bonus', $paySlip->bonus) }}">
                            @error('bonus')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Note</label>
                            <textarea name="note"
                                      class="form-control @error('note') is-invalid @enderror">{{ old('note', $paySlip->note) }}</textarea>
                            @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option
                                    value="waiting" {{ old('status', $paySlip->status) == 'waiting' ? 'selected' : '' }}>
                                    Waiting
                                </option>
                                <option
                                    value="agreed" {{ old('status', $paySlip->status) == 'agreed' ? 'selected' : '' }}>
                                    Agreed
                                </option>
                                <option
                                    value="disagreed" {{ old('status', $paySlip->status) == 'disagreed' ? 'selected' : '' }}>
                                    Disagreed
                                </option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-in-this-page')
    <style>
        .field-with-button {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .field-with-button input {
            flex: 1;
        }

        .percent-button {
            padding: 6px 12px;
            background-color: #f1f1f1;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
        }

        .percent-button:hover {
            background-color: #e0e0e0;
        }
    </style>

    <script>
        function applyPercentage(e, fieldId, percentage) {
            console.log($(e))

            $(`.` + fieldId).css({
                backgroundColor: 'white',
                color: 'initial'
            });

            $(e).css({
                backgroundColor: '#03A9F4',
                color: 'white'
            });

            const basicSalary = parseFloat(document.getElementById('basic_salary').value) || 0;
            const result = (basicSalary * percentage / 100).toFixed(0);
            document.getElementById(fieldId).value = result;
        }
    </script>

    <script>
        $(document).ready(function () {
            $('#select2-1').select2({
                placeholder: "Pilih User",
                ajax: {
                    url: "{{ url(route('api.v1.web.admin.paySlip.getUserSelect2')) }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: data.items.map(function (item) {
                                return {id: item.id, text: item.name, item: item};
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#select2-1').on('select2:select', function (e) {
                let selectedItem = e.params.data.item;

                console.log("Selected Item:", selectedItem);

                // set default valuenya untuk user itu
                $('#basic_salary').val(selectedItem.employee.title.basic_salary);
            });


            $('#periodStart, #periodEnd, #select2-1').on('change', function (e) {

                if (!$('#select2-1').val()) {
                    alert('User must be selected!')
                }

                $.ajax({
                    url: '{{ url(route('api.v1.web.admin.recape.getByUserFromStartDateToEndDate')) }}',
                    data: {
                        user_id: $('#select2-1').val(),
                        start_date: $('#periodStart').val(),
                        end_date: $('#periodEnd').val()
                    },
                    success: function (responseJson) {
                        var recape = responseJson.data;

                        $('#deductionLateOrLeave').val(recape.deduction_late_or_leave);
                        $('#mealAllowance').val(recape.meal_allowance);
                        $('#transportAllowance').val(recape.transport_allowance);
                        $('#overTimePay').val(recape.overTime_pay);
                    },
                    error: function (xhr, status, error) {
                        let response = {};

                        try {
                            // Coba parse response JSON
                            response = JSON.parse(xhr.responseText);
                        } catch (e) {
                            console.warn("Not valid json to parse:", e);
                        }

                        if (xhr.status === 404 && response.message) {
                            alert(response.message); // ✅ Ini pesan dari server
                        } else {
                            alert("Error: " + error);
                        }
                    }
                })
            });

            @if(isset($paySlip->user))
            const userOption = new Option("{{ $paySlip->user->name }}", "{{ $paySlip->user_id }}", true, true);
            $('#select2-1').append(userOption).trigger('change');
            @endif
        });
    </script>
@endsection
