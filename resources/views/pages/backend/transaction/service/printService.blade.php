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
          <h2><img alt="Porto" height="150" src="{{ asset('assetsfrontend/img/andromart.png') }}" style="margin-top: 10px;"></h2>
          <div class="invoice-number"><h3>Job Order :</h3><h1 style="font-size: 50px">{{$service->code}}</h1></div>
        </div>
        <br>
        <br>
        {{-- <hr> --}}
        <div class="row">
          <div class="col-md-6">
            <address>
              <strong><p style="font-size: 38px">Teknisi</p></strong>
              <p style="font-size: 30px">{{$service->employee1->name}}</p>
              <p style="font-size: 30px">{{$service->employee1->contact}}</p>
            </address>
          </div>
          <div class="col-md-6 text-md-right">
            <address>
              <strong><p style="font-size: 38px">Customer</p></strong>
              <p style="font-size: 30px">{{$service->customer_name}}</p>
              <p style="font-size: 30px">{{$service->customer_phone}}</p>
              <p style="font-size: 30px;margin: 10px auto;">{{$service->customer_address}}</p>
            </address>
          </div>
        </div>
        <div style="border: 1px solid gray"></div>
        <div class="row">
          <div class="col-md-6">

          <address>
              <br>
              <p><strong><o style="font-size: 36px">Bayar :</strong></o>  @if ($service->payment_status == null)
                <o style="font-size: 36px"> Belum Bayar</o>
                @else
                {{$service->payment_status}}
              @endif</p>
              {{-- <strong><h3 style="color:#28a745"> </h3></strong>s --}}
            </address>
          </div>
          <div class="col-md-6 text-md-right">
            <address>
              <br>
              <strong><p style="font-size: 30px">Tanggal : {{date('d F Y',strtotime($service->date))}}</p></strong>
            </address>
          </div>
        </div>
      </div>
    </div>
    <div style="border: 1px solid gray"></div>

    
    <div class="row mt-4">
      <div class="col-md-12">
        {{-- <div class="section-title"><h3>Service Detail</h3></div> --}}
        <div>
          <table class="table table-striped table-hover table-md">
            <tbody>
              <tr>
              </tr>
                <th class="text-left" colspan="2" style="font-size: 25px" width="40%">Service Detail</th>
                <th class="text-left" style="font-size: 25px">Keluhan</th>
                <th class="text-left" style="font-size: 25px">Keterangan</th>
              </tr>
              <tr>
                <td style="font-size: 20px">Tipe</td>
                <td style="font-size: 20px">{{$service->Brand->Category->name}}</td>
                <td rowspan="3" style="font-size: 20px">{{$service->complaint}}</td>
                <td rowspan="3" style="font-size: 20px">{{$service->description}}</td>
              </tr>
              <tr>
                <td style="font-size: 20px">Merk</td>
                <td style="font-size: 20px">{{$service->Brand->name}}</td>
              </tr>
              <tr>
                <td style="font-size: 20px">Series</td>
                <td style="font-size: 20px">{{$service->Type->name}}</td>
              </tr>
              <tr>
                <td style="font-size: 20px">Estimasi Analisa</td>
                <td style="font-size: 20px">{{$service->estimate_day}}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div style="border: 1px solid gray"></div>
        <div class="row mt-4">
          <div class="col-lg-6 col-md-6 col-sm-6">
            <table class="table table-striped table-hover table-md">
              <tbody>
                <tr>
                </tr>
                  <th class="text-left" colspan="2" style="font-size: 25px">Kondisi</th>
                </tr>
                @foreach ($service->ServiceCondition as $el)
                    <tr>
                      <th>{{$el->name}}</th>
                      @if ($el->status == 'N')
                        <td><i class="fa fa-times"></i></td>
                      @elseif ($el->status == 'Y')
                        <td><i class="fa fa-check"></i></td>
                      @elseif ($el->status == '?')
                        <td><i class="fa fa-question"></i></td>
                      @endif
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6" style="border-left: 2px solid gray">
            <table class="table table-striped table-hover table-md">
              <tbody>
                <tr>
                </tr>
                  <th class="text-left" colspan="2" style="font-size: 25px">Kelengkapan</th>
                </tr>
                @foreach ($service->ServiceEquipment as $el)
                  @if ($el->description != null)
                    <tr>
                      <td><b>{{$el->name}}</b>  
                      <br>
                      Catatan : {{$el->description}}
                      </td>
                      @if ($el->status == 'N')
                        <td><i class="fa fa-times"></i></td>
                      @elseif ($el->status == 'Y')
                        <td><i class="fa fa-check"></i></td>
                      @endif 
                    </tr>
                  @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        
        {{-- <div>
          <table class="table table-striped table-hover table-md">
            <tbody><tr>
              <th data-width="40" style="width: 40px;" style="font-size: 25px">#</th>
              <th style="font-size: 25px">Item</th>
              <th class="text-center" style="font-size: 25px">Harga</th>
              <th class="text-center" style="font-size: 25px">Qty</th>
              <th class="text-right" style="font-size: 25px">total</th>
            </tr>
            @foreach ($service->ServiceDetail as $i => $el)
              <tr>
                <td style="font-size: 20px">{{$i+1}}</td>
                <td style="font-size: 20px">{{$el->Items->name}}</td>
                <td style="font-size: 20px" class="text-center">{{$el->price}}</td>
                <td style="font-size: 20px" class="text-center">{{$el->qty}}</td>
                <td style="font-size: 20px" class="text-right">{{$el->total_price}}</td>
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
                <tr>
                  <td class="text-right" style="font-size: 20px">Jasa</td>
                  <td class="text-right" style="font-size: 20px"><b>{{$service->total_service}}</b></td>
                </tr>
                <tr>
                  <td class="text-right" style="font-size: 20px">Spare Part</td>
                  <td class="text-right" style="font-size: 20px"><b>{{$service->total_part}}</b></td>
                </tr>
                <tr>
                  <td class="text-right" style="font-size: 20px">Discount</td>
                  <td class="text-right" style="font-size: 20px"><b>{{$service->discount_price}}</b></td>
                </tr>
                <tr>
                  <td class="text-right" style="font-size: 20px">Total Service</td>
                  <td class="text-right" style="font-size: 20px"><b>{{$service->total_price}}</b></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div> --}}
      </div>
    </div>
  </div>
</div>