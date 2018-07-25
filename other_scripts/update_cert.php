<?php
$f=shell_exec("cpapi2 AddonDomain listaddondomains --output=json");
	//$f=file_get_contents("list.txt");
	$f=json_decode($f)->cpanelresult->data;
	//print_r($f);
	foreach($f as$g)
	shell_exec("./cpanel_cert_upload $g->domain");
	shell_exec("./cpanel_cert_upload $g->rootdomain");
	?>