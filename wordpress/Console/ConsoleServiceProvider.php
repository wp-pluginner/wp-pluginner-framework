<?php

namespace WpPluginner\Wordpress\Console;

use WpPluginner\Lumen\Console\ConsoleServiceProvider as ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{

    protected $commands = [
        'CacheClear' => 'command.cache.clear',
        'CacheForget' => 'command.cache.forget',
        //'ClearResets' => 'command.auth.resets.clear',
        'Migrate' => 'command.migrate',
        'MigrateInstall' => 'command.migrate.install',
        'MigrateRefresh' => 'command.migrate.refresh',
        'MigrateReset' => 'command.migrate.reset',
        'MigrateRollback' => 'command.migrate.rollback',
        'MigrateStatus' => 'command.migrate.status',
        'QueueFailed' => 'command.queue.failed',
        'QueueFlush' => 'command.queue.flush',
        'QueueForget' => 'command.queue.forget',
        'QueueListen' => 'command.queue.listen',
        'QueueRestart' => 'command.queue.restart',
        'QueueRetry' => 'command.queue.retry',
        'QueueWork' => 'command.queue.work',
        'Seed' => 'command.seed',
        'ScheduleFinish' => 'WpPluginner\Illuminate\Console\Scheduling\ScheduleFinishCommand',
        'ScheduleRun' => 'WpPluginner\Illuminate\Console\Scheduling\ScheduleRunCommand',
    ];
}
