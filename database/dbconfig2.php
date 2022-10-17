<?php
	try {

		// Localhost
		$pdoConnect = new PDO("mysql:host=localhost;dbname=fisheryapp", "root", "");

		// Live
		// $pdoConnect = new PDO("mysql:host=localhost;dbname=u867039073_fisheryapp", "u867039073_fisheryapp", "Andreishania12");

		$pdoConnect->setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);

	}
	catch (PDOException $exc){
		echo $exc -> getMessage();
	}
    catch (PDOException $exc){
        echo $exc -> getMessage();
    exit();
    }
?>