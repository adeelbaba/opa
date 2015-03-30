@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('user/user.register') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

<div class="page-header">
	<h1>Sign Up</h1>
</div>
<form method="POST" action="{{{ URL::to('user') }}}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <fieldset>
        
                <div class="form-group">
                    {{ Form::label('first_name', 'First name', ['class' => 'control-label']) }}
                    <input class="form-control" placeholder="First Name" type="text" name="firstname" id="firstname">
                    
                </div>

<div class="form-group">
                    {{ Form::label('last_name', 'Last name', ['class' => 'control-label']) }}
                    <input class="form-control" placeholder="Last Name" type="text" name="lastname" id="lastname">
                </div>
        
        <div class="form-group">
                    {{ Form::label('organization', 'Organization', ['class' => 'control-label']) }}
                    <input class="form-control" placeholder="Organization" type="text" name="organization" id="organization">
                     
                </div>
        <div class="form-group">
             {{ Form::label('department', 'Department', ['class' => 'control-label']) }}
             {{Form::select('selectdepartment',
                         array(
                                'None' => '- None -', 
                                'Accounting/Finance'=>'Accounting/Finance',
                                'Professional Services'=>'Professional Services',
                                'Engineering/Development'=>'Engineering/Development',
                                'General Mgmt/Administration'=>'General Mgmt/Administration',
                                'Human Resources'=>'Human Resources',
                                'IT'=>'IT',
                                'Legal'=>'Legal',
                                'Market'=>'Marketing',
                                'Operations'=>'Operations',
                                'Channel'=>'Channel',
                                'Product Management'=>'Product Management',
                                'Purchasing/Merchandisingr'=>'Purchasing/Merchandising',
                                'Sales'=>'Sales',
                                'Science'=>'Science',
                                'Support/Service'=>'Support/Service',
                                'Other'=>'Other'
                                ),null,
                        ['class' => 'form-control'])}}
        </div>
        
        
        <div class="form-group">
             {{ Form::label('role', 'Role', ['class' => 'control-label']) }}
             {{Form::select('selectrole',
                         array(
                                'None' => '- None -', 
                                'CEO/President'=>'CEO/President',
                                'C-Level'=>'C-Level',
                                'VP'=>'VP',
                                'Manager'=>'Manager',
                                'Analyst'=>'Analyst',
                                'Coordinator/Specialist'=>'Coordinator/Specialist',
                                'Architect'=>'Architect',
                                'Developer/Engineer'=>'Developer/Engineer',
                                'Consultant/System Integrator'=>'Consultant/System Integrator',
                                'Professor/Teacher'=>'Professor/Teacher',
                                'Student'=>'Student',
                                'Other'=>'Other'
                                ),null,
                        ['class' => 'form-control'])}}
        </div>
        
        
        <div class="form-group">
            <label for="username">{{{ Lang::get('confide::confide.username') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.username') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}">
        </div>
        <div class="form-group">
            <label for="email">{{{ Lang::get('confide::confide.e_mail') }}} <small>{{ Lang::get('confide::confide.signup.confirmation_required') }}</small></label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
        </div>
        <div class="form-group">
            <label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
        </div>

        @if (Session::get('error'))
            <div class="alert alert-error alert-danger">
                @if (is_array(Session::get('error')))
                    {{ head(Session::get('error')) }}
                @endif
            </div>
        @endif

        @if (Session::get('notice'))
            <div class="alert">{{ Session::get('notice') }}</div>
        @endif

        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
        </div>

    </fieldset>
</form>
    
    

@stop
