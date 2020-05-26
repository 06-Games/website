<style>
	@media (min-width: 1024px) {
		#account {
			width: calc(100% - 400px);
			flex: initial;
		}
		#other {
			padding: 0 2.5em;
		}
	}

	@media (max-width: 1023px) {
		#login {
			flex-direction: column;
		}
	}

	#account a {
		float: right;
		color: #f88;
		cursor: pointer;
	}

	@media(max-width:665px) {
		#account a {
			float: none;
			margin: 0.5em 0;
			display: block;
		}
	}

	#other {
		display: flex;
		justify-content: center;
		flex-direction: column;
	}

	#other>div {
		cursor: pointer;
		max-width: 300px;
		border-radius: 2.5px;
		margin-bottom: 10px;
	}

	#other div .icon {
		background-color: white;
		display: inline-block;
		vertical-align: middle;
		width: 42px;
		height: 42px;
		border-radius: 2.5px 0 0 2.5px;
	}

	#other div .icon>span {
		background-image: url(assets/images/accounts/externalProviders.png);
		background-repeat: no-repeat;
		background-size: 200%;
		overflow: hidden;
		display: block;
		width: 30px;
		height: 30px;
		margin: 6px;
	}

	#other div .buttonText {
		padding-left: 0.25em;
		font-size: 14px;
		font-weight: bold;
	}
</style>

<div style="height: 100%; display: flex; justify-content: center; align-items: center;">
	<div id="login" class="col" style="padding: 0 1em; flex: 1; max-width: 1200px;">
		<div id="account">
			<div style="background-color: #f006;">
				<?= isset($_SESSION['error']) ? $_SESSION['error'] : "" ?>
			</div>
			<div class="connect">
				<h3>Se connecter avec un compte 06Games
					<a onclick="$('.connect').fadeOut(300, function() { $('.create').fadeIn(500, function() {}); });">Pas de compte ?</a>
				</h3>
				<input type="text" placeholder="Email ou Nom d'utilisateur" name="email" required />
				<input type="password" placeholder="Mot de passe" name="password" autocomplete="password" required />
				<input type="submit" value="Se connecter" name="signin" class="Submit" onclick="connectAccount();" />
			</div>
			<div class="create" style="display: none;">
				<h3>Créer un compte 06Games
					<a onclick="$('.create').fadeOut(300, function() { $('.connect').fadeIn(500, function() {}); });">Déjà inscrit ?</a>
				</h3>
				<input type="text" placeholder="Nom d'utilisateur" name="username" required />
				<input type="text" placeholder="Nom complet" name="fullname" required />
				<input type="email" placeholder="Email" name="email" required />
				<input type="password" placeholder="Mot de passe" name="password" autocomplete="password" required />
				<input type="password" placeholder="Confirmer le mot de passe" name="confirmpassword" autocomplete="password" required />
				<input type="submit" value="S'inscrire" name="register" class="Submit" onclick="createAccount();" />
			</div>
		</div>
		<div id="other">
			<h3>Ou se connecter avec</h3>
			<div id="google" style="background: #4285F4;">
				<span class="icon">
					<span style="background-position: 100%;"></span>
				</span>
				<span class="buttonText">Google</span>
			</div>
			<div id="discord" style="background: #7289DA;" onclick="connectDiscord();">
				<span class="icon">
					<span style="background-position: 0;"></span>
				</span>
				<span class="buttonText">Discord</span>
			</div>
		</div>
	</div>
</div>

<script src="assets/js/forge.min.js"></script>
<script src="https://apis.google.com/js/api:client.js" async defer></script>
<script>
	/*********************
	 *        API        *
	 *********************/

	function sha384(str) {
		return forge.md.sha384.create().update(str).digest().toHex();
	}

	/*********************
	 *      06Games      *
	 *********************/

	function connectAccount() {
		$user = $("#account .connect input[name=email]").val();
		$pass = $("#account .connect input[name=password]").val();

		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'api/v1/accounts/auth/06games/connect');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			$json = JSON.parse(xhr.responseText);
			if ($json != null && $json.code == 0) {
				Cookies.set('account', $json.token);
				changeMenu('#Account');
			} else $('#error').show().find('td').text($json.state);
		};
		xhr.send('id=' + $user + '&password=' + $pass);
	}

	function createAccount() {
		$email = $("#account .create input[name=email]").val();
		$password = $("#account .create input[name=password]").val();
		$confirmpassword = $("#account .create input[name=confirmpassword]").val();
		$username = $("#account .create input[name=username]").val();
		$fullname = $("#account .create input[name=fullname]").val();

		if ($password == $confirmpassword) {
			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'api/v1/accounts/auth/06games/create');
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function() {
				$json = JSON.parse(xhr.responseText);
				if ($json != null && $json.code == 0) {
					Cookies.set('account', $json.token);
					changeMenu('#Account');
				} else $('#error').show().find('td').text($json.state);
			};
			xhr.send('email=' + $email + '&password=' + $password + "&username=" + $username + "&fullname=" + $fullname);
		} else $('#error').show().find('td').text("Confirmation field and password do not match");
	}


	/*********************
	 *       Google      *
	 *********************/

	$(document).ready(function() {
		setTimeout(function() {
			gapi.load('auth2', function() {
				// Retrieve the singleton for the GoogleAuth library and set up the client.
				auth2 = gapi.auth2.init({
					client_id: '162172060216-4vek345botmoamfalh5a4hn2llt76n7n.apps.googleusercontent.com',
					cookiepolicy: 'single_host_origin',
					// Request scopes in addition to 'profile' and 'email'
					//scope: 'additional_scope'
				});
				auth2.attachClickHandler(document.getElementById('google'), {}, connectGoogle,
					function(error) {
						alert(JSON.stringify(error, undefined, 2));
					}
				);
			});
		}, 500);
	});

	function connectGoogle(googleUser) {
		var token = googleUser.getAuthResponse().id_token;

		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'api/v1/accounts/auth/google');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			$json = JSON.parse(xhr.responseText);
			if ($json != null && $json.code == 0) {
				Cookies.set('account', $json.token);
				changeMenu('#Account');
			} else $('#error').show().find('td').text($json.state);
		};
		xhr.send('token=' + token);
	}


	/**********************
	 *       Discord      *
	 **********************/

	function connectDiscord() {
		window.location.href =
			"https://discordapp.com/api/oauth2/authorize?response_type=code&client_id=648170006064136212&redirect_uri=<?= (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ?>&scope=identify%20email";
	}
</script>