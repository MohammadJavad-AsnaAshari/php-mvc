<?php

use Mj\PocketCore\Router;

Router::get('/admin', 'admin.index');
Router::get('/admin/users', 'admin.users.all');