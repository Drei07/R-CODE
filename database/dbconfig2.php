<?php
	try {

		// Localhost
		$pdoConnect = new PDO("mysql:host=localhost;dbname=sample", "root", "");

		// Live
		// $pdoConnect = new PDO("mysql:host=localhost;dbname=sample", "root", "");`

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