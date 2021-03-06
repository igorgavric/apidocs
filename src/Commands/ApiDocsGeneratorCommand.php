<?php namespace Igorgavric\Apidocs\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Igorgavric\Apidocs\Commands\ApiDocsGenerator;

class ApiDocsGeneratorCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'apidocs:generate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generates API Documentation.';

	/**
	 * The console command description.
	 *
	 * @var DocsGenerator
	 */

	protected $generator;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(ApiDocsGenerator $generator)
	{
		parent::__construct();

		$this->generator = $generator;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

       $prefix = is_null($this->argument('prefix')) ? $this->ask('What is the API Prefix?  i.e. "api/v2"') : $this->argument('prefix');
       $this->info('Generating ' . $prefix . ' API Documentation.');

	   // generate the docs
	   $this->generator->make($prefix);

	   $dot_prefix = str_replace('/', '.', $prefix);

       $this->info('API Docs have been generated!');
       $this->info('');
       $this->info('Add the following Route to "app/routes.php" > ');

		// All done!
        $this->info(sprintf(
            "\n %s" . PHP_EOL,
            "Route::get('docs', function(){
            	return View::make('docs." . $dot_prefix . ".index');
            });"
        ));
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('prefix', InputArgument::OPTIONAL, 'Api Prefix (i.e. "api/v2"'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	// protected function getOptions()
	// {
	// 	return array(
	// 		array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
	// 	);
	// }

}
