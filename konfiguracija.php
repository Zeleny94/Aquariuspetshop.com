<?php
	include_once("konekcija.php");
	$konfiguracija = $conn->prepare("select * from konfiguracija");
	$konfiguracija->execute();
    while($konfiguracija_output = $konfiguracija->fetch()){
    	$ime = $konfiguracija_output['ime_konf']; 
    	$$ime = $konfiguracija_output['vrednost_konf'];
}
$url = $http_https.$urli;