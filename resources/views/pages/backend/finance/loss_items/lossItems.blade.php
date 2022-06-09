@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Barang Loss Transaksi'))
@section('titleContent', __('Barang Loss Transaksi'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Barang Loss Transaksi') }}</div>
@endsection

@section('content')
{{-- @include('pages.backend.components.filterSearch') --}}
@include('layouts.backend.components.notification')
<form class="form-data">
    @csrf
    <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-5">
          <h2 class="section-title">Form </h2>
          <div class="card">
                <div class="card-body">
                    <div class="form-group col-12 col-md-12 col-lg-12">
                        <div class="d-block">
                            <label for="serviceId" class="control-label">{{ __('Teknisi') }}<code>*</code></label>
                        </div>
                        <select class="select2 technicianId" name="technicianId">
                        <option value="-">- Select -</option>
                        @foreach ($employee as $element)
                            <option value="{{$element->id}}">{{$element->name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-12 col-lg-12">
                        <label for="startDate">{{ __('Tanggal Awal') }}<code>*</code></label>
                        <input id="startDate" type="text" class="form-control datepicker" name="startDate">
                    </div>
                    <div class="form-group col-12 col-md-12 col-lg-12">
                        <label for="endDate">{{ __('Tanggal Akhir') }}<code>*</code></label>
                        <input id="endDate" type="text" class="form-control datepicker" name="endDate">
                    </div>
                    <div class="form-group col-12 col-md-12 col-lg-12">
                        <label for="endDate">{{ __('Kas') }}<code>*</code></label>
                        <select name="accountMain" class="select2 accountMain" id="" onchange="paymentMethodChange()">
                            <option value="">- Select -</option>
                            @foreach ($accountMain as $el)
                                <option value="{{$el->main_id}}" data-name="{{$el->name}}">{{$el->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-12 col-lg-12">
                        <label for="endDate">{{ __('Kas Data') }}<code>*</code></label>
                        <select name="accountData" class="accountData select2" id="">
                            <option value="">- Select  -</option>
                        </select>
                        {{-- <input id="endDate" type="text" class="form-control datepicker" name="endDate"> --}}
                    </div>
                    @foreach ($accountData as $el)
                    <input class="accountDataHidden" type="hidden"
                    data-mainName="{{$el->AccountMain->name}}"
                    data-mainDetailName="{{$el->AccountMainDetail->name}}"
                    data-branch="{{$el->branch_id}}"
                    data-name="{{$el->name}}"
                    data-code="{{$el->code}}"
                    value="{{$el->id}}">
                @endforeach
                    <div class="form-group col-12 col-md-12 col-lg-12">
                        <button class="btn btn-primary" type="button" onclick="checkEmploye()"><i class="fas fa-eye"></i> Cari</button>
                    </div>
                </div>
            </div>
        </div>
      <div class="col-7">
          <h2 class="section-title">Total Service</h2>
          <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>total</th>
                        <th>Dibayarkan ?</th>
                    </tr>
                </thead>
                <tbody class="dropHere" style="border: none !important">
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">total</td>
                        <td class="dropHereTotal">0</td>
                    </tr>
                </tfoot>
            </table>
            <div class="dropHereTotalVal"></div>
            <button type="button" class="btn btn-primary" onclick="saveSharingProfit()"><i class="fas fa-save"></i> Simpan</button>

        </div>
      </div>
    </div>
  </section>
</form>
@endsection
@section('script')
{{-- <script src="{{ asset('assets/pages/finance/lossItemsScript.js') }}"></script> --}}
<script>
    $.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});




// fungsi update status
function checkEmploye() {
    var technicianId = $('.technicianId').find(':selected').val();
    var dateS = $('#startDate').val();
    var dateE = $('#endDate').val();
    $('.dropHereTotal').text(0);
    $('.dropHereTotalVal').val(0);
    $('.dropHere').empty();
    $.ajax({
        url: "/finance/loss-items/loss-items-load-data-service",
        data: {id:technicianId,dateS:dateS,dateE:dateE},
        type: 'POST',
        success: function(data) {
            if (data.status == 'success'){
                $('.dropHere').empty();
                if(data.message == 'empty'){
                    $('.dropHere').empty();
                    $(".hiddenFormUpdate").css("display", "none");
                }else{
                    if(data.result.work_status == 'Selesai'){
                        $(".hiddenFormUpdate").css("display", "none");
                    }else{
                        $(".hiddenFormUpdate").css("display", "block");
                    }
                    var totalAkhir = 0;
                    $.each(data.result, function(index,value){
                        var totalLoss2 = 0;
                        var totalLoss = 0;
                        if (value.technician_id == technicianId) {
                             totalLoss = value.total_loss_technician_1;
                        }else{
                             totalLoss = value.total_loss_technician_1;
                        }
                        if (value.technician_replacement_id == technicianId) {
                             totalLoss2 = value.total_loss_technician_2;
                        }else{
                             totalLoss2 = value.total_loss_technician_2;
                        }
                        var totalLossTech = totalLoss+totalLoss2;
                        var totalLossALL = totalLossTech+value.total_loss_store;

                        if (value.loss_items_detail.length == 0) {
                            var pay = '<div class="badge badge-danger">Belum Bayar</div>';                            
                            var payDetail = 'Belum Bayar';
                        }else{
                            var pay = '<div class="badge badge-success">Sudah Dibayarkan</div>';                            
                            var payDetail = 'Sudah Dibayarkan';
                        }

                        totalAkhir+=totalLossTech;
                        $('.dropHere').append(
                            '<tr>'+
                                '<td style="display:none">'+
                                    '<input type="text" class="form-control" name="idDetail[]" value="'+value.id+'">'+
                                    '<input type="text" class="form-control" name="totalDetail[]" value="'+totalLossTech+'">'+
                                    '<input type="text" class="form-control" name="totalAll[]" value="'+totalLossALL+'">'+
                                '</td>'+
                                '<td>'+
                                    moment(value.date).format('DD MMMM YYYY')+
                                '</td>'+
                                '<td>'+
                                    value.customer_name+
                                '</td>'+
                                '<td>'+
                                    parseInt(totalLossTech).toLocaleString('en-US')+
                                '</td>'+
                                '<td>'+
                                    pay+
                                '</td>'+
                            '</tr>'
                        );
                    });
                    $('.dropHereTotal').text(parseInt(totalAkhir).toLocaleString('en-US'));
                    $('.dropHereTotalVal').html('<input type="hidden" class="form-control" name="totalValue" value="'+totalAkhir+'">');
                }
            }
        },
        error: function(data) {
        }
    });
}

function saveSharingProfit() {
    swal({
        title: "Apakah Anda Yakin?",
        text: "Aksi ini tidak dapat dikembalikan, dan akan menyimpan data Anda.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willSave) => {
        if (willSave) {
            $.ajax({
                url: "/finance/loss-items/loss-items",
                data: $(".form-data").serialize(),
                type: 'POST',
                success: function(data) {
                    if (data.status == 'success'){
                        swal("Data Telah Tersimpan", {
                            icon: "success",
                        });
                        location.reload();
                    }
                },
                error: function(data) {
                }
            });
        } else {
            swal("Data Dana Kredit PDL Berhasil Dihapus!");
        }
    });
}
function paymentMethodChange() {
    
    var value = $(".accountMain").find(':selected').data('name');
    var dataItems = [];
    $(".accountData").empty();
    var testStr;
    $.each($(".accountDataHidden"), function () {
        testStr = $(this).data("maindetailname");
    // console.log(testStr);
            if (
                testStr.includes(value)
            ) {
                dataItems +=
                    '<option value="' +
                    this.value +
                    '">' +
                    $(this).data("code") +
                    " - " +
                    $(this).data("name") +
                    "</option>";
            }
    });
    // console.log(value);
    // console.log(dataItems);
    $(".accountData").append('<option value="">- Select -</option>');
    // if (value == 'Cash') {
    $(".accountData").append(dataItems);
    // }
    // alert($('.PaymentMethod').val());
}

</script>
@endsection
