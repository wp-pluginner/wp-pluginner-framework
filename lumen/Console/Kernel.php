<?php

namespace WpPluginner\Lumen\Console;

use Exception;
use Throwable;
use RuntimeException;
use WpPluginner\Lumen\Application;
use WpPluginner\Illuminate\Console\Scheduling\Schedule;
use WpPluginner\Illuminate\Console\Application as Artisan;
use WpPluginner\Illuminate\Contracts\Cache\Repository as Cache;
use WpPluginner\Illuminate\Contracts\Console\Kernel as KernelContract;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class Kernel implements KernelContract
{
    /**
     * The application implementation.
     *
     * @var \WpPluginner\Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The Artisan application instance.
     *
     * @var \WpPluginner\Illuminate\Console\Application
     */
    protected $artisan;

    /**
     * Indicates if facade aliases are enabled for the console.
     *
     * @var bool
     */
    protected $aliases = true;

    /**
     * The Artisan commands provided by the application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Create a new console kernel instance.
     *
     * @param  \WpPluginner\Lumen\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->app->prepareForConsoleCommand($this->aliases);

        $this->defineConsoleSchedule();
    }

    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function defineConsoleSchedule()
    {
        $this->app->instance(
            'WpPluginner\Illuminate\Console\Scheduling\Schedule', $schedule = new Schedule($this->app[Cache::class])
        );

        $this->schedule($schedule);
    }

    /**
     * Run the console application.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    public function handle($input, $output = null)
    {
        try {
            return $this->getArtisan()->run($input, $output);
        } catch (Exception $e) {
            $this->reportException($e);

            $this->renderException($output, $e);

            return 1;
        } catch (Throwable $e) {
            $e = new FatalThrowableError($e);

            $this->reportException($e);

            $this->renderException($output, $e);

            return 1;
        }
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \WpPluginner\Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }

    /**
     * Run an Artisan console command by name.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @return int
     */
    public function call($command, array $parameters = [])
    {
        return $this->getArtisan()->call($command, $parameters);
    }

    /**
     * Queue the given console command.
     *
     * @param  string  $command
     * @param  array   $parameters
     * @return void
     */
    public function queue($command, array $parameters = [])
    {
        throw new RuntimeException('Queueing Artisan commands is not supported by Lumen.');
    }

    /**
     * Get all of the commands registered with the console.
     *
     * @return array
     */
    public function all()
    {
        return $this->getArtisan()->all();
    }

    /**
     * Get the output for the last run command.
     *
     * @return string
     */
    public function output()
    {
        return $this->getArtisan()->output();
    }

    /**
     * Get the Artisan application instance.
     *
     * @return \WpPluginner\Illuminate\Console\Application
     */
    protected function getArtisan()
    {
        if (is_null($this->artisan)) {
            return $this->artisan = (new Artisan($this->app, $this->app->make('events'), $this->app->version()))
                                ->resolveCommands($this->getCommands());
        }

        return $this->artisan;
    }

    /**
     * Get the commands to add to the application.
     *
     * @return array
     */
    protected function getCommands()
    {
        return array_merge($this->commands, [
            'WpPluginner\Illuminate\Console\Scheduling\ScheduleRunCommand',
        ]);
    }

    /**
     * Report the exception to the exception handler.
     *
     * @param  \Exception  $e
     * @return void
     */
    protected function reportException(Exception $e)
    {
        $this->app['WpPluginner\Illuminate\Contracts\Debug\ExceptionHandler']->report($e);
    }

    /**
     * Report the exception to the exception handler.
     *
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @param  \Exception  $e
     * @return void
     */
    protected function renderException($output, Exception $e)
    {
        $this->app['WpPluginner\Illuminate\Contracts\Debug\ExceptionHandler']->renderForConsole($output, $e);
    }
}
