<?php
define('ROOTPATH', __DIR__);
define('NO_LAYOUT', false);

require 'Core/App.php';

App::getInstance()->init();
App::$kernel->launch();