@extends('layouts.main')
@section('content')
	<!-- BEGIN CONTENT HEADER -->
    <div class="row margin-bottom-40 about-header">
        <div class="col-md-12">
            <h1>Start Download!</h1>
            {{ csrf_field() }}
            <div id="tx">
            <h2>If download is not start please click 
            <button type="button" class="btn btn-primary" id="ck" onclick="location.href='{{route('import_download',[$filepath,$listname])}}'">
                <i class="glyphicon glyphicon-pencil"></i>
                Download
            </button>
        	</h2>
        </div>
            <button type="button" class="btn btn-danger" onclick="location.href='{{route('home')}}'">Home</button>
        </div>
    </div>
<!-- END CONTENT HEADER -->

<script type="text/javascript">
    window.onload = function(){
        document.getElementById('ck').click();
        document.getElementById('ck').style.display = 'none';
        document.getElementById('tx').style.display = 'none';
    }
</script>

@endsection                        