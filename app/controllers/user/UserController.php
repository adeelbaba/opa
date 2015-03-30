<?php

class UserController extends BaseController {

    /**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * @var UserRepository
     */
    protected $userRepo;

    /**
     * Inject the models.
     * @param User $user
     * @param UserRepository $userRepo
     */
    public function __construct(User $user, UserRepository $userRepo)
    {
        parent::__construct();
        $this->user = $user;
        $this->userRepo = $userRepo;
    }

    /**
     * Users settings page
     *
     * @return View
     */
    public function getIndex()
    {
        list($user,$redirect) = $this->user->checkAuthAndRedirect('user');
        if($redirect){return $redirect;}

        // Show the page
        return View::make('site/user/index', compact('user'));
    }

    /**
     * Stores new user
     *
     */
    public function postIndex()
    {
        $user = $this->userRepo->signup(Input::all());

        
			
			 $data=array('name' => $user->username,'email'=>$user->email);
        if ($user->id) {
            if (Config::get('confide::signup_email')) {
                
                Mail::send('emails/auth/account_created_email',$data,
    function ($message) use ($user) {
                        $message
                            ->to('fahad.ali@streebo.com', $user->username)
                            ->subject('New Open-Payments Account Created');
            
        });
			/**
            if (Config::get('confide::signup_email')) {
                Mail::queueOn(
                    Config::get('confide::email_queue'),
                    Config::get('confide::email_account_confirmation'),
                    compact('user'),
                    function ($message) use ($user) {
                        $message
                            //->to($user->email, $user->username)
							->to('fahad.ali@streebo.com', $user->username)
                            ->subject(Lang::get('confide::confide.email.account_confirmation.subject'));
                    }
                );
            }
			*/

            return Redirect::to('user/login')
                ->with('success', Lang::get('user/user.user_account_created'));
        } else {
            $error = $user->errors()->all(':message');

            return Redirect::to('user/create')
                ->withInput(Input::except('password'))
                ->with('error', $error);
        }

    }

			}

    /**
     * Edits a user
     * @var User
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(User $user)
    {
        $oldUser = clone $user;

        $user->username = Input::get('username');
        $user->email = Input::get('email');

        $password = Input::get('password');
        $passwordConfirmation = Input::get('password_confirmation');

        if (!empty($password)) {
            if ($password != $passwordConfirmation) {
                // Redirect to the new user page
                $error = Lang::get('admin/users/messages.password_does_not_match');
                return Redirect::to('user')
                    ->with('error', $error);
            } else {
                $user->password = $password;
                $user->password_confirmation = $passwordConfirmation;
            }
        }

        if ($this->userRepo->save($user)) {
            return Redirect::to('user')
                ->with( 'success', Lang::get('user/user.user_account_updated') );
        } else {
            $error = $user->errors()->all(':message');
            return Redirect::to('user')
                ->withInput(Input::except('password', 'password_confirmation'))
                ->with('error', $error);
        }

    }

    /**
     * Displays the form for user creation
     *
     */
    public function getCreate()
    {
        return View::make('site/user/create');
    }


    /**
     * Displays the login form
     *
     */
    public function getLogin()
    {
        $user = Auth::user();
        if(!empty($user->id)){
            return Redirect::to('/');
        }

        return View::make('site/user/login');
    }

    /**
     * Attempt to do login
     *
     */
    public function postLogin()
    {
        $repo = App::make('UserRepository');
        $input = Input::all();

        if ($this->userRepo->login($input)) {
            return Redirect::intended('/user/company');
        } else {
            if ($this->userRepo->isThrottled($input)) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ($this->userRepo->existsButNotConfirmed($input)) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return Redirect::to('user/login')
                ->withInput(Input::except('password'))
                ->with('error', $err_msg);
        }

    }

    /**
     * Attempt to confirm account with code
     *
     * @param  string $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getConfirm($code)
    {
        if ( Confide::confirm( $code ) )
        {
            return Redirect::to('user/login')
                ->with( 'notice', Lang::get('confide::confide.alerts.confirmation') );
        }
        else
        {
            return Redirect::to('user/login')
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_confirmation') );
        }
    }

    /**
     * Displays the forgot password form
     *
     */
    public function getForgot()
    {
        return View::make('site/user/forgot');
    }

