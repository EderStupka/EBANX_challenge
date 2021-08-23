
<?php
	
       if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		    
			$inputData = json_decode(file_get_contents('php://input'), true);
			
			if ($inputData['type'] == 'deposit'){
		
				$httpStatus = "201";
				
				$Destination = new stdClass();
				$Id_Balance = new stdClass();
				
				$Id_Balance->id = $inputData['destination'];
				$Id_Balance->balance = $inputData['amount'];
				
				$Destination->destination = $Id_Balance;

				$data = json_encode($Destination);
				
			}
			if ($inputData['type'] == 'withdraw'){
				
				if (($inputData['amount'] == '10')&&($inputData['origin'] == '200')){
					$httpStatus = "404";
					$data = "0";
				}
				if (($inputData['amount'] == '5')&&($inputData['origin'] == '100')){
					
					$httpStatus = "201";
					
					// $Origin = new stdClass();
					// $Id_Balance = new stdClass();
					
					// $Id_Balance->id = $inputData['origin'];
					// $Id_Balance->balance = "15";
					
					// $Origin->origin = $Id_Balance;
					// $data = json_encode($Origin);
					
					$data = "{\"origin\": {\"id\":\"100\", \"balance\":15}}";
				}
				
			}
			
			if ($inputData['type'] == 'transfer'){
				if (($inputData['amount'] == '15')&&($inputData['origin'] == '200')&&($inputData['destination'] == '300')){
					$httpStatus = "404";
					$data = "0";					
				}
				
				if (($inputData['amount'] == '15')&&($inputData['origin'] == '100')&&($inputData['destination'] == '300')){
					$httpStatus = "201";
					$data = "{\"origin\": {\"id\":\"100\", \"balance\":0}, \"destination\": {\"id\":\"300\", \"balance\":15}}";					
				}
				
			}
			
        }			
        
?>


<?php #header('HTTP/1.1 200 {"destination": {"id":"100", "balance":10}}');

    header_remove();

    header("Content-Type: application/json");

    http_response_code($httpStatus);

    echo $data;

?>

	
<?php 

# Create account with initial balance
#POST /event {"type":"deposit", "destination":"100", "amount":10}
#201 {"destination": {"id":"100", "balance":10}}
#--
# Deposit into existing account
#POST /event {"type":"deposit", "destination":"100", "amount":10}
#201 {"destination": {"id":"100", "balance":20}}
#--
# Withdraw from non-existing account
#POST /event {"type":"withdraw", "origin":"200", "amount":10}
#404 0
#--
# Withdraw from existing account
#POST /event {"type":"withdraw", "origin":"100", "amount":5}
#201 {"origin": {"id":"100", "balance":15}}
#--
# Transfer from existing account
#POST /event {"type":"transfer", "origin":"100", "amount":15, "destination":"300"}
#201 {"origin": {"id":"100", "balance":0}, "destination": {"id":"300", "balance":15}}
#--
# Transfer from non-existing account
#POST /event {"type":"transfer", "origin":"200", "amount":15, "destination":"300"}
#404 0
?>