<?php

declare(strict_types=1);

use Hyperf\Contract\ApplicationInterface;
use Hyperf\Di\ClassLoader;
use Swoole\Runtime;
use Mine\AppStore\Plugin;

/*
 * This file is part of MineAdmin.
 *
 * @see     https://www.mineadmin.com
 * @document https://doc.mineadmin.com
 * @contact  root@imoi.cn
 * @license  https://github.com/mineadmin/MineAdmin/blob/master/LICENSE
 */
ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');

error_reporting(E_ALL);
date_default_timezone_set('Asia/Shanghai');

! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));
! defined('SWOOLE_HOOK_FLAGS') && define('SWOOLE_HOOK_FLAGS', SWOOLE_HOOK_ALL);

// Runtime::enableCoroutine(true);

require BASE_PATH . '/vendor/autoload.php';

Plugin::init();
ClassLoader::init();

$container = require BASE_PATH . '/config/container.php';

$container->get(ApplicationInterface::class);
