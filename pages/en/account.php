<?php
include "../../api/v1/accounts/.private/checkToken.php";
if ($account == null) include 'account_login.php';
else include 'account_manage.php';
