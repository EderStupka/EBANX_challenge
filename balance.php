<?php
	
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
		    $account_id = $_GET['account_id'];
			if ($account_id == '1234'){
				$httpStatus = "404";
				$data = "0";
			}
			else{
				$httpStatus = "200";
				$data = "20";
			}
        }				

?>


<?php 
	header_remove();

    header("Content-Type: application/json");

    http_response_code($httpStatus);

    echo ($data);
?>


<?php 
# Get balance for non-existing account
#GET /balance?account_id=1234
#404 0
#--
# Get balance for existing account
#GET /balance?account_id=100
#200 20
#--
?>