<?php

error_reporting(E_ALL & ~E_NOTICE & ~8192);
define('THIS_SCRIPT', 'vde_builder');

if (!is_array($argv)) {
    die('VDE must be run via CLI');
}

define('CLI_ARGS', serialize($argv));

chdir(dirname($_SERVER['SCRIPT_NAME']));
require('./global.php');
require_once(DIR . '/includes/vde/builder.php');
require_once(DIR . '/includes/vde/project.php');

$argv = unserialize(CLI_ARGS);

################################################################################
// Build Project
if ($argv[1] == 'build') {
    
    try {
        $builder = new VDE_Builder($vbulletin);
        echo $builder->build(new VDE_Project($argv[2]));
    } catch (Exception $e) {
        echo $e->getMessage() . PHP_EOL;   
    }
    
################################################################################
// Run File
} else if ($argv[1] == 'run') {
    
    require "includes/cron/$argv[2]";
    
################################################################################
// No Command Selected
} else {
    
    die('Invalid command.  Use build or run' . PHP_EOL);
}