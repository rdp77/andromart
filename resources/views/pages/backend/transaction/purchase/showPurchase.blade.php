@include('layouts.components.header')
<style>
  @media print {
    body{
      -webkit-print-color-adjust: exact !important;
    }
  }
  @media print {
    .table th {
        background-color: #1d98d4 !important;
        color: white !important;
    }
  }
  @media print {
    .table th.thred {
        background-color: red !important;
        color: white !important;
    }
  }

  .invoice-number{
    margin-top: -230px !important;
  }
  .table.table-md td, .table.table-md th {
    padding: 5px !important;
  }
</style>

<div class="invoice">
  <div class="invoice-print">
    <div class="row">
      <div class="col-lg-12">
        <div class="invoice-title">
          <h2>Invoice</h2>
          <h2><img alt="Porto" height="150" src="{{ asset('assetsfrontend/img/andromart.png') }}" style="margin-top: 10px;"></h2>
          <div style="width: 400px">
            <p style="font-size: 15px">{{Auth::user()->employee->branch->address}} <b> Tlp : 0{{Auth::user()->employee->branch->phone}}</b> </p>
          </div>
          <div class="invoice-number"><h3>Job Order :</h3>
            <h1 style="font-size: 50px;color:#eb2390" ></h1>
            <br>
            <p style="font-size: 19px;font-weight:lighter">Daftar Pembelian<br> <b>www.andromartindonesia.com</b>
            </p>
          </div>
        </div>
        <div style="border: 1px solid #1d98d4"></div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-md-12">
        <table class="table table-striped table-hover table-md">
          <thead>
            <tr>
            </tr>
              <th class="text-left" style="font-size: 25px" style="width: 1%;">#</th>
              <th class="text-left" style="font-size: 25px" style="width: 30%;">Item</th>
              <th class="text-right" style="font-size: 25px" style="width: 25%;">Harga Beli</th>
              <th class="text-left" style="font-size: 25px" style="width: 5%;">QTY</th>
              <th class="text-right" style="font-size: 25px" style="width: 25%;">Total</th>
              <th class="text-left" style="font-size: 25px" style="width: 10%;">Cabang</th>
              <th class="text-left" style="width: 4%;"></th>
            </tr>
          </thead>
          <tbody class="dropHereItem" style="border: none !important">
            <?php
              $totalHarga = 0; 
              function rupiah($angka){
                $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
                return $hasil_rupiah;
               
              }
            ?>
            @foreach($models as $key => $value)
            @php 
              $total = $value->price * $value->qty;
              $totalHarga += $total;
            @endphp
            <tr>
              <td style="font-size: 20px">{{ $key+1 }}</td>
              <td style="font-size: 20px">{{ $value->item_name }}</td>
              <td class="text-right" style="font-size: 20px">{{ rupiah($value->price) }}</td>
              <td class="text-right" style="font-size: 20px">{{ $value->qty }}</td>
              <td class="text-right" style="font-size: 20px">{{ rupiah($total) }}</td>
              <td style="font-size: 20px">{{ $value->branch_name }}</td>
              <!-- <td><button type="button" class="btn btn-danger removeDataDetail" value="'+(index+1)+'" >X</button></td> -->
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="row mt-4">
          <div class="col-lg-8 col-md-8 col-sm-8">
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4  text-right">
            <table class="table table-striped table-hover table-md">
              <tbody>
                <tr>
                  <td class="text-right" style="font-size: 20px">Total</td>
                  <td class="text-right" style="font-size: 20px"><b>{{ rupiah($totalHarga) }}</b></td>
                </tr>
                <tr>
                  <td class="text-right" style="font-size: 20px">Diskon</td>
                  <td class="text-right" style="font-size: 20px"><b>{{ rupiah($model->discount) }}</b></td>
                </tr>
                <tr>
                  <td class="text-right" style="font-size: 20px"><b>Grand Total</b></td>
                  <td class="text-right" style="font-size: 20px"><b>{{ rupiah($model->price) }}</b></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div style="border: 1px solid gray"></div>
  </div>
</div>
@section('script')
<script src="{{ asset('assets/pages/transaction/purchaseScript.js') }}"></script>
<script type="text/javascript">
    var arrModels = <?php echo json_encode($models);?>;
    // console.log(arrModels);
    arrModels.forEach(myFunction);
    function myFunction(item, index, arr) {
        var branch_id = 0;
        var item_id = 0;
        var qty = 0;
        var price = 0; 
        Object.entries(arr[index]).forEach(entry2 => {
            var [key2, value2] = entry2;

            if(key2 == 'branch_id') { branch_id = value2 }
            if(key2 == 'item_id') { item_id = value2 }
            if(key2 == 'qty') { qty = value2 }
            if(key2 == 'price') { price = value2 }
        });
        addItems(branch_id, item_id, qty, price);
    }
</script>
<style>
    .modal-backdrop{
        position: relative !important;
    }
</style>
@endsection