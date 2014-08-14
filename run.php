<?php
use basecamp2redmine\basecamp\Connector as BasecampConnector;
use basecamp2redmine\redmine\Connector as RedmineConnector;
use basecamp2redmine\sync\ProjectsSync;

require 'autoload.php';
$ini = parse_ini_file(__DIR__."/run.ini", true);


$bs_connector = new BasecampConnector($ini['basecamp']['url'], $ini['basecamp']['user'], $ini['basecamp']['password']);
$rm_connector = new RedmineConnector($ini['redmine']['url'], $ini['redmine']['user'], $ini['redmine']['password']);

echo "projects...";
(new ProjectsSync($bs_connector, $rm_connector))->basecamp_to_redmine($ini['redmine']['project_role']);
echo "ok\n";

echo "users...";
(new \basecamp2redmine\sync\UsersSync($bs_connector, $rm_connector))->basecamp_to_redmine();
echo "ok\n";
