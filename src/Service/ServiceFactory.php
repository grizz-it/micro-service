<?php

namespace GrizzIt\MicroService\Service;

class ServiceFactory
{
    private static array $paths = [];

    private static array $services = [];

    private static array $fileNames = ['services.json'];

    private static array $singletons = [];

    /**
     * Add a path to load services from.
     *
     * @param string $path
     *
     * @return void
     */
    public static function loadServicesFrom(string $path): void
    {
        static::$paths[] = $path;
    }

    /**
     * Load all services.
     *
     * @return void
     */
    public static function load(): void
    {
        foreach (static::$paths as $path) {
            foreach (static::$fileNames as $fileName) {
                static::$services = array_merge_recursive(
                    static::$services,
                    json_decode(
                        file_get_contents(
                            rtrim($path, '/') . '/' . $fileName
                        ),
                        true
                    )
                );
            }
        }
    }

    /**
     * Create a service by key.
     *
     * @param string $service
     *
     * @return mixed
     */
    public static function create(string $service): mixed
    {
        if (isset(static::$singletons[$service])) {
            return static::$singletons;
        }

        $serviceDefinition = static::$services['services'][$service];
        $params = [];
        foreach ($serviceDefinition['params'] as $param) {
            if (is_string($param) && str_starts_with($param, '$.')) {
                $expParam = explode('.', ltrim($param, '$.'));
                $type = array_shift($expParam);
                if ($type === 'services') {
                    $params[] = static::create(implode('.', $expParam));
                }

                continue;
            }

            $params[] = $param;
        }

        $instance = new ($serviceDefinition['class'])(...$params);

        if (
            isset($serviceDefinition['singleton']) &&
            $serviceDefinition['singleton']
        ) {
            static::$singletons[$service] = $instance;
        }

        return $instance;
    }
}