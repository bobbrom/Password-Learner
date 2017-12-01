<html>
	<head>
		<link rel='icon' href='favicon.png'>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<link rel='stylesheet' href='style.css'>
		<script src="code.js"></script>
		<title>Password Learner</title>
	</head>
	<body>
		<main>
			<h1>Password Learner</h1>
			<?php
				if(isset($_GET['password'])){
					$password = $_GET['password'];
					
			?>
				<div class='score'>
					<h3 id='wrong'>00</h3>
					<h3 id='correct'>00</h3>
				</div>	
				<h2 id='correct_password'><?php echo $password; ?></h2><p id='correct_hide'>Hide/Show</p>
				<input type='text' id='password_check'>
				<h3 id='hide_show'>Hide Password</h3>
				<h2 id='result'></h2>
				<h2 id='result1'></h2>
				<h2 id='timer'>0</h2>
				<script>
				var $timer = '';
					function differnce(correct_password,input_password){
						var correct_password = correct_password.split('');
						var input_password = input_password.split('');
						
						var password_array = [];
						for(var i = 0; i < input_password.length; i++){
							if(correct_password[i] == input_password[i]){
								password_array[i] = input_password[i];
							}else{
								password_array[i] = '<span class="wrong_char">'+input_password[i]+'</span>';
							}
						}
						return password_array.join('');
					}
					$(document).ready( function(){
						$('#hide_show').click(function(){
							if($('#password_check').prop('type') == 'text'){
								$('#password_check').prop('type', 'password');
								document.getElementById('hide_show').innerHTML = 'Show Password';
							}else{
								$('#password_check').prop('type', 'text');
								document.getElementById('hide_show').innerHTML = 'Hide Password';
							}
						})
						var amountCorrect = (localStorage.getItem("correctPassword_<?php echo $password; ?>"))*1;
						document.getElementById('correct').innerHTML = amountCorrect;
						
						var amountWrong = (localStorage.getItem("wrongPassword_<?php echo $password; ?>"))*1;
						document.getElementById('wrong').innerHTML = amountWrong;

						$('#correct_hide').click( function(){
							$('#correct_password').toggle();
						});
						
						$('#password_check').on('input',function(){
							if(myTimer() < 3){
								if(event.keyCode != 8){
										timer = setInterval(myTimer, 10);
										var timerBool = true
										//console.log(timer)
									
								}
							}

						});
						
						$('#password_check').keyup(function(event){
							if(event.keyCode == 13){
								if(!event.shiftKey){
									answer( $('#timer').html() )
									//console.log(window.timer)
									clearInterval(timer)
									timerBool = false
									$('#timer').html('0')
								}
							}
						});						
						
					});
					
					
					
					
					
					
					function answer(t){
						var correct = '<?php echo $password; ?>';
						var input = $('#password_check').val().trim()
						//alert(input)
						if(input == correct){
							
							document.getElementById('result').innerHTML = 'That was correct';
							$('#result').css({'color':'green'});
							var amountCorrect = (localStorage.getItem("correctPassword_<?php echo $password; ?>"))*1;
							var amountCorrect = amountCorrect + 1;
							localStorage.setItem("correctPassword_<?php echo $password; ?>", amountCorrect);
							document.getElementById('correct').innerHTML = amountCorrect;
							
							
							t = parseInt(t)
							if (localStorage.getItem('minTime_<?php echo $password; ?>') === null) {
								$('#result1').html('Your time was '+(t/100)+' seconds')
								localStorage.setItem('minTime_<?php echo $password; ?>',t);
							}else{
								var minTime = parseInt(localStorage.getItem('minTime_<?php echo $password; ?>'));
								//alert(t < minTime)
								if(t < minTime){
									localStorage.setItem('minTime_<?php echo $password; ?>',t);
									$('#result1').html('Your time was '+(t/100)+' seconds'+'</br>This is your fastest time')
								}else{
									$('#result1').html('Your time was '+(t/100)+' seconds'+'</br>Your minimum time is '+(minTime/100)+' seconds')
								}
							}
							
						}else{
							var amountWrong = (localStorage.getItem("wrongPassword_<?php echo $password; ?>"))*1;
							var amountWrong = amountWrong + 1
							localStorage.setItem("wrongPassword_<?php echo $password; ?>", amountWrong);
							document.getElementById('wrong').innerHTML = amountWrong;
							document.getElementById('result').innerHTML = 'You wrote '+differnce(correct,input)+' that is incorrect';
							$('#result').css({'color':'red'});
						}
						$('#password_check').val('')


					}
					function myTimer(){
						var prevTime = parseInt($('#timer').html())
						var time = prevTime+1
						$('#timer').html(time)
						return time;
					}
					
					
					
					$('#password_check').keyup(function(event){
						if(event.keyCode == 8){
							if(event.shiftKey){
								localStorage.setItem("correctPassword_<?php echo $password; ?>", 0);
								localStorage.setItem("wrongPassword_<?php echo $password; ?>", 0);
								
								var amountCorrect = (localStorage.getItem("correctPassword_<?php echo $password; ?>"))*1;
								document.getElementById('correct').innerHTML = amountCorrect;
								
								var amountWrong = (localStorage.getItem("wrongPassword_<?php echo $password; ?>"))*1;
								document.getElementById('wrong').innerHTML = amountWrong;
								
								localStorage.removeItem('minTime_<?php echo $password; ?>');
							}
						}
					});
				</script>
			<?php
				}else{
			?>
				<style>
					footer h2{	display:none;	}
				</style>
				<h2 id='hint'>Please input the password you wish to learn</h2>
				<form action="<?php $_SERVER['PHP_SELF']?>" method="get" enctype='multipart/form-data'>
					<input type='text' name='password'/>
				</form>
				<?php
				}
				?>
		</main>
		<footer>
			<h2>Press Shift + Backspace in answer box to reset counter</h2>
		</footer>
	</body>
</html>