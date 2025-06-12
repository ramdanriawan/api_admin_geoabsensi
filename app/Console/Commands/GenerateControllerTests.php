<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use ReflectionClass;
use ReflectionMethod;

class GenerateControllerTests extends Command
{
    protected $signature = 'make:auto-tests';
    protected $description = 'Generate or update test files for all controllers';

    public function handle()
    {
        $controllerPath = app_path('Http/Controllers');
        $controllers = File::allFiles($controllerPath);

        foreach ($controllers as $file) {
            $className = $this->getFullClassName($file->getRealPath(), $controllerPath);

            if (!$className || !class_exists($className)) continue;

            $reflector = new ReflectionClass($className);
            if (!$reflector->isSubclassOf('App\Http\Controllers\Controller')) continue;

            $relativePath = str_replace(app_path('Http/Controllers') . '/', '', $file->getPath());
            $relativeNamespace = str_replace('/', '\\', $relativePath);
            $testDir = base_path('tests/Feature/' . $relativePath);
            $testClassName = $reflector->getShortName() . 'Test';
            $testFile = "$testDir/$testClassName.php";

            File::ensureDirectoryExists($testDir);

            if (!File::exists($testFile)) {
                File::put($testFile, $this->generateTestFile($reflector, $relativeNamespace));
                $this->info("✅ Created test: $testClassName");
            } else {
                $this->appendMissingMethods($testFile, $reflector);
            }
        }

        $this->info('✅ Test generation completed.');
    }

    protected function getFullClassName($filePath, $basePath)
    {
        $content = file_get_contents($filePath);

        if (preg_match('/^namespace\s+(.+?);/m', $content, $matches)) {
            $namespace = $matches[1];
        } else {
            return null;
        }

        $class = basename($filePath, '.php');
        return "$namespace\\$class";
    }

    protected function generateTestFile(ReflectionClass $class, $relativeNamespace = ''): string
    {
        $className = $class->getShortName();
        $testClass = $className . 'Test';
        $namespace = 'Tests\\Feature' . ($relativeNamespace ? '\\' . trim($relativeNamespace, '\\') : '');

        $methods = $this->generateAllTestMethods($class);

        return <<<EOT
<?php

namespace $namespace;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class $testClass extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        \$this->seed();
    }

$methods
}
EOT;
    }

    protected function generateAllTestMethods(ReflectionClass $class): string
    {
        $methods = '';
        foreach ($class->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->class === $class->getName() && !$method->isConstructor()) {
                $methods .= $this->generateTestMethod($method->getName()) . "\n";
            }
        }
        return $methods;
    }

    protected function generateTestMethod(string $name): string
    {
        return <<<EOT
    public function test_{$name}_works(): void
    {
        \$this->assertTrue(true); // TODO: test $name
    }
EOT;
    }

    protected function appendMissingMethods(string $testFile, ReflectionClass $controller)
    {
        $existing = file_get_contents($testFile);
        $missing = [];

        foreach ($controller->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->class === $controller->getName() && !$method->isConstructor()) {
                $testMethodName = "test_{$method->getName()}_works";
                if (!str_contains($existing, "function $testMethodName")) {
                    $missing[] = $this->generateTestMethod($method->getName());
                }
            }
        }

        if (!empty($missing)) {
            // Append missing methods before final closing bracket
            $updated = preg_replace(
                '/}\s*$/',
                "\n" . implode("\n", $missing) . "\n}",
                $existing
            );

            File::put($testFile, $updated);
            $this->info("🛠️ Updated: " . basename($testFile) . ' (+ ' . count($missing) . ' methods)');
        } else {
            $this->warn("⚠️ No updates needed: " . basename($testFile));
        }
    }
}