    /**
     * Attempt to reset password with given email
     *
     */
    public function postForgotPassword()
    {
        if (Confide::forgotPassword(Input::get('email'))) {
            $notice_msg = Lang::get('confide::confide.alerts.password_forgot');
            return Redirect::to('user/forgot')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
            return Redirect::to('user/login')
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Shows the change password form with the given token
     *
     */
    public function getReset( $token )
    {

        return View::make('site/user/reset')
            ->with('token',$token);
    }


    /**
     * Attempt change password of the user
     *
     */
    public function postReset()
    {

        $input = array(
            'token'                 =>Input::get('token'),
            'password'              =>Input::get('password'),
            'password_confirmation' =>Input::get('password_confirmation'),
        );

        // By passing an array with the token, password and confirmation
        if ($this->userRepo->resetPassword($input)) {
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');
            return Redirect::to('user/login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
            return Redirect::to('user/reset', array('token'=>$input['token']))
                ->withInput()
                ->with('error', $error_msg);
        }

    }

    /**
     * Log the user out of the application.
     *
     */
    public function getLogout()
    {
        Confide::logout();

        return Redirect::to('/');
    }

    /**
     * Get user's profile
     * @param $username
     * @return mixed
     */
    public function getProfile($username)
    {
        $userModel = new User;
        $user = $userModel->getUserByUsername($username);

        // Check if the user exists
        if (is_null($user))
        {
            return App::abort(404);
        }

        return View::make('site/user/profile', compact('user'));
    }

    public function getSettings()
    {
        list($user,$redirect) = User::checkAuthAndRedirect('user/settings');
        if($redirect){return $redirect;}

        return View::make('site/user/profile', compact('user'));
    }

    /**
     * Process a dumb redirect.
     * @param $url1
     * @param $url2
     * @param $url3
     * @return string
     */
    public function processRedirect($url1,$url2,$url3)
    {
        $redirect = '';
        if( ! empty( $url1 ) )
        {
            $redirect = $url1;
            $redirect .= (empty($url2)? '' : '/' . $url2);
            $redirect .= (empty($url3)? '' : '/' . $url3);
        }
        return $redirect;
    }
	
	public function getCompany(){;
		//return 'You are on the Company Page';
        return View::make('site/user/company');

    }

	public function compquery($compquery){

	$flag = $compquery[strlen($compquery)-1];
		
		if( $flag == "1")
		{
			$compquery = substr_replace($compquery, "", -1);
			Session::put('company',$compquery);
			
			$results = DB::table('company')->select('name', 'company_state', 'company_country')->where('name', 'LIKE', '%' . $compquery . '%')->distinct('name')->orderBy('name')->take(100)->remember(60)->get();
			$count = 0;
			if ($results)
			{
				foreach ($results as $result) :
					$data[$count]['name'] = $result->name;
					$data[$count]['state'] = $result->company_state;
					$data[$count]['country'] = $result->company_country;
					$count=$count+1;
				endforeach;
					
				return Response::json($data);
			}
			else
				return Response::json($results);
		}
		else{
			$results = DB::table('company')->select('name')->where('name', 'LIKE', '%' . $compquery . '%')->distinct('name')->orderBy('name')->take(100)->remember(60)->get();
			$count = 0;
			if ($results)
			{
				foreach ($results as $result) :
					$data[$count]['name'] = $result->name;
					$count=$count+1;
				endforeach;
					
				return Response::json($data);
			}
			else
				return Response::json($results);
		}
    }
	
    public function getPhysician(){
        //return 'You are on the Physician Page';
        return View::make('site/user/physician');

    }
	
	public function phyquery($phyquery){

		$flag = $phyquery[strlen($phyquery)-1];
		
		if( $flag == "1")
		{
			$phyquery = substr_replace($phyquery, "", -1);
			Session::put('physician',$phyquery);
			
			$results = DB::table('physician')->select('Full_Name', 'Recipient_City', 'Recipient_State', 'Physician_Specialty')->where('Full_Name', 'LIKE', '%' . $phyquery . '%')->distinct('Full_Name')->orderBy('Full_Name')->take(100)->remember(60)->get();
			$count = 0;
			if ($results)
			{
				foreach ($results as $result) :
					$data[$count]['name'] = $result->Full_Name;
					$data[$count]['spec'] = $result->Physician_Specialty;
					$data[$count]['city'] = $result->Recipient_City;
					$data[$count]['state'] = $result->Recipient_State;
					$count=$count+1;
				endforeach;
					
				return Response::json($data);
			}
			else
				return Response::json($results);
		}
		else{
			$results = DB::table('physician')->select('Full_Name')->where('Full_Name', 'LIKE', '%' . $phyquery . '%')->distinct('Full_Name')->orderBy('Full_Name')->take(100)->remember(60)->get();
			$count = 0;
			if ($results)
			{
				foreach ($results as $result) :
					$data[$count]['name'] = $result->Full_Name;
					$count=$count+1;
				endforeach;
					
				return Response::json($data);
			}
			else
				return Response::json($results);
		}
    }

    public function getSpecialty(){
//        return 'You are on the Specialty Page';
        return View::make('site/user/specialty');

    }
	
	public function specquery($specquery){

	$flag = $specquery[strlen($specquery)-1];
		
		if( $flag == "1")
		{
			$specquery = substr_replace($specquery, "", -1);
			Session::put('specialty',$specquery);
			
			$results = DB::table('specialty_combine')->select('Physician_Specialty_Level_2')->where('Physician_Specialty_Level_2', 'LIKE', '%' . $specquery . '%')->distinct('Physician_Specialty_Level_2')->orderBy('Physician_Specialty_Level_2')->take(100)->remember(60)->get();
			$count = 0;
			if ($results)
			{
				foreach ($results as $result) :
					$data[$count]['name'] = $result->Physician_Specialty_Level_2;
					$count=$count+1;
				endforeach;
					
				return Response::json($data);
			}
			else
				return Response::json($results);
		}
		else{
			$results = DB::table('specialty_combine')->select('Physician_Specialty_Level_2')->where('Physician_Specialty_Level_2', 'LIKE', '%' . $specquery . '%')->distinct('Physician_Specialty_Level_2')->orderBy('Physician_Specialty_Level_2')->take(100)->remember(60)->get();
			$count = 0;
			if ($results)
			{
				foreach ($results as $result) :
					$data[$count]['name'] = $result->Physician_Specialty_Level_2;
					$count=$count+1;
				endforeach;
					
				return Response::json($data);
			}
			else
				return Response::json($results);
		}
    }

    public function getCompetition(){
//        return 'You are on the Competition Page';
        return View::make('site/user/competition');

    }
}
