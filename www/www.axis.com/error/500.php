<?php

echo '505';
if (isset($e) && $e instanceof Exception ) {
	$errorMessage = $e->getMessage();
	echo '<br><br>'.$errorMessage;
}
exit;
