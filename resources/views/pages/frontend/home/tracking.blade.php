<div class="card mb-3">
    <div class="card-body">
        <div class="form-group">
            <label>
                {{ __('Masukkan Kode Service :') }}
            </label>
            <input type="text" name="name" id="nameText" class="form-control col-sm-12 filter_name" placeholder="Cari Disini">
        </div>
	</div>
    <div class="card-footer text-right">
        <a href="" id="hrefUrls" class="btn btn-primary mr-1" type="submit" onclick="show()">
        	<i class="far fa-search"></i>{{ __('Simpan Data') }}
        </a>
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