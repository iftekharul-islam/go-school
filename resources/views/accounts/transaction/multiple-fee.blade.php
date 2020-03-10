@extends('layouts.student-app')
@section('title', 'Multiple Fee Transaction')
@section('content')
    <style type="text/css">
        .month{display: none}
    </style>
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area example-screen">
            <h3>Multiple Fee Collection</h3>
            <ul>
                <li>
                    <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                        Back &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li>Multiple Fee Collection</li>
            </ul>
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
                    <div class="card height-auto false-height">
                        <div class="card-body">
                            <p>Student: <b>{{ $student['name'] }}</b>, Class: <b>{{ $student->section['class']['class_number'].' ('. $student['section']['section_number'] .')' }}</b> </p>
                            <div class="table-responsive ">
                                <table id="fees" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Fee Name</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($feeTypes) > 0)
                                            @foreach($feeTypes as $ft)
                                            <tr>
                                                <td>
                                                    {{ $ft->name }}
                                                    @if($ft->type == 'monthly')

                                                        <select name="a" class="form-control">
                                                            <option value="">From Month</option>
                                                            <option value="">January</option>
                                                        </select> -
                                                        <select name="b"  class="form-control">
                                                            <option value="">To Month</option>
                                                            <option value="">January</option>
                                                        </select>
                                                    @endif
                                                    <input type="hidden" value="{{$ft->id}}" name="fee_type_id[]">
                                                </td>
                                                <td><input type="number" name="amounts[]" class="form-control fee-amount" required></td>
                                                <td>
                                                    <button type="button"  class="btn btn-danger delete-row" title="Remove this row">
                                                        <i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-secondary float-right" data-toggle="modal" data-target="#addFeeType"><i class="fas fa-plus-circle"></i> </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card height-auto false-height">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>Date</label>
                                    <input type="text" placeholder="" class="form-control" value="{{  \Carbon\Carbon::today()->toDateString() }}" name="month" disabled>
                                </div>

                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>Fine <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control fineInput fine" name="fine" value="0" required>
                                </div>

                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>Discount Group</label>
                                    <select class="select2" id="discount" name="discount" onchange="getDiscount(this)">
                                        <option value="">Please Select</option>
                                        @foreach($discounts as $discount)
                                            <option value="{{ $discount->id }}">{{ $discount->name }} (<small><b>{{ $discount->type }}</b></small>)</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>Discount <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" placeholder="" class="form-control discountInput discount" name="discountAmount" value="0" id="discountValue" style="pointer-events: none; touch-action: none;">
                                </div>

                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>Amount <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" placeholder="" class="form-control" name="amount" value="{{ 0 }}" id="amount" style="pointer-events: none; touch-action: none;">
                                    <div class="error text-danger"></div>
                                </div>

                                <div class="col-6-xxxl col-lg-6 col-6 form-group mt-5">
                                    <label>Payment Method</label>
                                    <label for="cash" class="mr-2">
                                        <input class="ml-5" type="radio" name="mode" value="cash" id="cash" checked> Cash
                                    </label>
                                    <label for="cheque">
                                    <input class="" type="radio" name="mode" id="cheque" value="cheque"> Cheque
                                    </label>
                                </div>
                                <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                    <label>Note</label>
                                    <textarea name="note" id="" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <button  class="button button--save float-right mt-4" style="max-width: 400px !important;">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--Modal-->
    <div class="modal fade" id="addFeeType" role="dialog" aria-labelledby="addFeeType">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add Fee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="feeType" class=" sr-only control-label">Select Fee Type</label>
                            <select name="feeType" class="form-control" id="feeType" onchange="toggleMonthField()" required>
                                <option value="">Select Fee Type</option>
                                @if(count($feeTypes) > 0)
                                    @foreach($feeTypes as $ft)
                                        <option value="{{$ft->id}}">{{$ft->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span id="typeError" class="text-warning"></span>
                        </div>
                        <div class="form-group col-md-6 col-sm-12 month">
                            <label for="fromMonth" class="control-label sr-only">From Month</label>
                            <select name="from_month" class="form-control" id="fromMonth" >
                                <option value="">From Month</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                            <span id="fromMonthError" class="text-warning"></span>
                        </div>
                        <div class="form-group col-md-6 col-sm-12 month">
                            <label for="toMonth" class="control-label sr-only">To Month</label>
                            <select name="to_month" class="form-control" id="toMonth" >
                                <option value="">To Month</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                            <span id="toMonthError" class="text-warning"></span>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="feeAmount" class="control-label sr-only">Amount</label>
                            <input type="number" name="feeAmount" class="form-control" id="feeAmount" placeholder="Amount" required>
                            <span id="amountError" class="text-warning"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group modal-footer pb-">
                    <div class="col-md-12">
                        <button onclick="addFee()" class="button button--save float-right"><i class="fas fa-plus-circle"></i> Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customjs')
    <script>
        window.total = $("#amount").val();
        window.selectedDiscount = 0;
        window.discounts = {!! json_encode($discounts->toArray()) !!};
        window.allFees = {!! json_encode($feeTypes->toArray()) !!};

        $(document).on('click', '.delete-row', function(){
            $(this).closest('tr').remove();
            calculateTotal();
        });
        $(document).on('keyup change', '.fee-amount, .fine', function(){
            calculateTotal();
        });

        function addFee() {
            let fee_name = $('#addFeeType #feeType option:selected').text();
            let fee_type_id = $('#addFeeType #feeType').val();
            let amount = $('#addFeeType #feeAmount').val();
            let month = '';
            let typeOfFee;
            allFees.forEach((fee) => {
                if (fee.id == fee_type_id) {
                    typeOfFee = fee.type;
                }
            });

            if (typeOfFee == 'monthly') {
                month = '('+$('#fromMonth').val()+' To '+$('#toMonth').val()+')';
            }

            if (validateField(fee_type_id, amount)) {
                $('#fees tbody').append('<tr>' +
                    '<td>' + fee_name + month + '<input type="hidden" value="'+fee_type_id+'" name="fee_type_id[]"></td>'+
                    '<td><input type="number" name="amounts[]" value="'+amount+'" class="form-control fee-amount" required></td>' +
                    '<td><button type="button"  class="btn btn-danger delete-row" title="Remove this row"><i class="fas fa-trash"></i></button></td>'+
                    '</tr>');
                $('#addFeeType input').val('');
                $("#addFeeType select option:selected").prop("selected", false);
            }
            calculateTotal();
        }


        function validateField(fee_type_id, amount){
            $('#addFeeType .text-warning').empty();
            let errCounter = 0;
            let addedFees = $("#fees input[name='fee_type_id[]']").map(function(){ return $(this).val() }).get();
            let typeOfFee;

            allFees.forEach((fee) => {
                if (fee.id == fee_type_id) {
                    typeOfFee = fee.type;
                }
            });

            if (amount == '') {
                errCounter += 1;
                $('#amountError').text('Enter Fee Amount');
            }
            if (fee_type_id == null || fee_type_id == undefined || fee_type_id == '') {
                errCounter += 1;
                $('#typeError').text('Select A Type');
            } else if ($.inArray(fee_type_id, addedFees) != -1) {
                errCounter += 1;
                $('#typeError').text('Already Added');
            } else if (typeOfFee == 'monthly') {
                console.log(typeOfFee);
                if ($('#fromMonth').val() == '' || $('#fromMonth').val() == null) {
                    errCounter += 1;
                    $('#fromMonthError').text('Select From Month');
                }
                if ($('#toMonth').val() == '' || $('#toMonth').val() == null) {
                    errCounter += 1;
                    $('#toMonthError').text('Select To Month');
                }
            }

            return  (errCounter > 0) ? false : true;
        }
       
        function calculateTotal() {
            let fine = parseFloat($(".fine").val());
            let discountAmount =  parseFloat($('#discountValue').val());
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
            grandTotal = totalFee + fine - discountAmount;
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

        function toggleMonthField(){
            let fee_type = $('#addFeeType #feeType').val();
            let typeOfFee;

            allFees.forEach((fee) => {
                if (fee.id == fee_type) {
                    typeOfFee = fee.type;
                }
            });

            if (typeOfFee == 'monthly') {
                $('#addFeeType .month').show();
            } else {
                $('#addFeeType .month').hide();
            }
        }
    </script>
@endpush
