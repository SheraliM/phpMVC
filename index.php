<?php

define('ROOTPATH', __DIR__);
require __DIR__.'/App/App.php';

\App\App::init();
\App\App::$kernel->launch();