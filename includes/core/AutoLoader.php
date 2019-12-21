<?php
namespace Wp\Core;


class AutoLoader
{
    /**
     * @var null
     */
    protected static $instance=null;
    /**
     * @var Exceptions|null
     */
    protected $exception = null;

    /**
     * Class map array
     * @var array
     */
    protected $classMap = [];
    /**
     * Class map from array/directory
     * @var array
     */
    protected $classMapFrom = [];

    /**
     * Files
     * @var array
     */
    protected $files = [];

private function __construct($path=array())
{
     $this->register();

     if(is_array($path)){
       foreach ($path as $f){
         if(is_file($f))$this->addClassMapFromFile($f);
         else if(is_dir($f))$this->addClassMapFromDir($f);
       }
     }else{
         if(is_file((string)$path))$this->addClassMapFromFile((string)$path);
         else if(is_dir((string)$path))$this->addClassMapFromDir($path);
     }
    $this->loadAllFiles();
    $this->exception = Exceptions::getInstance();
    return $this;
}

public static function getInstance($path=array())
{
    if (null === self::$instance) {
        self::$instance = new self($path);
    }
    return self::$instance;
}

    /**
     * Register this instance with the autoload stack
     *
     * @return AutoLoader
     */
    public function register()
    {
        spl_autoload_register($this, TRUE, FALSE);
        return $this;
    }

    /**
     * Unregister this instance with the autoload stack
     *
     * @return AutoLoader
     */
    public function unregister()
    {
        spl_autoload_unregister($this);
        return $this;
    }

    /**
     * Get the class map array
     *
     * @return array
     */
    public function getClassMap()
    {
        return $this->classMap;
    }

    /**
     * Add a class map array
     *
     * @param  array $map
     * @return AutoLoader
     */
    public function addClassMap($map)
    {
        if (!is_array($map)) {
            $this->exception->show('Error: The $map parameter must be array.');
        }
        if(count(array_keys($map))<=0){
            $this->exception->show('Error: The $map parameter must be associative array.');
        }

        $this->classMap = array_merge($this->classMap, $map);
        return $this;
    }

    /**
     * Add a class map array
     *
     * @param string $prefix
     * @param string $class
     * @param string $path
     * @return AutoLoader
     */
    public function addToClassMap($prefix='',$class='',$path='')
    {
        if (''===(string) $class) {
            $this->exception->show('Error: The $class parameter must be setup.');
        }

        if (''===(string) $path) {
            $this->exception->show('Error: The $path parameter must be setup.');
        }

        $this->classMap[(string)($prefix).$class] = $path;
        return $this;
    }

    /**
     * Clear sources
     *
     * @return AutoLoader
     */
    public function removeClassMap()
    {
        $this->classMap = [];
        return $this;
    }

    /**
     * @param string $prefix
     * @param string $class
     * @return $this
     */
    public function removeFromClassMap($prefix='',$class='')
    {
        if (''===(string) $class) {
            $this->exception->show('Error: The $class parameter must be setup.');
        }
        unset($this->classMap[(string)($prefix).$class]);
        return $this;
    }

    /**
     * Get sources
     *
     * @return array
     */
    public function getMapDirectory()
    {
        return $this->classMapFrom;
    }
    /**
     * Determine if a source directory has been added
     *
     * @param $path
     * @return boolean
     */
    public function hasMapDirectory($path)
    {
        return in_array($path, $this->classMapFrom);
    }
    /**
     * Clear sources
     *
     * @return AutoLoader
     */
    public function removeMapDirectory()
    {
        $this->classMapFrom = [];
        return $this;
    }
    /**
     * Add source directory or directories
     *
     * @param $directory
     * @return AutoLoader
     */
    public function addMapDirectory($directory)
    {
        if (!is_array($directory)) {
            $source = [$directory];
        }else $source = $directory;

        foreach ($source as $src) {
            if (!is_dir((string)$src)) {
                $this->exception->show('Error! That source "{$src}" folder does not exist.');
            }
            if (!$this->hasMapDirectory((string)$src)) {
                $this->classMapFrom[] = (string)$src;
            }
        }
        return $this;
    }


    /**
     * Get sources
     *
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Determine if a source directory has been added
     *
     * @param $path
     * @return boolean
     */
    public function hasFiles($path)
    {
        return in_array($path, $this->files);
    }

