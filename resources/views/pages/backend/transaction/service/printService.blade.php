7<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
  <link href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> 
  <style type="text/css">
    /* body{
      font-family: "Times New Roman", Times, serif;
    } */
    .wrapper{
      border: 5px double black;
      width: 900px;
      margin: 10px 10px 10px 10px;
    }
    .bold{
      font-weight: bold;
    }
    .img{
      margin-left: 10px;
      margin-top: 10px;
    }
    .border{
      border:1px solid;
    }
    .header{
      font-size: 23px;
      margin-left: 0px;
      font-family: georgia;
    }
    .full-right{
      margin-bottom: 27px; 
      padding-right:10px; 
      padding-left:10px;
    }
    .bottomheader{
      border-bottom: 1px solid black;
    }
    .kepada{
     border-bottom: 1px solid;
     right:120%;
    }
    .tabel2{
      padding: 10px 10px;
      display: inline-block;
    }
    .jarak1{
      padding: -10px -10px -10px -10px;
    }
    .inlineTable {
      display: inline-block;
    }
    .tabel-utama{
      margin-left: 10px;
      width: 97%;
    }
    .textcenter{
      text-align: center;
    }
    .jarak{
      padding: 10px 10px 10px 10px;
    }
    .textright{
      text-align: right;
      padding-right: 5px;
    }
    .textleft{
      text-indent: 5px;
    }
    .hiddenborderleft{
      border-left:  0px ;
    }
    .hiddenborderright{
      border-right:  0px ;
    }
    .hiddenbordertop{
      border-top:  0px ;
    }
    .hiddenborderbottom{
      border-bottom:  0px ;
    }
    .borderright{
      border-right: 1px solid black;
      padding-right: 10px; 
    }
    .inputheader{
      width: 285px;
      border-bottom: 1px solid black;
    }
    .fontpenting{
      font-size: 11px;
      margin-top: 100px;
      font-family: georgia;
      padding: 3px 3px 3px 3px;
    }
    .ataspenting{
      margin:  20px 0px 2px 10px;
    }
    .tabelpenting{
      margin: 0px 0px 10px 10px;
      border:1px 1px 0px 1px solid black;
      width: 112%;
    }
    .headpenting{
      font-family: georgia;
      padding: 3px 3px 3px 3px;
    }
    .tab{
      margin-left: 30px;
    }
    .boldtandatangan{
      font-weight: bold;
      font-size: 11px;
    }
    .tandatangandiv{
      margin-top: -225px;
      margin-left: 585px;
      margin-bottom: 10px;
    }
    .headtandatangan{
      text-align: center;
      width:  287px;
      padding-bottom: 70px;
    }
    .top{
      border-top: 1px solid black;
    }
    .bot{
      border-bottom: 1px solid black;
    }
    .bottabelutama{
      border-bottom: 1px solid grey;
    }
    .right{
      border-right: 1px solid black;
    }
    .left{
      border-left: 1px solid black;
    }
    .note{
      margin: 0px 10px 10px 10px;
      text-decoration: underline;
    }
    .nomorform{
      margin: -10px 0px 0px 700px;
    }
    .pull-right{
    margin-top: 20px;
    margin-right: 14px;
    padding: 0px 10px 0px 10px;
    }
    .paddingbottom{
      padding-bottom: 60px; 
    }
    .fixed{
      position: absolute;
    }
    .catatanpadding{
      padding-left: 10px;
    }

    .word-wrap{
      word-wrap : break-word;
    }
