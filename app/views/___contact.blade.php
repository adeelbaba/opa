@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
{{{ Lang::get('site.contact') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

<html>
<body>
<h1>Contact Us</h1>
<!-- Blade Template engine -->
 {{ Form:: open(array('url' => 'contact_request')) }} <!--contact_request is a router from Route class-->
 
            <ul class="errors">
                @foreach($errors->all('<li>:message</li>') as $message)
                {{ $message }}
                @endforeach
            </ul>
			@if(Session::has('message'))
			<ul class="alert alert-success">
                             {{ Session::get('message') }}
			</ul>
			@endif
 
            {{ Form:: label ('name', 'Name*' )}}
            {{ Form:: text ('name', Input::old('name'), array('placeholder' => 'Full Name', 'class' => 'form-control'))}}
 <br>
            {{ Form:: label ('phone_number', 'Phone Number' )}}
            {{ Form:: text ('phone_number', Input::old('phone_number'), array('placeholder' => 'Phone Number (Only Numbers)', 'class' => 'form-control')) }}
 <br>
            {{ Form:: label ('email', 'E-mail Address*') }}
            {{ Form:: email ('email', Input::old('email'), array('placeholder' => 'Business Email*', 'class' => 'form-control')) }}
 <br>
            {{ Form:: label ('message', 'Message*' )}}
            {{ Form:: textarea ('message', Input::old('message'), array('class' => 'form-control'))}}
 <br>
            {{ Form::reset('Clear', array('class' => 'btn btn-primary')) }}
            {{ Form::submit('Send', array('class' => 'btn btn-success')) }}
 
            {{ Form:: close() }}
</body>
</html>

@stop