    /**
     * Add source directory or directories
     *
     * @param $directory
     * @return AutoLoader
     */
    public function addFiles($file_path)
    {
        if (!is_array($file_path)) {
            $source = [$file_path];
        }else $source = $file_path;

        foreach ($source as $src) {
            if (!file_exists($src)) {
                $this->exception->show('Error: That source "{$src}" folder does not exist.');
            }
            if (!$this->hasFiles($src)) {
                $this->files[] = $src;
            }
        }

        return $this;
    }
    /**
     * Generate a class map
     *
     * @return array
     */
    public function generateClassMap()
    {
        $newClassMap=[];
        $class             = '';
        $namespace         = '';
        $this->discoverFiles();

        foreach ($this->files as $file)
        {
            $classMatch        = [];
            $namespaceMatch    = [];
            $classFileContents = file_get_contents($file);

            preg_match('/^(final|abstract|interface|class)(.*)$/m', $classFileContents, $classMatch);
            preg_match('/^namespace(.*)$/m', $classFileContents, $namespaceMatch);

            if (isset($classMatch[0])) {
                $class = $classMatch[2];
                if ($classMatch[1] === 'abstract') {
                    $class = str_replace('class', '', $classMatch[2]);
                } else if ($classMatch[1] === 'final') {
                    $class = str_replace('class', '', $classMatch[2]);
                }

                $class = trim($class);

                if (strpos($class, ' ') !== false) {
                    $class = substr($class, 0, strpos($class, ' '));
                }

                $class = trim($class);

                if (isset($namespaceMatch[0])) {
                    $namespace = trim($namespaceMatch[1]);
                    $namespace = trim(str_replace(';', '', $namespace));
                }

                $newClassMap[$namespace. '\\' . $class] = str_replace('\\', '/', $file);
            }else{
                $class=substr($file,strrpos($file,'\\',-1)+1,stripos($file,'.php')-strrpos($file,'\\')-1);
                $newClassMap[$class] = str_replace('\\', '/', $file);
            }
        }
        return $newClassMap;
    }

    /**
     * Write a class map to an output file
     *
     * @param  string $output
     * @return AutoLoader
     */
    public function writeToFile($output)
    {
        $code = '<?php' . PHP_EOL . PHP_EOL . 'return [';

        $i = 1;
        foreach ($this->classMap as $class => $file) {
            $comma = ($i < count($this->classMap)) ? ',' : null;
            $code .= PHP_EOL . '    \'' . $class . '\' => \'' . $file . '\'' . $comma;
            $i++;
        }

        $code .= PHP_EOL . '];' . PHP_EOL;

        file_put_contents($output, $code);

        return $this;
    }

    /**
     * Discover files from source directory
     *
     * @return void
     */
    protected function discoverFiles()
    {
        foreach ($this->classMapFrom as $source) {
            $objects = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($source), \RecursiveIteratorIterator::SELF_FIRST
            );
            foreach ($objects as $fileInfo) {
                if (($fileInfo->getFilename() != '.') && ($fileInfo->getFilename() != '..')) {
                    $f = null;
                    if (!$fileInfo->isDir()) {
                        $f = realpath($fileInfo->getPathname());
                    }
                    if (($f !== false) && (null !== $f) && (substr(strtolower($f), -4) == '.php')) {
                        $this->addFiles($f);
                    }
                }
            }
        }
    }

    /**
     * Add a class map from file
     *
     * @param string $file
     * @return AutoLoader
     */
    public function addClassMapFromFile($file)
    {
        if (!file_exists($file)) {
            $this->exception->show('That class map file does not exist.');
        }

        $classMap = require_once $file;

        return $this->addClassMap($classMap);
    }

    /**
     * Generate and add a class map from directory
     *
     * @param string/array $dir
     * @return AutoLoader
     */
    public function addClassMapFromDir($dir)
    {
        if(is_array($dir)){
            foreach ($dir as $path){
                if (!file_exists($path)) {
                    $this->exception->show('That class map directory does not exist.');
                }
                $this->addMapDirectory($path);
            }
        }else{
            if (!file_exists($dir)) {
                $this->exception->show('That class map directory does not exist.');
            }
            $this->addMapDirectory($dir);
        }

        $classMap = $this->generateClassMap();
        return $this->addClassMap($classMap);
    }

    /**
     * Find the class file
     *
     * @param  string $class
     * @return mixed
     */
    public function findFile($class)
    {
        // Check the class map for the class
        if (array_key_exists($class, $this->classMap)) {
            return realpath($this->classMap[$class]);
        }
        return false;
    }

    /**
     * Find and load the class file
     *
     * @param  string $class
     * @return boolean
     */
    public function loadClass($class)
    {
        $classFile = $this->findFile($class);
        if ($classFile !== false) {
            require_once $classFile;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $class
     */
    public function loadFile($class)
    {
      $this->loadClass($class);
    }

    /**
     * @param array $group
     */
    public function loadGroupFiles($group)
    {
        foreach ( $group as $inc)
        {
            $this->loadClass($inc);
        }
    }

    /**
     *
     */
    public function loadAllFiles()
    {
        foreach ( array_keys($this->getClassMap()) as $inc)
        {
            $this->loadClass($inc);
        }
    }

    /**
     * Invoke the class
     *
     * @return void
     */
    public function __invoke(){}
}

