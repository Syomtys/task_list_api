<?
session_start();
if(isset($_SESSION['user_id'])){
	header('Location: ../');
	exit;
}
?>
<html>
	<head>
		<title>auth</title>
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>
		<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'>
		<meta charset="utf-8" />
	</head>
	<body>
		
		
		<div class='body_container'>
			<div class='window_block'>
				<div id="select_form">
					<span id="log_in" onclick="select_form('log_in')" >log in</span>
					<span id="sign_up" onclick="select_form('sign_up')" class="no_selected">sign up</span>
				</div>
				<div class="form_send">
					<form method="post" onsubmit="return false" id="form_action">
						<input id="name" name='username' required type="text" pattern="[a-zA-Z0-9_]*" placeholder="login"><br>
						<input id="email" name='password' required type="password" minlength="8" placeholder="password"><br>
						<input type="hidden" name="select_auth" id="select_auth" value="log_in"/>
						<input type='submit' value='отправить'/><br>
						
					</form>
				</div>
			</div>
		</div>
		
		<script>
			function select_form(arg) {
				if (arg=='log_in'){
					$('#log_in').removeClass('no_selected');
					$('#sign_up').addClass('no_selected');
					$('#select_auth').val('log_in');
				} else if (arg=='sign_up'){
					$('#sign_up').removeClass('no_selected');
					$('#log_in').addClass('no_selected');
					$('#select_auth').val('sign_up');
				}
				// console.log(arg);
			}
			$('document').ready(function(){
				$('#form_action').on('submit',function () {
					let data_action_form = $(this).serialize();
					$.post('auth.php', data_action_form, function(data){
						// console.log(data);
						var response = JSON.parse(decodeURIComponent(data));
						if (response['code'] == 1){
							window.location.href = '../';
							console.log('sed');
						}
						$('form').append('<span id="">'+response['message']+'</span>');
						setTimeout(function() {
						  $('form span').remove();
						}, 2000); 
						
						// if (response.valid) {
						// 	console.log(1);
						// 	$('input[type=submit]').remove();
						// 	$('.window_block form').append('<span>данные отправлены</span>');
						// 	$("input").val("");
						// } else {
						// 	console.log(0);
						// 	$('.window_block form').append('<span>данные не прошли валидацию<br>проверьте и повторите попытку</span>');
						// 	setTimeout(function() {
						// 		$('.window_block form span').remove();
						// 	}, 5000);
						// }
					});
				});
			});
		</script>
		
		<style>
			*{
				margin: 0;
				padding: 0;
			}
			.window_block form span{
				color: #e32c63;
			}
			.window_block form{
				
			}
			.form_send{
				width: 100%;
				height: 80%;
				display: flex;
				align-items: center; 
				justify-content: center;
			}
			input:not([type="submit"]){
				margin-bottom: 10px;
				width: 45vw;
				padding: 4px;
				border-radius: 3px;
				background: #6049d4;
				text-align: center;
				font-size: 12px;
				color: #e32c63;
			}
			input[type=submit]{
				padding: 4px;
				border-radius: 3px;
				background: #e32c63;
				color: #111b74;
			}
			form span{
				margin-top: 10px;
				color: #e32c63;
			}
			input {
			  outline: none;
			  border: none;
			}
			.body_container{
				text-align: center;
				width: 100vw;
				height: 100vh;
				background: #111b74;
				color: #6049d4;
				display: flex;
				align-items: center; 
				justify-content: center;
			}
			#log_in{
				display: block;
				width:50%;
				padding: 10px 0;
			}
			#sign_up{
				display: block;
				width:50%;
				padding: 10px 0;
			}
			#select_form{
				display: flex;
				justify-content: space-evenly;
			}
			.no_selected{
				background: #171f6e;
				border-radius: 0 3px;
			}
			.window_block{
				background: #2c2489;
				border-radius: 3px;
				width: 80vw;
				height: 50vw;
				/* display: flex;
				align-items: center; 
				justify-content: center; */
			}
		</style>
	</body>
</html>


