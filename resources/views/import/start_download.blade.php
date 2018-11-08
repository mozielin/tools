@extends('layouts.main')
@section('content')
	<!-- BEGIN CONTENT HEADER -->
    <div class="row margin-bottom-40 about-header">
        <div class="col-md-12">
            <h1>Start Download!</h1>
            {{ csrf_field() }}
            <h2>If download is not start please click 
            <button type="button" class="btn btn-primary" onclick="location.href='{{route('import_download',[$filepath,$listname])}}'">
                <i class="glyphicon glyphicon-pencil"></i>
                Download
            </button>
        	</h2>
            <button type="button" class="btn btn-danger" onclick="location.href='{{route('home')}}'">Home</button>
        </div>
    </div>
<!-- END CONTENT HEADER -->

@endsection                        