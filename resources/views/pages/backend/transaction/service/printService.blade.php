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
  
  .invoice-number{
    margin-top: -250px !important;
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
            <p style="font-size: 15px">{{Auth::user()->employee->branch->address}} <b>{{Auth::user()->employee->branch->phone}}</b> </p>
          </div>
          <div class="invoice-number"><h3>Job Order :</h3><h1 style="font-size: 50px;color:red" >{{$service->code}}</h1>
            <br>  
            <p style="font-size: 19px;font-weight:lighter">Lacak Perkembangan Service Kamu di : <br> <b>www.andromartindonesia.com</b> </p>
          </div>
          
        </div>
        {{-- <div style="border: 1px solid #1d98d4"></div> --}}

        {{-- <br> --}}
        {{-- <hr> --}}
        <div class="row">
          <div class="col-md-4">
            <address>
              <strong><p style="font-size: 25px" style="background-color:#1d98d4;color:white;padding:5px;text-align:center">Teknisi</p></strong>
              <p style="font-size: 26px">{{$service->employee1->name}}</p>
              {{-- <p style="font-size: 26px">{{$service->employee1->contact}}</p> --}}
            </address>
          </div>
          <div class="col-md-8 text-md-right">
            <address>
              <strong><p style="font-size: 25px" style="background-color:#1d98d4;color:white;padding:5px;text-align:center">Customer</p></strong>
              <p style="font-size: 26px"><b>{{$service->customer_name}}</b></p>
              <p style="font-size: 26px">{{$service->customer_phone}}</p>
              <p style="font-size: 26px;margin: 10px auto;">{{$service->customer_address}}</p>
            </address>
          </div>
        </div>
        <div style="border: 1px solid #1d98d4"></div>
        <div class="row">
          <div class="col-md-6">

          <address>
              <br>
              <p><strong><o style="font-size: 30px">Bayar :</strong></o>
              @if ($service->payment_status == null)
                @if ($service->verification_price == 'Y')
                  <o style="font-size:30px"> Perlu Konfirmasi</o>
                @else
                  <o style="font-size:30px"> Belum Bayar</o>
                @endif
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

    
    <div class="row mt-4" style="margin-top: 0px !important">
      <div class="col-md-12">
        {{-- <div class="section-title"><h3>Service Detail</h3></div> --}}
        <div>
          <table class="table table-sm">
            <tbody>
              <tr>
              </tr>
                <th class="text-center" colspan="2" style="font-weight:700;font-size: 25px;padding:0px !important" width="40%">Service Detail</th>
                <th class="text-center" style="font-size: 25px;padding:0px !important">Keluhan</th>
                <th class="text-center" style="font-size: 25px;padding:0px !important">Kesepakatan Bersama</th>
              </tr>
              <tr>
                <td style="font-size: 17px">{{$service->Brand->Category->name}}</td>
                <td style="border-right: 1px solid #1d98d4" style="font-size: 17px">{{$service->Brand->name}} {{$service->Type->name}}  </td>
                <td style="border-right: 1px solid #1d98d4" class="text-center" rowspan="4" style="font-size: 17px">{{$service->complaint}}</td>
                <td  class="text-center" rowspan="4" style="font-size: 17px">{{$service->description}}</td>
              </tr>
              {{-- <tr>
                <td style="font-size: 20px">Merk</td>
                <td style="border-right: 1px solid #1d98d4" style="font-size: 20px">{{$service->Brand->name}}</td>
              </tr>
              <tr>
                <td style="font-size: 20px">Series</td>
                <td style="border-right: 1px solid #1d98d4" style="font-size: 20px">{{$service->Type->name}}</td>
              </tr>
              <tr>
                <td  style="font-size: 20px">Estimasi Analisa</td>
                <td style="border-right: 1px solid #1d98d4" style="font-size: 20px">{{$service->estimate_day}}</td>
              </tr> --}}
            </tbody>
          </table>
        </div>
        {{-- <div style="border: 1px solid gray"></div> --}}
        <div class="row mt-4" style="margin-top: 0px !important">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <table class="table table-sm">
              <tbody>
                <tr>
                </tr >
                  <th class="text-center" colspan="8" style="font-size: 25px;padding:0px !important">Kondisi Serah Terima Unit</th>
                </tr>
                <tr >
                    <td style="font-size: 18px">{{$service->ServiceCondition[0]->name}}</td>
                    @if ($service->ServiceCondition[0]->status == 'N')
                    <td><i class="fa fa-times"></i></td>
                    @elseif ($service->ServiceCondition[0]->status == 'Y')
                      <td><i class="fa fa-check"></i></td>
                    @elseif ($service->ServiceCondition[0]->status == '?')
                      <td><i class="fa fa-question"></i></td>
                    @endif
                    <td style="font-size: 18px">{{$service->ServiceCondition[1]->name}}</td>
                    @if ($service->ServiceCondition[1]->status == 'N')
                    <td><i class="fa fa-times"></i></td>
                    @elseif ($service->ServiceCondition[1]->status == 'Y')
                      <td><i class="fa fa-check"></i></td>
                    @elseif ($service->ServiceCondition[1]->status == '?')
                      <td><i class="fa fa-question"></i></td>
                    @endif
                  <td style="font-size: 18px">{{$service->ServiceCondition[2]->name}}</td>
                  @if ($service->ServiceCondition[2]->status == 'N')
                  <td><i class="fa fa-times"></i></td>
                  @elseif ($service->ServiceCondition[2]->status == 'Y')
                    <td><i class="fa fa-check"></i></td>
                  @elseif ($service->ServiceCondition[2]->status == '?')
                    <td><i class="fa fa-question"></i></td>
                  @endif
                  <td style="font-size: 18px">{{$service->ServiceCondition[3]->name}}</td>
                  @if ($service->ServiceCondition[3]->status == 'N')
                  <td ><i class="fa fa-times"></i></td>
                  @elseif ($service->ServiceCondition[3]->status == 'Y')
                    <td ><i class="fa fa-check"></i></td>
                  @elseif ($service->ServiceCondition[3]->status == '?')
                    <td ><i class="fa fa-question"></i></td>
                  @endif
                </tr>
                <tr >
                  <td style="font-size: 18px">{{$service->ServiceCondition[4]->name}}</td>
                  @if ($service->ServiceCondition[4]->status == 'N')
                  <td><i class="fa fa-times"></i></td>
                  @elseif ($service->ServiceCondition[4]->status == 'Y')
                    <td><i class="fa fa-check"></i></td>
                  @elseif ($service->ServiceCondition[4]->status == '?')
                    <td><i class="fa fa-question"></i></td>
                  @endif
                  <td style="font-size: 18px">{{$service->ServiceCondition[5]->name}}</td>
                  @if ($service->ServiceCondition[5]->status == 'N')
                  <td><i class="fa fa-times"></i></td>
                  @elseif ($service->ServiceCondition[5]->status == 'Y')
                    <td><i class="fa fa-check"></i></td>
                  @elseif ($service->ServiceCondition[5]->status == '?')
                    <td><i class="fa fa-question"></i></td>
                  @endif
                  <td style="font-size: 18px">{{$service->ServiceCondition[6]->name}}</td>
                  @if ($service->ServiceCondition[6]->status == 'N')
                  <td><i class="fa fa-times"></i></td>
                  @elseif ($service->ServiceCondition[6]->status == 'Y')
                    <td><i class="fa fa-check"></i></td>
                  @elseif ($service->ServiceCondition[6]->status == '?')
                    <td><i class="fa fa-question"></i></td>
                  @endif
                  <td style="font-size: 18px">{{$service->ServiceCondition[7]->name}}</td>
                  @if ($service->ServiceCondition[7]->status == 'N')
                  <td><i class="fa fa-times"></i></td>
                  @elseif ($service->ServiceCondition[7]->status == 'Y')
                    <td><i class="fa fa-check"></i></td>
                  @elseif ($service->ServiceCondition[7]->status == '?')
                    <td><i class="fa fa-question"></i></td>
                  @endif
                </tr>
                <tr>
                  <td style="font-size: 18px">{{$service->ServiceCondition[8]->name}}</td>
                  @if ($service->ServiceCondition[8]->status == 'N')
                  <td><i class="fa fa-times"></i></td>
                  @elseif ($service->ServiceCondition[8]->status == 'Y')
                    <td><i class="fa fa-check"></i></td>
                  @elseif ($service->ServiceCondition[8]->status == '?')
                    <td><i class="fa fa-question"></i></td>
                  @endif
                  <td style="font-size: 18px">{{$service->ServiceCondition[9]->name}}</td>
                  @if ($service->ServiceCondition[9]->status == 'N')
                  <td><i class="fa fa-times"></i></td>
                  @elseif ($service->ServiceCondition[9]->status == 'Y')
                    <td><i class="fa fa-check"></i></td>
                  @elseif ($service->ServiceCondition[9]->status == '?')
                    <td><i class="fa fa-question"></i></td>
                  @endif
                  <td style="font-size: 18px">{{$service->ServiceCondition[10]->name}}</td>
                  @if ($service->ServiceCondition[10]->status == 'N')
                  <td><i class="fa fa-times"></i></td>
                  @elseif ($service->ServiceCondition[10]->status == 'Y')
                    <td><i class="fa fa-check"></i></td>
                  @elseif ($service->ServiceCondition[10]->status == '?')
                    <td><i class="fa fa-question"></i></td>
                  @endif
                  <td style="font-size: 18px">{{$service->ServiceCondition[11]->name}}</td>
                  @if ($service->ServiceCondition[11]->status == 'N')
                  <td><i class="fa fa-times"></i></td>
                  @elseif ($service->ServiceCondition[11]->status == 'Y')
                    <td><i class="fa fa-check"></i></td>
                  @elseif ($service->ServiceCondition[11]->status == '?')
                    <td><i class="fa fa-question"></i></td>
                  @endif
                </tr>
                <tr>
                  <td style="font-size: 18px">{{$service->ServiceCondition[12]->name}}</td>
                  @if ($service->ServiceCondition[12]->status == 'N')
                  <td ><i class="fa fa-times"></i></td>
                  @elseif ($service->ServiceCondition[12]->status == 'Y')
                    <td ><i class="fa fa-check"></i></td>
                  @elseif ($service->ServiceCondition[12]->status == '?')
                    <td ><i class="fa fa-question"></i></td>
                  @endif
                  <td style="font-size: 18px">{{$service->ServiceCondition[13]->name}}</td>
                  @if ($service->ServiceCondition[13]->status == 'N')
                  <td><i class="fa fa-times"></i></td>
                  @elseif ($service->ServiceCondition[13]->status == 'Y')
                    <td><i class="fa fa-check"></i></td>
                  @elseif ($service->ServiceCondition[13]->status == '?')
                    <td><i class="fa fa-question"></i></td>
                  @endif
                  <td style="font-size: 18px">{{$service->ServiceCondition[14]->name}}</td>
                  @if ($service->ServiceCondition[14]->status == 'N')
                  <td><i class="fa fa-times"></i></td>
                  @elseif ($service->ServiceCondition[14]->status == 'Y')
                    <td><i class="fa fa-check"></i></td>
                  @elseif ($service->ServiceCondition[14]->status == '?')
                    <td><i class="fa fa-question"></i></td>
                  @endif
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12" 
          {{-- style="border-left: 2px solid gray"  --}}
          >
            <table class="table table-sm">
              <tbody>
                <tr>
                </tr>
                  <th class="text-center" colspan="8" style="font-size: 25px;padding:0px !important">Kelengkapan & Unit</th>
                </tr>
                <tr>
                  @foreach ($service->ServiceEquipment as $i => $el)
                  @if ($i <= 4)
                    @if ($el->status == 'Y')
                        <td width="25%" style="font-size: 18px"><b>{{$el->name}}</b>  
                        <br>{{$el->description}}
                        </td>
                    @endif
                  @endif
                  @endforeach
                </tr>
                <tr>
                  @foreach ($service->ServiceEquipment as $i => $el)
                  @if ($i > 4)
                    @if ($el->status == 'Y')
                        <td width="25%" style="font-size: 18px"><b>{{$el->name}}</b>  
                        <br>{{$el->description}}
                        </td>
                    @endif
                  @endif
                  @endforeach
                </tr>
            </tbody>
            </table>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <address>
              <strong><p style="font-size: 25px;background-color:red;color:white;padding:5px;text-align:center">PERHATIAN</p></strong>
              <p style="font-size: 16px;line-height:17px;font-weight:600">
              1. Pemberian Masa Garansi Mutlak Keputusan Andromart.
              <br>
              2. Garansi Tidak Berlaku Apabila Unit Terjatuh, Terkena Air, Tertindih, dsb.
              <br>
              3. Garansi Tidak Berlaku Jika, Terjadi Kerusakan Lain diluar AWAL Perbaikan / Penggantian Hardware & Software.
              <br>
              4. Kami Tidak Bertanggung jawab Atas Kerusakan diluar KELUHAN Customer.
              <br>
              5. Garansi Mulai Berlaku SEJAK tanggal Konfirmasi Selesai.
              <br>
              6. Kami Tidak Bertanggung jawab Atas Perubahan IMEI / NO SERI HP setelah di service
              <br>
              7. Kami Tidak Bertanggung jawab Atas Barang Service yang tidak diambil selama (satu) bulan sejak konfirmasi Pengambilan Unit.
              <br>
              8. Kami Tidak Bertanggung jawab Atas Hilangnya Data Atas Pekerjaan Unit Service.
              <br>
              9. Kami Tidak Bertanggung jawab Atas Hilang / Rusaknya Unit yang disebabkan oleh Bencana Alam, Kebakaran, Pencurian dll.
              <br>
              10. Customer Wajib memeriksa dengan Seksama, Unit & Kelengkapan sebelum Serah Terima Unit.
              <br>
              11. Nota Service ini Harus Dibawa / Disertakan saat Pengambilan Unit.
              </p>
              <strong><p style="font-size: 25px;background-color:red;color:white;padding:5px;text-align:center">!!! Customer Dianggap Telah Membaca dan Menyepakati Ketentuan !!!</p></strong>
            </address>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-8 text-md-right">
          </div>
            <div class="col-md-4 text-md-right">
            <table class="table table-md" style="border: 1px solid #1d98d4">
              <tr>
                <th class="text-center">Customer Service</th>
              </tr>
              <tr>
                <td style="height: 100px"></td>
              </tr>
            </table>
            {{-- <address>
              <strong><p style="font-size: 25px">Customer Service</p></strong>
            </address> --}}
          </div>
        </div>
        {{-- <div>
          <table class="table table-striped  table-md">
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
            <table class="table table-striped  table-md">
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