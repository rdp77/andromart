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
                        {{-- <th>Dibayarkan ?</th> --}}
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
                        if (value.technician_id == technicianId) {
                            var totalProfit = value.sharing_profit_technician_1;
                        }else{
                            var totalProfit = value.sharing_profit_technician_2;
                        }

                        totalAkhir+=totalProfit;
                        $('.dropHere').append(
                            '<tr>'+
                                '<td style="display:none">'+
                                    '<input type="text" class="form-control" name="idDetail[]" value="'+value.id+'">'+
                                    '<input type="text" class="form-control" name="totalDetail[]" value="'+totalProfit+'">'+
                                '</td>'+
                                '<td>'+
                                    moment(value.date).format('DD MMMM YYYY')+
                                '</td>'+
                                '<td>'+
                                    value.customer_name+
                                '</td>'+
                                '<td>'+
                                    parseInt(totalProfit).toLocaleString('en-US')+
                                '</td>'+
                                // '<td>'+
                                //     pay+
                                // '</td>'+
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

</script>
@endsection
