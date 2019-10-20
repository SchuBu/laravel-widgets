<?php


namespace SchuBu\LaravelWidgets\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeWidget extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'make:widget {name : The name of the widget class} {template? : The name of your template file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new widget class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Widget';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new controller creator command instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating the widget ...');

        $files = $this->getStubs($this->getClassName(), $this->getBladeName());

        foreach ($files as $file) {
            $this->makeDirectory($file['path']);

            $tmp_path = $file['path'] . DIRECTORY_SEPARATOR . $file['to'];

            if (!$this->files->exists($tmp_path)) {
                $this->files->put($tmp_path, $this->replacement($this->files->get($file['from'])));
                $this->info('... File '.$tmp_path . " was created");
            } else {
                $this->error($tmp_path . " already exists!");
            }
        }
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param string $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
            $this->info('... Directory '.$path . " was created");
        }

        return $path;
    }

    /**
     * Get the name for the blade file
     *
     * @return string
     */
    protected function getBladeName()
    {
        return Str::kebab($this->argument('template') ?: $this->argument('name'));
    }

    /**
     * Generate the name for the class and class file
     *
     * @return array|string|null
     */
    protected function getClassName()
    {
        return $this->argument('name');
    }


    protected function replacement($subject)
    {
        return str_replace(
            ["DummyClassname", "DummyViewPath"],
            [$this->argument('name'),
                ($this->argument('template') ? "" : "//") . "protected \$viewPath = 'widgets." . $this->getBladeName() . "'; // use this property to change your path to the widget blade file"
            ],
            $subject);
    }

    /**
     * @param $classname
     * @param $bladename
     * @return array
     */
    protected function getStubs($classname, $bladename)
    {
        return [
            ["from" => __DIR__ . '/stubs/class.stub', "path" => "app" . DIRECTORY_SEPARATOR . "Http" . DIRECTORY_SEPARATOR . "Widgets", "to" => $classname . ".php"],
            ["from" => __DIR__ . '/stubs/blade.stub', "path" => "resources" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "widgets", "to" => $bladename . ".blade.php"],
        ];
    }


}
