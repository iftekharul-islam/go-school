@extends('layouts.student-app')
@section('title', 'Multiple Fee Transaction')
@section('content')
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
                                                    <input type="hidden" value="{{$ft->id}}" name="fee_type_id[]">
                                                </td>
                                                <td><input type="number" name="amount[]" class="form-control"></td>
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
                                    <input type="number" step="0.01" placeholder="" class="form-control fineInput fine" name="fine" value="0" required>
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
                                    <input class="ml-5" type="radio" name="mode" value="cash" checked> Cash
                                    <input class="" type="radio" name="mode" value="cheque"> Cheque
                                </div>
                                <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                    <label>Note</label>
                                    <textarea name="note" id="" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <input type="hidden" name="feeMasterId[]" value="" id="feeMasterId">
                            <button class="button button--save float-right mt-4" style="max-width: 400px !important;">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--Modal-->
    <div class="modal fade" id="addFeeType" role="dialog" aria-labelledby="addFeeType">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add Fee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="feeType" class=" sr-only control-label">Select Fee Type</label>
                            <select name="feeType" class="form-control select2" id="feeType" required>
                                <option value="" disabled selected>Select Fee Type</option>
                                @if(count($feeTypes) > 0)
                                    @foreach($feeTypes as $ft)
                                        <option value="{{$ft->id}}">{{$ft->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span id="typeError" class="text-warning"></span>
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
                        <button type="button" onclick="addFee()" class="button button--save float-right"><i class="fas fa-plus-circle"></i> Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customjs')
    <script>
        $(document).on('click', '.delete-row', function(){
            $(this).closest('tr').remove();
        });

        function addFee() {
            let fee_name = $('#addFeeType #feeType option:selected').text();
            let fee_type_id = $('#addFeeType #feeType').val();
            let amount = $('#addFeeType #feeAmount').val();

            if (validateField(fee_type_id, amount)) {
                $('#fees tbody').append('<tr>' +
                    '<td>' +fee_name+'<input type="hidden" value="'+fee_type_id+'" name="fee_type_id[]"></td>'+
                    '<td><input type="number" name="amount[]" value="'+amount+'" class="form-control"></td>' +
                    '<td><button type="button"  class="btn btn-danger delete-row" title="Remove this row"><i class="fas fa-trash"></i></button></td>'+
                    '</tr>');
                $('#addFeeType input').val('');
                $("#addFeeType option:selected").prop("selected", false)
            }
        }

        function validateField(fee_type_id, amount){
            $('#addFeeType .text-warning').empty();
            let errCounter = 0;
            let addedFees = $("#fees input[name='fee_type_id[]']").map(function(){ return $(this).val() }).get();

            if (amount == '') {
                errCounter += 1;
                $('#amountError').text('Enter Fee Amount');
            }

            if ($.inArray(fee_type_id, addedFees) == -1) {
                errCounter += 1;
                $('#typeError').text('Already Added');
            }else if (fee_type_id == ''){
                errCounter += 1;
                $('#typeError').text('Select A Type');
            }

            return  (errCounter > 0) ? false : true;
        }

        window.total = $("#amount").val();
        window.i = 0;
        window.feeMasterId = [];
        window.selectedDiscount = 0;
        window.discounts = {!! json_encode($discounts->toArray()) !!};
        $(document).ready(function(){
            $(".fine").change(function(){
                let grandTotal = 0;
                let fine = $(".fine").val();
                if (fine != '') {
                    grandTotal = parseFloat(total) + parseFloat(fine);
                } else {
                    $(".fine").val(0)
                }
                let value;
                let type;
                discounts.forEach((cls) => {
                    if (cls.id == selectedDiscount) {
                        value = cls.amount;
                        type = cls.type;
                    }
                });
                let dis_tot = feeMasterId.length;
                let dis = $(".discount").val();
                if (type == 'recurrent') {
                    grandTotal = grandTotal - (dis * dis_tot);
                } else {
                    grandTotal = grandTotal - dis ;
                }
                $("#amount").val(grandTotal);
            });
        });

        function calculateTotal(e, t, id) {
            let dis = $(".discount").val();
            if (t.is(':checked')) {
                total = parseFloat($("#amount").val()) + parseFloat(e);
                feeMasterId.push(id);
            } else {
                total = parseFloat($("#amount").val()) - parseFloat(e);
                var idx = feeMasterId.indexOf(id);
                feeMasterId.splice(idx, 1);
            }
            $("#amount").val(total);
            $("#feeMasterId").val(feeMasterId);
        }

        function getDiscount(item) {
            selectedDiscount = item.value;
            console.log("Inner Side", selectedDiscount);
            let value;
            let type;
            discounts.forEach((cls) => {
                if (cls.id == selectedDiscount) {
                    value = cls.amount;
                    type = cls.type;
                }
            });
            $('#discountValue').val(value);
            let grandTotal = 0;
            let fine = $(".fine").val();
            if (fine != '') {
                grandTotal = parseFloat(total) + parseFloat(fine);
            } else {
                $(".fine").val(0)
            }
            let dis = $(".discount").val();
            if (type == 'recurrent') {
                let dis_total = feeMasterId.length;
                grandTotal = grandTotal - (dis * dis_total);
            } else {
                grandTotal = grandTotal - dis ;
            }
            $("#amount").val(grandTotal);
        }

    </script>
@endpush
