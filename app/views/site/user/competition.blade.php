@extends('site.layouts.analytics')

{{-- Web site Title --}}
@section('title')
    {{{ Lang::get('user/user.settings') }}} ::
    @parent
@stop

{{-- New Laravel 4 Feature in use --}}
@section('styles')
    @parent
    body {
    background: #f2f2f2;
    }
@stop

{{-- Content --}}
@section('content')
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{{ URL::to('') }}}">Home</a>
                    </li>
                    <li class="active">Competitor Analysis</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <!-- Project One -->
        <div class="row">
            <div class="col-md-7">
                <a href="portfolio-item.html">
				
<iframe src="http://198.176.30.253/SpotfireWeb/ViewAnalysis.aspx?file=/Final_Web_Dashboards/competitor&configurationBlock=SetPage%28pageIndex%3D0%29%3B&options=7-0,8-0,9-0,10-0,11-0,12-0,13-0,14-0,1-0,2-0,3-0,4-0,5-0,6-0,15-0
" width='1200' height= '700' ></iframe>                   
				  </a>
            </div>
            
        </div>
        <!-- /.row -->


        <!-- /.row -->

        <hr>
        <!-- /.row -->

        <hr>

    </div>
@stop
