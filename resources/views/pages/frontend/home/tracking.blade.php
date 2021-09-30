<div class="row">
    <div class="col-4">
        <div class="card mb-3">
            <div class="card-header">
                <label>
                    {{ __('Lacak Service Anda :') }}
                </label>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <input type="text" name="name" id="nameText" class="form-control col-sm-12 filter_name" placeholder="Masukkan Kode Service">
                </div>
        	</div>
            <div class="card-footer text-right">
                <a href="" id="hrefUrls" class="btn btn-primary mr-1" type="submit" onclick="show()">
                	<!-- <i class="far fa-search"></i> -->
                    {{ __('Cari Id Service') }}
                </a>
            </div>
        </div>
    </div>
    <div class="col-8">
        <div class="card mb-3">
            <div class="card-header">
                Hubungi Untuk melakukan service
            </div>
            <div class="card-body">
                <div class="row">
                @foreach($branch as $row)
                <div class="col-lg-3">
                    <h4 class="mt-3 mb-0">Cabang {{ $row->name }}</h4>
                    <ul class="list list-icons mt-3">
                        <li><i class="fas fa-map-marker-alt"></i>{{ $row->address }}</li>
                        @if($row->phone != null)
                        <li>
                            <a href="https://api.whatsapp.com/send?phone=62{{$row->phone}}&text=Hai, Saya ingin service HP/Laptop di Andromart" target="_blank">
                                <i class="fab fa-whatsapp"></i>
                            </a> 0{{ $row->phone }}
                        </li>
                        @endif
                        @if($row->email != null)
                        <li><i class="far fa-envelope"></i> <a href="mailto:{{ $row->email }}">{{ $row->email }}</a></li>
                        @endif
                    </ul>
                </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function show() {
    	var serviceId = document.getElementById("nameText").value;
    	var urls = /trackingService/ + serviceId;
    	console.log(urls);
    	window.open(urls, "_blank");
        // var a = document.getElementById('hrefUrls'); //or grab it by tagname etc
        // a.href = urls;
        // $("#form_id").attr("action", urls);
    }
</script>
