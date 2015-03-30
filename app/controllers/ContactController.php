<?php
class ContactController extends BaseController {
 
//Server Contact view:: we will create view in next step
 public function getContact(){
 
            return View::make('contact');
        }
 
        //Contact Form
        public function getContactUsForm(){
 
            //Get all the data and store it inside Store Variable
            $data = Input::all();
 
            //Validation rules
            $rules = array (
                'name' => 'required|alpha',
                'phone_number'=>'numeric|min:8',
                'email' => 'required|email',
                'message' => 'required|min:25'
            );
 
            //Validate data
            $validator  = Validator::make ($data, $rules);
 
            //If everything is correct than run passes.
            if ($validator -> passes()){
 
                //Send email using Laravel send function
                Mail::send('emails.hello', $data, function($message) use ($data)
                {
					//email 'From' field: Get users email add and name
                    $message->from($data['email'] , $data['name']);
					//email 'To' field: change this to emails that you want to be notified.                    
					$message->to('muhammad.shahzeb@streebo.com', 'Muhammad Shahzeb')->cc('shahzeb1zaidi@gmail.com')->subject('Contact Request');
                });
 
                return Redirect::to('/contact')->withInput()->with('message', 'Thank you for contacting us. We will be in touch shortly.');;  
            }else{
			//return contact form with errors
                return Redirect::to('/contact')->withErrors($validator)->withInput()->with('name','phone_number','email','message');
            }
        }
}
?>