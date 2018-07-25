<?php
	$home=trim(shell_exec('echo $HOME')).'/';
	$wd=".getssl/";
	$fixedtext="\n".'CA="https://acme-v01.api.letsencrypt.org"
USE_SINGLE_ACL="true"
ACCOUNT_KEY_LENGTH=4096
ACCOUNT_KEY="'.$home.'.getssl/account.key"
PRIVATE_KEY_ALG="rsa"
REUSE_PRIVATE_KEY="true"
RENEW_ALLOW="30"
SERVER_TYPE="https"
CHECK_REMOTE="true"';
	$f=shell_exec("cpapi2 AddonDomain listaddondomains --output=json");
	//$f=file_get_contents("list.txt");
	$f=json_decode($f)->cpanelresult->data;
	//print_r($f);
	foreach($f as$g)
	{$ds="SANS=\"".$g->fullsubdomain.",www.".$g->fullsubdomain;
	foreach($g->web_subdomain_aliases as $subd)$ds.=",".$subd.".".$g->domain;
	$ds.="\"";
	//echo $ds;
$ds.="\nACL='".$g->dir."/.well-known/acme-challenge'";
$ds.=$fixedtext;
if(!is_dir($wd.$g->basedir))mkdir($wd.$g->basedir);
file_put_contents($wd.$g->basedir ."/getssl.cfg",$ds);
	}
$ds="SANS=\"www.".$g->rootdomain;
	$ds.=",mail.".$g->rootdomain;
	$ds.="\"";
	//echo $ds;
$ds.="\nACL='".$home.'public_html/'."/.well-known/acme-challenge'";
$ds.=$fixedtext;
if(!is_dir($wd.$g->rootdomain))mkdir($wd.$g->rootdomain);
file_put_contents($wd.$g->rootdomain ."/getssl.cfg",$ds);
	?>