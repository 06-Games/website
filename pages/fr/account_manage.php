<style>
	/* Your linked accounts */

	#linked {
		border: solid 1px rgba(255, 255, 255, 0.3);
	}

	#linked tr {
		background: none;
	}

	#linked td {
		vertical-align: middle;
		padding: 0.75em;
	}

	#linked tr:not(:last-child) td {
		border-bottom: none;
	}

	#linked td:first-child {
		font-weight: 600;
		font-size: 1.2em;
		color: #ddd;
	}

	#linked td:first-child .image {
		display: inline-block;
		width: 50px;
		height: 50px;
		background-image: url(assets/images/accounts/externalProviders.png);
		background-repeat: no-repeat;
		background-size: 200%;
		overflow: hidden;
		vertical-align: middle;
		margin-right: 0.75em;
	}

	#linked td:nth-child(2) {
		border-right: none;
	}

	#linked td:last-child {
		text-align: right;
	}

	#linked td:last-child .button {
		background-color: #2D2E36;
		box-shadow: none;
		width: 100%;
	}

	@media (max-width: 1279px) {
		#linked thead {
			display: none;
		}

		#linked td {
			display: block;
		}
	}

	#linked td:not(:first-child) {
		border-top: none !important;
	}

	#linked tr:not(:last-child) td,
	#linked tr:last-child td:not(:last-child) {
		border-bottom: none !important;
	}

	}
</style>

<div class="side-menu" style="display: flex; flex-direction: column;">
	<button href="#global" class="active">Général</button>
	<button href="#profile">Profil</button>
	<button href="#external">Comptes liés</button>
	<button href="#library">Bibliothèque</button>
	<div style="flex: 1;"></div>
	<button onclick="Cookies.remove('account'); changeMenu('#Account');">Se déconnecter</button>
	<div class="openBtn">></div>
</div>
<div class="side-content">
	<div>
		<div id="global">
			<h2>Général</h2>
			<hr>
			<a onclick="downloadData();" class="btn">Télécharger les données collectées</a>
			<a href="<?= (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME'] ?>:8887/fr/06games-account"
			 target="_blank" class="btn">Lire la documentation</a>
		</div>
		<div id="profile">
			<h2>Profil</h2>
			<hr>
			<dl style="max-width: 700px;" class="horizontal">
				<dt>Votre avatar</dt>
				<dd>
					<span class="pic" style="background: #272833; vertical-align: middle; display: inline-flex; width: 80px; height: 80px; border-radius: 4px;">
						<img src="<?= empty($account['avatar']) ? 
						" https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y " 
						: $account['avatar'] ?>" style="width: 100%;height: 100%;object-fit: contain;" />
					</span>
					<input type="file" accept="image/*" name="avatar" id="avatar" style="display:none;" onchange="updateAvatar(this);">
					<button class="btn" type="button" style="margin: auto auto auto 2em;" onclick="$('#avatar').click();">Le changer</button>
				</dd>
				<dt>Votre nom d'utilisateur</dt>
				<dd>
					<input type="text" name="username" value="<?= $account['username'] ?>" placeholder="Entrez votre nom d'utilisateur">
				</dd>
				<dt>Votre nom</dt>
				<dd>
					<input type="text" name="fullname" value="<?= $account['fullname'] ?>" placeholder="Entrez votre nom">
				</dd>
				<dt>Votre adresse email</dt>
				<dd>
					<input type="text" name="email" value="<?= $account['email'] ?>" placeholder="Entrez votre adresse email">
				</dd>
				<dt></dt>
				<dd>
					<button class="btn" style="width: 100%; font-family: 'Roboto', Helvetica, sans-serif;" onclick="updateProfile();">Sauvegarder</button>
				</dd>
			</dl>
		</div>
		<div id="external">
			<h2>Comptes liés</h2>
			<hr>
			<table id="linked">
				<thead>
					<tr>
						<th style="width: 25%;"></th>
						<th></th>
						<th style="width: 18.75%;"></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<span class="image" style="background-image: url(assets/images/logo.png); background-size: 100%;"></span> 06Games</td>
						<td>06Games est une startup française spécialisée dans la création de jeux multi-plateformes.</td>
						<td>
							<a class="btn" onclick="$('.modal').fadeIn(200);" style="display: block;">
								<?= $account['password'] == null ? "Définir un mot de passe" : "Changer le mot de passe"; ?>
							</a>
						</td>
					</tr>
					<tr>
						<td>
							<span class="image" style="background-position: 100%;"></span> Google</td>
						<td>Google est spécialisé dans les services et produits liés à Internet, qui incluent les technologies de publicité en
							ligne, les moteurs de recherche, le cloud computing, les logiciels et le matériel.</td>
						<td>
							<a class="btn" onclick="googleAssociate();" style="display: block;">
								<?= $account['googleID'] == null ? "Associer" : "Dissocier"; ?>
							</a>
						</td>
					</tr>
					<tr>
						<td>
							<span class="image"></span> Discord</td>
						<td>Discord est une application VoIP propriétaire conçue pour les communautés de jeu, spécialisée dans la communication
							textuelle, vidéo et audio entre les utilisateurs d'un canal de chat.</td>
						<td>
							<a class="btn" onclick="discordAssociate();" style="display: block;">
								<?= $account['discordID'] == null ? "Associer" : "Dissocier"; ?>
							</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div id="library">
			<h2>Bibliothèque</h2>
			<hr>
		</div>
	</div>
