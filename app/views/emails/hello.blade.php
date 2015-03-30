<!--This is a blade template that goes in email message to site administrator-->
<?php
//get the first name
$name = Input::get('name');
$phone_number = Input::get('phone_number');
$email = Input::get ('email');
$message = Input::get ('message');
$date_time = date("F j, Y, g:i a");
$userIpAddress = Request::getClientIp();
?> 
 
<h2 class="muted credit">We have been contacted by: </h1>
 
<p class="muted credit">
Name: <?php echo ($name); ?> <br>
Phone number: <?php echo($phone_number);?><br>
Email address: <?php echo ($email);?> <br>
Message: <?php echo ($message);?><br>
Date: <?php echo($date_time);?><br>
User IP address: <?php echo($userIpAddress);?><br>
</p>
<?>