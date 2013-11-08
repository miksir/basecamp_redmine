<?php
use basecamp2redmine\basecamp\Connector as BasecampConnector;
use basecamp2redmine\redmine\Connector as RedmineConnector;
use basecamp2redmine\sync\ProjectsSync;

require 'autoload.php';

$bs_connector = new BasecampConnector('https://basecamp.com/999999999/api/v1', 'some@user', 'password');
$rm_connector = new RedmineConnector('http://redmine.local', 'admin', 'password');

(new ProjectsSync($bs_connector, $rm_connector))->basecamp_to_redmine(array(7 => 6));
