<?php
require_once('CAxiumControl.php');
$config = require('musiccontrolconfig.php');

if(!isset($_GET['action']))
{
	exit;
}

$action = $_GET['action'];

/* @var $ampControl CAxiumControl */
$ampControl = new CAxiumControl($config['comport']);

switch($action)
{
    case 'alloff':
        $ampControl->standByAll();
        break;
     case 'allon':
        $ampControl->awakeAll();
        break;
     case 'changevolume':
        $zone = $_GET['zone'];
        $volume = $_GET['volume'];
        $ampControl->setVolume($zone, $volume);
        break;
    case 'mute': 
        $ampControl->setMute($_GET['zone'], true);
        break; 
     case 'unmute': 
        $ampControl->setMute($_GET['zone'], false);
        break; 
    default: echo "Unknown action"; break;
}



?>