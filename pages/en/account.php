<?php
include("../../api/v1/accounts/.private/checkToken.php");
if($account == null && isset($_GET['code'])){ ?>

<script>
	var token = "<?= $_GET['code'] ?>";
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '../../api/v1/accounts/auth/discord');
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onload = function() {
		var json = JSON.parse(xhr.responseText);
		if (json != null && json.code == 0) document.cookie = "account=" + json.token + ";path=/";
		else sessionStorage.setItem("error", json.message);
		window.location.href = "../../#Account";
	};
	xhr.send('code=' + token);
</script>
<p>Please wait</p>

<?php 
} 
else if ($account == null) include('account_login'); 
else include('account_manage.php');
