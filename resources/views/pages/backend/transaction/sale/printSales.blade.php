@include('layouts.components.header')
{{-- @section('title', __('pages.title').__(' | Nota Besar')) --}}
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
          {{-- <h2>Invoice</h2> --}}
          <h2><img alt="Porto" height="150" src="{{ asset('assetsfrontend/img/andromart.png') }}" style="margin-top: 10px;"></h2>
          <div style="width: 400px">
            <p style="font-size: 15px">{{Auth::user()->employee->branch->address}}, <b> Tlp : 0{{Auth::user()->employee->branch->phone}}</b> </p>
          </div>
          <div class="invoice-number"><h3>Invoice :</h3><h1 style="font-size: 50px;color:#eb2390" >{{$sale->code}}</h1>
            {{-- <br> --}}
            {{-- <p style="font-size: 19px;font-weight:lighter">Lacak Perkembangan Service Kamu di : <br> <b>www.andromartindonesia.com</b> --}}
              {{-- <br> <b> AM care : 0851-5646-2356 --}}
              {{-- <br>Konsultasi Service --}}
            {{-- </p> --}}
          {{-- </b> --}}
          </div>

        </div>
        {{-- <div style="border: 1px solid #1d98d4"></div> --}}

        {{-- <br> --}}
        {{-- <hr> --}}
        <div class="row">
          <div class="col-md-4">
            <address>
              <strong><p style="font-size: 25px" style="background-color:#eb2390;color:white;padding:5px;text-align:center">Sales</p></strong>
              <p style="font-size: 26px">{{$sale->sales->name}}</p>
              {{-- <p style="font-size: 26px">{{$service->employee1->contact}}</p> --}}
            </address>
          </div>
          <div class="col-md-8 text-md-right">
            <address>
              <strong><p style="font-size: 25px" style="background-color:#eb2390;color:white;padding:5px;text-align:center">Customer</p></strong>
              <p style="font-size: 26px"><b>{{$sale->customer_name}}</b></p>
              <p style="font-size: 26px">{{$sale->customer_phone}}</p>
              <p style="font-size: 26px;margin: 10px auto;">{{$sale->customer_address}}</p>
            </address>
          </div>
        </div>
        <div style="border: 1px solid #1d98d4"></div>
        <div class="row">
          <div class="col-md-6">

          <address>
              <br>
              <p><strong><o style="font-size: 30px">Bayar :</strong></o>
                <o style="font-size:30px"> {{ $sale->payment_method }}</o>
                <o style="font-size:30px"> Lunas</o>
              </p>
              {{-- @if ($service->payment_status == null)
                @if ($service->verification_price == 'Y')
                  <o style="font-size:30px"> Perlu Konfirmasi</o>
                @else
                  <o style="font-size:30px"> Belum Bayar</o>
                @endif
              @else
                {{$service->payment_status}}
              @endif</p> --}}
              {{-- <strong><h3 style="color:#28a745"> </h3></strong>s --}}
            </address>
          </div>
          <div class="col-md-6 text-md-right">
            <address>
              <br>
              <strong><p style="font-size: 30px">Tanggal : {{date('d F Y',strtotime($sale->date))}}</p></strong>
            </address>
          </div>
        </div>
      </div>
    </div>
    {{-- <div style="border: 1px solid gray"></div> --}}


    <div class="row mt-4" style="margin-top: 0px !important">
      <div class="col-md-12">
        {{-- <div class="section-title"><h3>Service Detail</h3></div> --}}
        <div>
          <table class="table table-striped table-sm">
            <tbody>
              <tr>
                <th class="text-center" style="font-weight:700;font-size: 25px;padding:0px !important" width="50%">Barang</th>
                <th class="text-center" style="font-size: 25px;padding:0px !important" width="8%">Qty</th>
                <th class="text-center" style="font-size: 25px;padding:0px !important" width="17%">Harga</th>
                <th class="text-center" style="font-size: 25px;padding:0px !important" width="25%">Total Harga</th>
              </tr>
              @foreach ($sale->SaleDetail as $i => $sd)
                <tr>
                    <td style="font-size: 20px; border-right: 1px solid #1d98d4">
                        {{ $sd->item->brand->category->name }} : <b> {{ $sd->item->brand->name }} {{$sd->item->name}} </b>
                    </td>
                    <td style="font-size: 20px; border-right: 1px solid #1d98d4" class="text-center">{{$sd->qty}}</td>
                    <td  class="text-center" style="font-size: 20px" style="border-right: 1px solid #1d98d4">{{ number_format($sd->price,0,".",",") }}</td>
                    <td  class="text-center" style="font-size: 20px">{{ number_format($sd->total,0,".",",") }}</td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
        <div class="row mt-4">
            <div class="col-lg-7 col-md-7 col-sm-7">
              <div class="section-title" style="font-size: 20px"></div>
              <p class="section-lead" style="font-size: 20px"></p>
            </div>
            <div class="col-md-5 col-sm-5  text-center">
              <table class="table table-striped table-sm">
                <tbody>
                  <tr style="border-top: 1px solid #1d98d4" style="border-right: 1px solid #1d98d4" style="border-left: 1px solid #1d98d4" style="border-bottom: 1px solid #1d98d4">
                    <td class="text-left" style="font-size: 20px" style="border-left: 1px solid #1d98d4">&nbsp;Total</td>
                    <td class="text-center" style="font-size: 20px" width="62%"><b> {{ number_format($sale->item_price,0,".",",") }}</b></td>
                  </tr>
                  <tr style="border-right: 1px solid #1d98d4" style="border-bottom: 1px solid #1d98d4">
                    <td class="text-left" style="font-size: 20px" style="border-left: 1px solid #1d98d4">&nbsp;Diskon </td>
                    <td class="text-center" style="font-size: 20px"><b>{{ number_format($sale->discount_price,0,".",",") }}</b></td>
                  </tr>
                  <tr style="border-bottom: 1px solid #1d98d4" style="border-right: 1px solid #1d98d4">
                    <td class="text-left" style="font-size: 20px" style="border-left: 1px solid #1d98d4">&nbsp;<b>Grand Total </b></td>
                    <td class="text-center" style="font-size: 20px"><b> {{ number_format($sale->total_price,0,".",",") }}</b></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        <div class="row">
          <div class="col-md-12">
            <address>
              <strong><p style="font-size: 25px;background-color:#5a5a5a;color:white;padding:5px;text-align:center">PERHATIAN !!</p></strong>
              <p style="font-size: 16px;line-height:17px;font-weight:600">
              1. Pemberian masa garansi mutlak keputusan Andromart.
              <br>
              2. Garansi tidak berlaku apabila unit terjatuh, terkena air, tertindih, dsb.
              <br>
              3. Customer wajib memeriksa dengan seksama, unit & kelengkapan sebelum serah terima unit.
              <br>
              4. Barang yang sudah dibeli tidak dapat dikembalikan kecuali ada perjanjian tertulis.
              </p>
              <strong><p style="font-size: 25px;background-color:#5a5a5a;color:white;padding:5px;text-align:center">!!! Customer Dianggap Telah Membaca dan Menyepakati Ketentuan !!!</p></strong>
            </address>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-9 text-md-right">
            <table class="table table-md" style="border: 1px solid red">
              <tr>
                <th class="text-center thred" colspan="2" style="font-size: 20px"><b> HOT LINE </b></th>
              </tr>
              <tr>
                <td class="text-right" style="font-size: 30px" width="50%"><b> AM CARE : </b></td>
                <td class="text-left" style="font-size: 30px" width="50%"><b> 0851-5646-2356</b></td>
              </tr>
            </table>
          </div>
            <div class="col-md-3 text-md-right">
            <table class="table table-md" style="border: 1px solid #1d98d4">
              <tr>
                <th class="text-center">Customer Service</th>
              </tr>
              <tr>
                <td style="height: 100px"></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  window.print();
</script>
