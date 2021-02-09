@extends('layouts.student-app')
@section('title', 'Multiple Fee Transaction')
@section('content')
    <style type="text/css">
        .warning{border-color: red}
    </style>
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area example-screen">
            <h3>{{ __('text.Fee Collection') }}</h3>
            <ul>
                <li>
                    <a href="{{ URL::previous() }}" class="mr-2">
                        {{ __('text.Back') }}|</a>
                    <a href="{{ route(current_user()->role . '.home') }}">{{ __('text.Home') }}</a>
                </li>
                <li>
                    <a href="{{ route('accountant.all-student',['class' =>  $student->section->class['id'],'section' => $student['section']['id']]) }}"> {{ __('text.Collect Fee') }}</a>
                </li>
                <li>{{ __('text.Fee Collection') }}</li>
            </ul>
        </div>

        <div class="card height-auto mb-3 example-screen">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <img src="{{url($student->pic_path)}}" style="height: 130px;" alt="">
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <table class="table">
                                <tr>
                                    <th>{{ __('text.Name') }}</th>
                                    <td><a class="text-teal" href="{{url('user/'.$student->student_code)}}">{{$student->name}}</a></td>
                                </tr>
                                <tr>
                                    <th>{{ __('text.class_section') }}</th>
                                    <td> Class {{ $student->section->class['class_number'] }} ({{ $student->section['section_number'] }})</td>
                                </tr>
                                <tr>
                                    <th>{{ __('text.balance') }}</th>
                                    <td colspan="3">{{ number_format($student->studentInfo['advance_amount'], 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form class="new-added-form fee-transaction" id="fee-transaction" action="{{ url(auth()->user()->role.'/multiple-fee') }}" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <p>{{ __('text.Name') }}: <b>{{ $student['name'] }}</b>, {{ __('text.Class') }}: <b>{{ $student->section['class']['class_number'].' ('. $student['section']['section_number'] .')' }}</b> </p>
                            <div class="table-responsive ">
                                <table id="fees" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkAll" class="fee_types" title="Select All" /></th>
                                            <th width="65%">{{ __('text.fee_name') }}</th>
                                            <th width="30%">{{ __('text.amount') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($feeTypes) > 0)
                                        @foreach($feeTypes as $item)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="selected_fees[]" id="ft_{{$item->id}}"
                                                           value="{{$item->id}}"
                                                           @if(@in_array($item->id, old('selected_fees'))) checked
                                                           @endif class="fee_types"/>
                                                </td>
                                                <td>
                                                    <p>{{ $item->name }}</p>
                                                    @if($item->type == 'monthly')
                                                        <select name="{{$item->id}}_from" id="{{$item->id}}_from"
                                                                class="form-control d-inline-block w-auto ">
                                                            <option value="">From Month</option>
                                                            @foreach($months as $month)
                                                                <option value="{{ $month }}">{{ $month }}</option>
                                                            @endforeach
                                                        </select> -
                                                        <select name="{{$item->id}}_to" id="{{$item->id}}_to"
                                                                class="form-control month_dropdown d-inline-block w-auto">
                                                            <option value="">To Month</option>
                                                            @foreach($months as $month)
                                                                <option value="{{ $month }}">{{ $month }}</option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                </td>
                                                <td><input type="number" name="{{$item->id}}_amount"
                                                           value="{{old($item->id.'_amount')}}"
                                                           class="form-control fee-amount tbody"></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>{{ __('text.Date') }}</label>
                                    <input type="text" placeholder="" class="form-control" value="{{  \Carbon\Carbon::today()->toDateString() }}" name="month" disabled>
                                </div>

                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>{{ __('text.fine') }}</label>
                                    <input type="number" class="form-control fineInput fine" name="fine" value="0">
                                </div>

                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>{{ __('text.discounts') }}</label>
                                    <select class="select2" id="discount" name="discount" onchange="getDiscount(this)">
                                        <option value="">Please Select</option>
                                        @foreach($discounts as $discount)
                                            <option value="{{ $discount->id }}">{{ $discount->name }} (<small><b>{{ $discount->type }}</b></small>)</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>{{ __('text.discount_group') }} <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" placeholder="" class="form-control discountInput discount" name="discount_amount" value="0" id="discountValue" style="pointer-events: none; touch-action: none;">
                                </div>

                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>{{ __('text.partial_payment') }}</label>
                                    <input type="number" step="0.01" placeholder="" class="form-control partial" value="0">
                                </div>

                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>{{ __('text.payable_amount') }}<span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" placeholder="" class="form-control" name="amount" value="{{ 0 }}" id="amount" style="pointer-events: none; touch-action: none;">
                                    <input type="hidden" name="payable" id="payable" >
                                    <div class="error text-danger"></div>
                                </div>

                                <div class="col-12-xxxl col-lg-12 col-12 form-group">
                                    <label @if($student['studentInfo']['advance_amount'] == 0) style="pointer-events: none; touch-action: none;" @endif>
                                        <input type="checkbox" name="payFromAdv" value="1" onclick="calculateTotal()" id="payFromAdv"> {{ __('text.pay_from_adv') }}
                                    </label>
                                </div>

                                <div class="col-lg-12 col-md-12 form-group">
                                    <label>{{ __('text.pay_method') }}</label>
                                    <label for="cash" class="mr-2">
                                        <input class="ml-5" type="radio" name="mode" value="cash" id="cash" checked> {{ __('text.cash') }}
                                    </label>
                                    <label for="cheque">
                                        <input class="" type="radio" name="mode" id="cheque" value="cheque">{{ __('text.cheque') }}
                                    </label>
                                </div>
                                <div class="col-12-xxxl col-lg-12 col-12 form-group">
                                    <label>{{ __('text.note') }}</label>
                                    <textarea name="note" id="" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <button id="submit-form" class="button button--save float-right mt-4 " style="max-width: 400px !important;">{{ __('text.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('customjs')
    <script>
        window.advanceAmount = {!! json_encode($student['studentInfo']['advance_amount']) !!};
        window.selectedDiscount = 0;
        window.discounts = {!! json_encode($discounts->toArray()) !!};

        jQuery(document).ready(function(){
            $("#checkAll").click(function(){
                $(".tbody").attr('disabled', false);
                $('#fees input:checkbox').not(this).prop('checked', this.checked);

                $('#checkAll').click(function(){
                    if($(this).prop("checked") == true){
                        $(".tbody").attr('disabled', false);
                    }
                    else if($(this).prop("checked") == false){
                        $(".tbody").attr('disabled', true).val('');
                    }
                });
            });
            $(".tbody").attr('disabled', true);

            $('.fee_types').click(function () {
                let chkbox = $(this).closest('tr').find('.fee-amount');
                if($(this).prop("checked") == true){
                    chkbox.attr('disabled', false);
                }
                else if($(this).prop("checked") == false){
                    chkbox.attr('disabled', true).val('');
                }
            });
        });

        $('#submit-form').click(function(e) {
            e.preventDefault();
            let selectedFees = [];
            $('.fee-amount').removeClass('warning');
            $("[id$='_from'], [id$='_to']").removeClass('warning');

            $("input[name='selected_fees[]']").each(function () {
                if($(this).is(":checked")){
                    selectedFees.push($(this).val());
                }
            });

            if (selectedFees.length > 0 ) {
                let counter = 0;
                let feeError = 0;
                let monthError = 0;

                $.each(selectedFees, function (index, value) {
                    let chkbox = $('#ft_'+value).closest('tr').find('.fee-amount');
                    let from_month = $('#'+value+'_from');
                    let to_month = $('#'+value+'_to');
                    let fee_amount =  chkbox.val();

                    if (fee_amount == null || fee_amount == '') {
                        feeError += 1;
                        chkbox.addClass('warning');
                    }

                    if (from_month.length > 0) {
                        if (from_month.val() == null || from_month.val() == '') {
                            monthError += 1;
                            from_month.addClass('warning');
                        }

                    }
                    if (to_month.length > 0) {
                        console.warn('To month: '+to_month.val());
                        if (to_month.val() == null || to_month.val() == '') {
                            monthError += 1;
                            to_month.addClass('warning');
                        }
                    }
                });

                let totalError = feeError + monthError;
                if (totalError > 0) {
                    let msg = feeError > 0 ? 'Fill up all fee amount(s). ' : '';
                    msg += monthError > 0 ? ' Select month(s).' : '';
                    showAlert('Invalid Field', msg);
                } else {
                    $('#fee-transaction').submit();
                }

            } else {
                showAlert('No Item Selected', 'Please select at least one item');
            }

        });

        function showAlert(title = 'No Item Selected', message) {
            swal({
                title: title,
                text: message,
                icon: "warning",
                html: true,
                buttons: true,
                dangerMode: true,
                buttons: {
                    cancel: false,
                    confirm: true,
                },
            })
        }

        $(document).on('click', '.delete-row', function(){
            $(this).closest('tr').remove();
            calculateTotal();
        });

        $(document).on('keyup change', '.fee-amount, .fine, .partial', function(){
            calculateTotal();
        });

        function calculateTotal() {
            let fine = parseFloat($(".fine").val()) || 0;
            let partial = parseFloat($(".partial").val()) || 0;
            let discountAmount =  parseFloat($('#discountValue').val()) || 0;
            let grandTotal = 0;
            let totalFee = 0;

            $("#fees .fee-amount").each(
                function() {
                    let amount =  $(this).val();
                    if (amount != '') { 
                        totalFee = totalFee + parseFloat(amount); 
                    }
                }
            );

            grandTotal = totalFee + fine - ( discountAmount + partial ) ;
            $('#payable').val(grandTotal);
            if ($('#payFromAdv').is(":checked")) {
                console.log('checked');
                if (grandTotal >= advanceAmount) {
                    grandTotal = grandTotal - advanceAmount;
                } else {
                    grandTotal = 0 ;
                }
            }

            $('#amount').val(grandTotal);
        }

        function getDiscount(item) {
            let selectedDiscount = item.value;
            if (selectedDiscount == '' || selectedDiscount == null) {
                $('#discountValue').val(0);
            } else {
                let value;
                discounts.forEach((cls) => {
                    if (cls.id == selectedDiscount) {
                        value = cls.amount;
                    }
                });
                $('#discountValue').val(value);
            }
            calculateTotal();
        }
    </script>
@endpush
