<?php
session_start();
if(isset($_GET["logout"]) && empty($_POST)){
session_destroy();
header('Location: login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>.::Login::.</title>
  <script src="../js/jquery-1.8.0.min.js"></script>
  <style type="text/css">
    /*@import url(https://fonts.googleapis.com/css?family=Roboto:300);*/

.login-page {
  width: 360px;
  padding: 8% 0 0;
  margin: auto;
}
.form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background: #4CAF50;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form button:hover,.form button:active,.form button:focus {
  background: #43A047;
}
.form .message {
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.form .message a {
  color: #4CAF50;
  text-decoration: none;
}
.form .register-form {
  display: none;
}
.container {
  position: relative;
  z-index: 1;
  max-width: 300px;
  margin: 0 auto;
}
.container:before, .container:after {
  content: "";
  display: block;
  clear: both;
}
.container .info {
  margin: 50px auto;
  text-align: center;
}
.container .info h1 {
  margin: 0 0 15px;
  padding: 0;
  font-size: 36px;
  font-weight: 300;
  color: #1a1a1a;
}
.container .info span {
  color: #4d4d4d;
  font-size: 12px;
}
.container .info span a {
  color: #000000;
  text-decoration: none;
}
.container .info span .fa {
  color: #EF3B3A;
}
body {
  background: #76b852; /* fallback for old browsers */
  background: -webkit-linear-gradient(right, #76b852, #8DC26F);
  background: -moz-linear-gradient(right, #76b852, #8DC26F);
  background: -o-linear-gradient(right, #76b852, #8DC26F);
  background: linear-gradient(to left, #76b852, #8DC26F);
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;      
}
  </style>
  <script type="text/javascript">



    function checkForm(){
    $.ajax({ 
                url: "mysql_login.php" ,
                type: "POST",
                data: "submit=login&user="+$("#username").val()+"&password="+$("#password").val(),
            })
               .success(function(result) { 

                var obj = jQuery.parseJSON(result);
                    if(obj != ''){
                      $.each(obj, function(key, val) {
              
                        if(val["status"]=="true"){
                          window.location='dashboard.php';
                        }else{
                          $("#status_msg").html(val["msg"]);
                        }

                      });
                    }

            });
    
    }
  </script>
</head>
<body>
<div class="login-page">
  <div class="form">
    <div class="register-form" >
      <input type="text" placeholder="name"/>
      <input type="password" placeholder="password"/>
      <input type="text" placeholder="email address"/>
      <button>create</button>
      <p class="message">Already registered? <a href="#" onclick="$('.register-form').hide();$('.login-form').show();">Sign In</a></p>
    </div>
    <div class="login-form" >
      <input type="text" id="username" name="username" placeholder="username" autofocus onkeyup="if(event.which==13 && this.value!=''){$('#password').focus();}"/>
      <input type="password" id="password" name="password" placeholder="password" onkeyup="if(event.which==13){checkForm();}" />
      <button onclick="checkForm()">login</button>
      <div id="status_msg" style="color:red;height:20px;"></div>
      <p class="message">Not registered? <a href="#" onclick="$('.register-form').show();$('.login-form').hide();">Create an account</a></p>
    </div>
  </div>
</div>
<script type="text/javascript">
      $('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});
</script>
</body>
</html>



