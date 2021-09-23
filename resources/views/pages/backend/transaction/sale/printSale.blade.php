@include('layouts.components.header')
<style>
  body{
    -webkit-print-color-adjust: exact !important;
  }
  .invoice-number{
    margin-top: -120px !important;
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
          {{-- <h2>Invoice</h2> --}}
          <h2><img alt="Porto" height="120" src="{{ asset('assetsfrontend/img/andromart.png') }}" style="margin-top: 10px;"></h2>
          <div class="invoice-number"><h3>INVOICE </h3><h1 style="font-size: 40px">{{$sale->code}}</h1></div>
        </div>
        <br>
        <br>
        {{-- <hr> --}}
        <div class="row">
          <div class="col-md-6">
            <address>
              <strong><p style="font-size: 30px">Operator / Sales</p></strong>
              <p style="font-size: 25px">{{$sale->sales->name}}</p>
              <p style="font-size: 25px">0{{$sale->sales->contact}}</p>
            </address>
          </div>
          <div class="col-md-6 text-md-right">
            <address>
              <strong><p style="font-size: 30px">Customer</p></strong>
              <p style="font-size: 25px">{{$sale->customer_name}}</p>
              <p style="font-size: 25px">{{$sale->customer_phone}}</p>
              <p style="font-size: 25px">{{$sale->customer_address}}</p>
            </address>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <address>
              <br>
              <strong><h2>Status Pembayaran</h2></strong>
              <strong><h3 style="color:#28a745">Lunas </h3></strong>
            </address>
          </div>
          <div class="col-md-6 text-md-right">
            <address>
              <br>
              <strong><h3>Tanggal</h3></strong>
              <p style="font-size: 20px">{{ \Carbon\Carbon::parse($sale->date)->locale('id')->isoFormat('LL') }}</p>
            </address>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-12">
        {{-- <div class="section-title"><h3>sale Detail</h3></div> --}}
        {{-- <div>
          <table class="table table-striped table-hover table-md">
            <tbody>
              <tr>
              </tr>
                <th class="text-left" colspan="2" style="font-size: 25px">Detil Pembelian</th>
                <th class="text-left" style="font-size: 25px">Keluhan</th>
                <th class="text-left" style="font-size: 25px">Keterangan</th>
              </tr>
              <tr>
                <td style="font-size: 20px">Tipe</td>
                <td style="font-size: 20px">{{$sale->Brand->Category->name}}</td>
                <td rowspan="3" style="font-size: 20px">{{$sale->complaint}}</td>
                <td rowspan="3" style="font-size: 20px">{{$sale->description}}</td>
              </tr>
              <tr>
                <td style="font-size: 20px">Merk</td>
                <td style="font-size: 20px">{{$sale->Brand->name}}</td>
              </tr>
              <tr>
                <td style="font-size: 20px">Series</td>
                <td style="font-size: 20px">{{$sale->Type->name}}</td>
              </tr>
            </tbody>
          </table>
        </div> --}}
        <div>
          <table class="table table-striped table-hover table-md">
            <tbody><tr>
              <th data-width="40" style="width: 50px;" style="font-size: 25px">#</th>
              <th style="font-size: 25px">Merk</th>
              <th style="font-size: 25px">Item</th>
              <th class="text-center" style="font-size: 25px">Harga</th>
              <th class="text-center" style="font-size: 25px">Qty</th>
              <th class="text-right" style="font-size: 25px">Jumlah</th>
            </tr>
            @foreach ($sale->saleDetail as $i => $el)
              <tr>
                <td style="font-size: 20px">{{$i+1}}</td>
                <td style="font-size: 20px">{{$el->Item->Brand->name}}</td>
                <td style="font-size: 20px">{{$el->Item->name}}</td>
                <td style="font-size: 20px" class="text-center">{{$el->price}}</td>
                <td style="font-size: 20px" class="text-center">{{$el->qty}}</td>
                <td style="font-size: 20px" class="text-right">{{$el->total}}</td>
              </tr>
            @endforeach
          </tbody></table>
        </div>
        <div class="row mt-4">
          <div class="col-lg-8 col-md-8 col-sm-8">
            <div class="section-title" style="font-size: 20px">Payment Method</div>
            <p class="section-lead" style="font-size: 20px">The payment method that we provide is to make it easier for you to pay invoices.</p>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4  text-right">
            <table class="table table-striped table-hover table-md">
              <tbody>
                {{-- <tr>
                  <td class="text-right" style="font-size: 20px">Jasa</td>
                  <td class="text-right" style="font-size: 20px"><b>{{$sale->total_sale}}</b></td>
                </tr> --}}
                <tr>
                  <td class="text-right" style="font-size: 20px">Total</td>
                  <td class="text-right" style="font-size: 20px"><b>{{$sale->item_price}}</b></td>
                </tr>
                <tr>
                  <td class="text-right" style="font-size: 20px">Diskon</td>
                  <td class="text-right" style="font-size: 20px"><b>{{$sale->discount_price}}</b></td>
                </tr>
                <tr>
                  <td class="text-right" style="font-size: 20px"><b>Grand Total</b></td>
                  <td class="text-right" style="font-size: 20px"><b>{{$sale->total_price}}</b></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