</div>


<div class="modal" style="display: none;">
	<div>
		<div class="head">
			<span>Changer votre mot de passe</span>
			<span id="close" onclick="$(this).parents('.modal').fadeOut(200);">x</span>
		</div>
		<div class="content">
			<input type="password" placeholder="Nouveau mot de passe" name="new-password" required />
			<input type="password" placeholder="Confirmation du mot de passe" name="confirm-password" required />

			<input value="<?= $account['password'] == " " ? " " : "Change password " ?>"
			 style="margin-top: 1em;" type="submit" class="Submit" onclick="accountPassword();" />
		</div>
	</div>
</div>

<script>
	registerSideMenu(".side-content");
</script>

<script src="https://apis.google.com/js/api:client.js"></script>
<script>
	/**********
	 *  Home  *
	 **********/

	function downloadData() {
		var xhr = new XMLHttpRequest();
		xhr.open('POST', "api/v1/accounts/manage/export");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			var element = document.createElement('a');
			element.setAttribute('href', 'data:application/json;charset=utf-8,' +
				encodeURIComponent(json_decode(xhr.responseText)['result']));
			element.setAttribute('download', 'data.json');

			element.style.display = 'none';
			document.body.appendChild(element);
			element.click();
			document.body.removeChild(element);
		};
		xhr.send();
	}


	/***********
	 * Profile *
	 ***********/

	function updateAvatar(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$imageCpn = $(input).siblings(".pic").find('img');

				var img = new Image();
				img.onload = function() {
					//Resize
					var canvas = document.createElement("canvas");
					var MAX_WIDTH = 128;
					var MAX_HEIGHT = 128;
					var width = img.width;
					var height = img.height;
					if (width > height) {
						if (width > MAX_WIDTH) {
							height *= MAX_WIDTH / width;
							width = MAX_WIDTH;
						}
					} else if (height > MAX_HEIGHT) {
						width *= MAX_HEIGHT / height;
						height = MAX_HEIGHT;
					}
					canvas.width = width;
					canvas.height = height;
					canvas.getContext("2d").drawImage(img, 0, 0, width, height);

					// Convert to PNG data url
					$imageCpn.attr('src', canvas.toDataURL("image/png"));
				};
				img.src = e.target.result;
			};
			reader.readAsDataURL(input.files[0]);
		}
	}

	function updateProfile() {
		$avatar = $("#profile .pic img").attr('src');
		if (!$avatar.startsWith('data:image/png;base64,')) $avatar = '';
		$username = $("#profile input[name=username]").val();
		$fullname = $("#profile input[name=fullname]").val();
		$email = $("#profile input[name=email]").val();

		var xhr = new XMLHttpRequest();
		xhr.open('POST', "api/v1/accounts/manage/update");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			$json = JSON.parse(xhr.responseText);
			if ($json != null && $json['code'] == 0) changeMenu('#Account');
			else if ($json != null) alert(xhr.responseText);
		};
		xhr.send('avatar=' + encodeURIComponent($avatar).replace(new RegExp('%2B', 'g'), 'amp;PLUSamp;') + '&username=' +
			$username + '&fullname=' + $fullname + '&email=' + $email);
	}


	/***********
	 * Linked  *
	 ***********/

	function accountPassword() {
		$newPassword = $(".modal input[name=new-password]").val();
		$confirmPassword = $(".modal input[name=confirm-password]").val();

		if ($newPassword == $confirmPassword && $newPassword != "") {
			var xhr = new XMLHttpRequest();
			xhr.open('POST', "api/v1/accounts/manage/link");
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function() {
				$json = JSON.parse(xhr.responseText);
				if ($json != null && $json['code'] == 0) changeMenu('#Account');
				else if ($json != null) alert(xhr.responseText);
			};
			xhr.send('provider=06Games&authID=' + $newPassword);
		} else alert('Informations incorrectes');
	}

	function googleAssociate() {
		<?php
		if ($account['googleID'] == null) { ?>
		gapi.load('auth2', function() {
			// Retrieve the singleton for the GoogleAuth library and set up the client.
			auth2 = gapi.auth2.init({
				client_id: '162172060216-4vek345botmoamfalh5a4hn2llt76n7n.apps.googleusercontent.com',
				cookiepolicy: 'single_host_origin'
			});

			var element = document.createElement('a');
			element.style.display = 'none';
			document.body.appendChild(element);

			auth2.attachClickHandler(element, {}, connectGoogle,
				function(error) {
					alert(JSON.stringify(error, undefined, 2));
				}
			);

			element.click();
			document.body.removeChild(element);
		});

		function connectGoogle(googleUser) {
			var token = googleUser.getAuthResponse().id_token;

			var xhr = new XMLHttpRequest();
			xhr.open('POST', "api/v1/accounts/manage/link");
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function() {
				$json = JSON.parse(xhr.responseText);
				if ($json != null && $json['code'] == 0) changeMenu('#Account');
				else if ($json != null) alert(xhr.responseText);
			};
			xhr.send('provider=Google&authID=' + token);
		}
		<?php } else if ($account['password'] != null) { ?>
		var xhr = new XMLHttpRequest();
		xhr.open('POST', "api/v1/accounts/manage/link");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			$json = JSON.parse(xhr.responseText);
			if ($json != null && $json['code'] == 0) changeMenu('#Account');
			else if ($json != null) alert(xhr.responseText);
		};
		xhr.send('provider=Google&authID=');
		<?php } else { ?>
		alert("Vous devez d'abord définir un mot de passe !");
		<?php } ?>
	}

	function discordAssociate() {
		<?php
		if ($account['discordID'] == null) { ?>
		window.location.href =
			"https://discord.com/api/oauth2/authorize?response_type=code&client_id=648170006064136212&redirect_uri=<?= $_SERVER['HTTP_REFERER'].'callback/discord' ?>&scope=identify%20email";
		<?php } else if ($account['password'] != null) { ?>
		var xhr = new XMLHttpRequest();
		xhr.open('POST', "api/v1/accounts/manage/link");
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			$json = JSON.parse(xhr.responseText);
			if ($json != null && $json['code'] == 0) changeMenu('#Account');
			else if ($json != null) alert(xhr.responseText);
		};
		xhr.send('provider=Discord&authID=');
		<?php } else { ?>
		alert("Vous devez d'abord définir un mot de passe !");
		<?php } ?>
	}
</script>