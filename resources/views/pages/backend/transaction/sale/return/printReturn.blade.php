@include('layouts.components.header')
<style>
  @media print {
    body {
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

  .invoice-number {
    margin-top: -230px !important;
  }

  .table.table-md td,
  .table.table-md th {
    padding: 5px !important;
  }
</style>

<div class="invoice">
  <div class="invoice-print">
    <div class="row">
      <div class="col-lg-12">
        <div class="invoice-title">
          <h2><img alt="Porto" height="150" src="{{ asset('assetsfrontend/img/andromart.png') }}"
              style="margin-top: 10px;"></h2>
          <div style="width: 400px">
            <p style="font-size: 15px">{{Auth::user()->employee->branch->address}}, <b> Tlp :
                0{{Auth::user()->employee->branch->phone}}</b> </p>
          </div>
          <div class="invoice-number">
            <h3>Invoice :</h3>
            <h1 style="font-size: 50px;color:#eb2390;">{{ $return->code }}</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <address>
              <strong>
                <p style="font-size: 25px" style="background-color:#eb2390;color:white;padding:5px;text-align:center">
                  Sales</p>
              </strong>
              <p style="font-size: 26px">{{$return->Sale->Sales->name}}</p>
            </address>
          </div>
          <div class="col-md-8 text-md-right">
            <address>
              <strong>
                <p style="font-size: 25px" style="background-color:#eb2390;color:white;padding:5px;text-align:center">
                  Customer
                </p>
              </strong>
              <p style="font-size: 26px"><b>{{$return->Sale->customer_name}}</b></p>
              <p style="font-size: 26px">{{$return->Sale->customer_phone}}</p>
              <p style="font-size: 26px;margin: 10px auto;">{{$return->Sale->customer_address}}</p>
            </address>
          </div>
        </div>
        <div style="border: 1px solid #1d98d4"></div>
        <div class="row">
          <div class="col-md-6">

            <address>
              <br>
              <p><strong>
                  <o style="font-size: 30px">Faktur :
                </strong></o>
                <o style="font-size:30px"> {{ $return->Sale->code }}</o>
              </p>
            </address>
          </div>
          <div class="col-md-6 text-md-right">
            <address>
              <br>
              <strong>
                <p style="font-size: 30px">Tanggal : {{date('d F Y',strtotime($return->created_at))}}</p>
              </strong>
            </address>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-4" style="margin-top: 0px !important">
      <div class="col-md-12">
        <div>
          <table class="table table-striped table-sm">
            <tbody>
              <tr>
                <th class="text-center" style="font-weight:700;font-size: 25px;padding:0px !important" width="50%">
                  Barang</th>
                {{-- <th class="text-center" style="font-size: 25px;padding:0px !important" width="8%">Qty</th> --}}
                <th class="text-center" style="font-size: 25px;padding:0px !important" width="17%">Tipe</th>
                {{-- <th class="text-center" style="font-size: 25px;padding:0px !important" width="25%">Keterangan</th>
                --}}
              </tr>
              @foreach ($return->SaleReturnDetail as $index => $r)
              <tr>
                <td style="border-right: 1px solid #1d98d4" style="font-size: 17px">
                  {{ $r->Item->brand->category->name }} :
                  <b>{{ $r->Item->brand->name }} {{$r->Item->name}} </b>
                </td>
                {{-- <td style="border-right: 1px solid #1d98d4" class="text-center" style="font-size: 17px">
                  {{$r->qty}}
                </td> --}}
                <td class="text-center" style="font-size: 17px" style="border-right: 1px solid #1d98d4">
                  @switch($r->type)
                  @case(1)
                  {{ __('Diservice') }}
                  @break
                  @case(2)
                  {{ __('Diganti Baru') }}
                  @break
                  @case(3)
                  {{ __('Tukar Tambah') }}
                  @break
                  @case(4)
                  {{ __('Diganti Uang') }}
                  @break
                  @case(5)
                  {{ __('Diganti Barang Lain') }}
                  @break
                  @endswitch
                </td>
                {{-- <td class="text-center" style="font-size: 17px">
                  {{ $r->desc }}
                </td> --}}
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
        </div>
        <div class="row">
          <div class="col-md-12">
            <address>
              <strong>
                <p style="font-size: 25px;background-color:#5a5a5a;color:white;padding:5px;text-align:center">PERHATIAN
                  !!</p>
              </strong>
              <p style="font-size: 16px;line-height:17px;font-weight:600">
                1. Pemberian Masa Garansi Mutlak Keputusan Andromart.
                <br>
                2. Garansi Tidak Berlaku Apabila Unit Terjatuh, Terkena Air, Tertindih, dsb.
                <br>
                3. Garansi Tidak Berlaku Jika, Terjadi Kerusakan Lain diluar AWAL Perbaikan / Penggantian Hardware &
                Software.
                <br>
                4. Kami Tidak Bertanggung jawab Atas Kerusakan diluar KELUHAN Customer.
                <br>
                5. Garansi Mulai Berlaku SEJAK tanggal Konfirmasi Selesai.
                <br>
                6. Kami Tidak Bertanggung jawab Atas Perubahan IMEI / NO SERI HP setelah di service
                <br>
                7. Kami Tidak Bertanggung jawab Atas Barang Service yang tidak diambil selama (satu) bulan sejak
                konfirmasi Pengambilan Unit.
                <br>
                8. Kami Tidak Bertanggung jawab Atas Hilangnya Data Atas Pekerjaan Unit Service.
                <br>
                9. Kami Tidak Bertanggung jawab Atas Hilang / Rusaknya Unit yang disebabkan oleh Bencana Alam,
                Kebakaran, Pencurian dll.
                <br>
                10. Customer Wajib memeriksa dengan Seksama, Unit & Kelengkapan sebelum Serah Terima Unit.
                <br>
                11. Nota Service ini Harus Dibawa / Disertakan saat Pengambilan Unit.
              </p>
              <strong>
                <p style="font-size: 25px;background-color:#5a5a5a;color:white;padding:5px;text-align:center">!!!
                  Customer Dianggap Telah Membaca dan Menyepakati Ketentuan !!!</p>
              </strong>
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
  // window.print();
</script>