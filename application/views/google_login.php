<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>User Credintials</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
	
<script src="https://apis.google.com/js/platform.js" async defer></script>
  <style>
      /* Remove the navbar's default margin-bottom and rounded borders */ 
      .navbar {
        margin-bottom: 0;
        border-radius: 0;
      }
      
      /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
      .row.content {height: 450px}
      
      /* Set gray background color and 100% height */
      .sidenav {
        padding-top: 20px;
        background-color: #f1f1f1;
        height: 100%;
      }
      
      /* Set black background color, white text and some padding */
      footer {
        background-color: #555;
        color: white;
        padding: 15px;
      }
      
      /* On small screens, set height to 'auto' for sidenav and grid */
      @media screen and (max-width: 767px) {
        .sidenav {
          height: auto;
          padding: 15px;
        }
        .row.content {height:auto;} 
      }
    </style>
  
 </head>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src='https://www.google.com/recaptcha/api.js'></script>
 <body>
  <div class="container">
   <br />
   <h2 align="center"><a href="#">User Credintials</a></h2>
      <form role="form" action="<?php echo base_url(); ?>Google_login/login" method="post" class="login-form">                  <br />
   <div class="panel panel-default">
   <?php 
   if(!isset($login_button))
   { 
    redirect('chat');
   }
   else
   {
	   
    echo '<div align="center">'.$login_button . '</div>';
   }
   ?>
   <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key') ?>"></div> 
   <br />
   <br />
   </div>
   </form>
  </div>

 </body>
</html>