</style>
<body>
 <div class="wrapper">
  <div class="row">
    <table>
    <td class="logo">
    <div>
        <p><img class="img" width="300" height="180" src="{{ asset('assetsfrontend/img/andromart.png') }}"></p>  
    </div>
    </td>
    <td>
      <p style="font-size: 60px;margin: 0px;font-weight:bold;">NOTA</p>
      <p style="font-size: 40px;margin: 0px;font-weight:bold;">SERVICE</p>
    </td>
    <td>
        <table class="border" style="margin-left: 50px">
            <tbody>
                <tr>
                    <th colspan="2" class="head bold ">CONTACT US</th>
                </tr>
                <tr class="">
                    <td width="50%" colspan="border" class="">(Purchase)</td>
                    <td width="50%" colspan="border" class="">(Man Keu)</td>
                </tr>
                <tr>
                    <td colspan="2" class="border textleft">Tgl :</td>
                </tr>
                <tr>
                    <th colspan="2" class="head bold ">SUPPLIER</th>
                </tr>
                <tr>
                    <td colspan="2" class="border textleft">Tgl :</td>
                </tr>
            </tbody>
        </table>
      </td>
    </table>
  </div>
  <div class="bottomheader">
    
  </div>
     <table class="inlineTable tabel2 table-responsive">
                <tr>
                    <th>Kepada Yth.</th>
                </tr>
                 <tr>
                    <td class="bold">
                    <input type="" name="" readonly="" class="inputheader hiddenborderleft hiddenborderright hiddenbordertop" value="">
                  </td>
                 </tr>
                  <tr>
                    <td class="bold">
                    <input type="" name="" readonly="" class="inputheader hiddenborderleft hiddenborderright hiddenbordertop" value="">
                  </td>
                 </tr>
                  <tr>
                    <td class="bold">
                    <input type="" name="" readonly="" class="inputheader hiddenborderleft hiddenborderright hiddenbordertop" 
                     value="">
                  </td>
                 </tr>
    </table>
    <table class="inlineTable border pull-right pull-right table-responsive">
       <thead>
                <tr>
                  <td style="width: 100px;">Tanggal</td>
                  <td>:</td>
                  <td>&nbsp; </td>
                </tr>
                <tr>
                  <td >No. PO</td>
                  <td>:</td>
                  <td>&nbsp; >
                </tr>
               {{--  <tr>
                  <td >No. SPP</td>
                  <td>:</td>
                  <td>@foreach($data2['spp'] as $spp)
                        &nbsp; - {{$spp->spp_nospp}} <br>
                      @endforeach
                  </td>
                </tr> --}}
       </thead>
    </table>
    <table class="tabel2 table-responsive">
      <td>Dengan ini kami memesan barang-barang / jasa sebagai berikut :  </td>
    </table>
    <div>
    <table border="1" class="tabel-utama table-responsive">
          <thead>
          <tr>
                <th class="textcenter jarak" width="5%">No.</th>
                <th class="textcenter" width="30%">Nama dan Spesifikasi Barang/Jasa</th>
                <th class="textcenter" width="10%">Jumlah</th>
                <th class="textcenter" width="10%">Satuan</th>
                <th class="textcenter" width="10%">SPP</th>
                <th class="textcenter" width="10%">Nopol</th>
                <th class="textcenter" width="10%">Keterangan</th>
                <th class="textcenter" width="15%">Harga Satuan</th>
                <th class="textcenter" width="15%">Jumlah Harga</th>
          </tr>
       </thead>
       <tbody>
        
        <tr>
                <td class="textcenter">&nbsp;</td>
                <td class="textleft"></td>
                <td class="textcenter"></td>
                <td class="textleft"></td>
                <td class="textleft"></td>
                <td class="textright"></td>
                <td class="textright"></td>
                <td class="textright"></td>
                <td class="textright"></td>
               
        </tr>
         <tr>
                <td class="textcenter">&nbsp;</td>
                <td class="textleft"></td>
                <td class="textcenter"></td>
                <td class="textleft"></td>
                <td class="textleft"></td>
                <td class="textright"></td>
                <td class="textright"></td>
                <td class="textright"></td>
                <td class="textright"></td>
               
        </tr>
         <tr>
                <td class="textcenter">&nbsp;</td>
                <td class="textleft"></td>
                <td class="textcenter"></td>
                <td class="textleft"></td>
                <td class="textleft"></td>
                <td class="textleft"></td>
                <td class="textright"></td>
                <td class="textright"></td>
                <td class="textright"></td>
               
        </tr>
         <tr>
                <td class="textcenter">&nbsp;</td>
                <td class="textleft"></td>
                <td class="textcenter"></td>
                <td class="textleft"></td>
                <td class="textleft"></td>
                <td class="textleft"></td>
                <td class="textright"></td>
                <td class="textright"></td>
                <td class="textright"></td>
                
        </tr>
         <tr>
                <td class="textcenter">&nbsp;</td>
                <td class="textleft"></td>
                <td class="textcenter"></td>
                <td class="textleft"></td>
                <td class="textleft"></td>
                <td class="textleft"></td>
                <td class="textright"></td>
                <td class="textright"></td>
                <td class="textright"></td>
               
        </tr>
         <tr>
                <td class="textcenter">&nbsp;</td>
                <td class="textleft"></td>
                <td class="textcenter"></td>
                <td class="textleft"></td>
                <td class="textleft"></td>
                <td class="textleft"></td>
                <td class="textright"></td>
                <td class="textright"></td>
                <td class="textright"></td>
        
               
        </tr>
        <tr>
          <td rowspan="6" colspan="7">
         
          {{--       <td align="left"  rowspan="3" colspan="3"> --}}
                  <div class="word-wrap" align="left" style="padding:5px">   Catatan : div>       
          </td>
          
                      
              <tr>
                <td class="bottabelutama ">Sub Total</td>
                <td class="bottabelutama textright"></td>
              </tr>
              <tr>
                <td class="bottabelutama">Discount</td>
                <td class="bottabelutama textright">0 %</td>
              </tr>
              <tr>
                <td>DPP</td>
                {{-- @if($data->jenis_ppn == 'include10' || $data->jenis_ppn == 'include1') --}}
                  <td class="bottabelutama textright"></td>
                {{-- @elseif($data->jenis_ppn == 'exclude10' || $data->jenis_ppn == 'exclude1')
                  <td class="bottabelutama textright">{{number_format($data->dpp,2,",",".")}}</td>
                @else
                  <td class="bottabelutama textright">{{number_format($data->dpp,2,",",".")}}</td>
                @endif --}}
              </tr>
              <tr>
                <td class="bottabelutama ">P P n 
                {{-- @if($data->jenis_ppn == 'include10' || $data->jenis_ppn == 'include1') --}}
                (Include) data->jenis_ppn == 'exclude10' || $data->jenis_ppn == 'exclude1')
                (Exclude) n)
                {{-- @endif --}}
                </td>
                <td class="bottabelutama textright"></td>
              </tr>
              <tr>
                <td>NETTO</td>
                <td class="textright"></td>
              </tr>
          
          
        </tr>
       </tbody>
    </table>
    <table class="ataspenting" width="60%">
      <tr>
        <td style="width: 200px;">&nbsp;</td>
      {{-- </tr>
        @if($data2['po'][0]->po_tipe != 'J')
        <td style="width: 200px;">Lokasi Gudang </td>
        <td>:</td>
        <td> @foreach($data2['gudang'] as $gudang)
            &nbsp; <b> {{$gudang->mg_namagudang}} </b>
            <tr>
              <td> &nbsp; </td> <td>  </td> <td> &nbsp; {{$gudang->mg_alamat}}</td>
            </tr>
            @endforeach
            @endif
        </td>
      </tr> --}}
      <tr>
        <td style="width: 200px;">Jangka Waktu Pembayaran</td>
        <td>:</td>
        <td>ri TT</td>
      </tr>
      <tr>
        <td style="width: 200px;" valign="top">Lokasi Gudang</td>
        <td valign="top">:</td>
        <td>
          <b>sterGudangPurchase->mg_namagudang}}</b><br>
          sterGudangPurchase->mg_alamat}}
        </td>
      </tr>
      {{-- <tr>
        <td style="width: 200px;">Tanggal Pengiriman</td>
        <td>:</td>
        <td>{{ \Carbon\Carbon::parse($g)->format('d F Y')}} </td>
      </tr> --}}
      {{-- <tr>
        <td style="width: 200px;">No Pol</td>
        <td>:</td>
        <td> @foreach($data['kendaraan'] as $kendaraan) 
                {{$kendaraan->nopol}} <br>
            @endforeach
        </td>
      </tr> --}}
    </table>
    <table>
      <tr>
          <td>
            <table class="tabelpenting top bot left ">
              <tr >
                <th class="headpenting">PENTING :</th>
              </tr>
              <tr>
                <td class="fontpenting">1. <span class="tab">Mohon Mencantumkan No.PO di atas pada Invoice dan Surat Jalan Anda</td>
              </tr>
             <tr>
                <td class="fontpenting">2. <span class="tab">Spesifikasi barang dalam PO ini tidak dapat diganti tanpa pemberitahuan tertulis dari kami</td>
              </tr>
               <tr>
                <td class="fontpenting">3. <span class="tab">Perusahaan kami berhk membatalkan PO ini apabila tidak tepat waktu pengirimannya</td>
              </tr>
              <tr>
                <td class="fontpenting">4. <span class="tab">Semua biaya untuk retur barang yang tidak sesuai dengan PO ini dibebankan kepada Supplier</td>
              </tr>
              <tr>
                <td class="fontpenting">5. <span class="tab">Pengiriman barang harus dilakukan selama jam kerja kami</td>
              </tr>
              <tr>
                <td class="fontpenting">6. <span class="tab">Setelah menerima PO ini mohon ditandatangani dan difaxkan kembali</td>
              </tr>
            </table>
          </td>
        </tr>
    </table>
    <div class="tandatangandiv">
    <table>
      <tr>
            <table class="tandatangan border">
              <tr>
                <th colspan="2" class="headtandatangan boldtandatangan" style="padding-bottom: 0;border-bottom: 1px solid black;">PT JAWA PRATAMA MANDIRI</th>
              </tr>
              <tr style="">
                <td width="50%" colspan="border" style="padding-top: 70px;text-align: center;vertical-align: bottom;">(Purchase)</td>
                <td width="50%" colspan="border" style="text-align: center;vertical-align: bottom;border-left: 1px solid black;">(Man Keu)</td>
              </tr>
              <tr>
                <td colspan="2" class="border textleft">Tgl :</td>
              </tr>
              <tr>
                <th colspan="2" class="headtandatangan boldtandatangan" style="padding-bottom: 70px;">SUPPLIER</th>
              </tr>
               <tr>
                <td colspan="2" class="border textleft">Tgl :</td>
              </tr>
            </table>
        </tr>
    </table>
    </div>
    </div>
 </div>
 <div>
  <div>
    <table class="nomorform" >
      <tr>
        {{-- <td>{{$h}}</td> --}}
      </tr>
    </table>
  </div>
   <table class="note">
     <tr>
       <td class="textleft">Note :</td>
     </tr>
     <tr>
       <td class="textleft">Tandatangan beserta nama terang</td>
     </tr>
     <tr>
       <td class="textleft">Apabila persetujuan supplier melalui telp., dicantumkan nama, tgl, waktu & no.tlp</td>
     </tr>
   </table>
 </div>
</body>
</html>