<style type="text/css">
	.rectangle {
		width: 100%;
		height: 20px;
		background-color: #ed3b9d;
	}
	.trapezoid {
		border-top: 50px solid #ed3b9d;
		border-left: 25px solid transparent;
		border-right: 25px solid transparent;
		height: 0;
		width: 400px;
		/*text-align: center;*/
		/*padding-top: 100px;*/
	}
	.tapeText {
		z-index: 5;
		margin-top: -50px;
	}
</style>
<div class="rectangle"></div>
<center><div class="trapezoid"></div></center>
<center><div class="tapeText"><h3 style="color: white;"><b>{{ $tapeName }}</b></h3></div></center>