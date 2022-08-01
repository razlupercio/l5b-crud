<?php

namespace pqrs\L5BCrud\Console\Commands;

use Symfony\Component\Console\Input\InputArgument;

use Artisan;
use Illuminate\Console\Command;

class L5BCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'l5b:crud {name} {--m|migrate} {--s|namespace=} {--f|field=title} {--frontend} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a complete CRUD structure for Laravel 5 Boilerplate Backend';

    public $doforce;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // Transform l5b:crud command parameter to singular lowercase
        $name = strtolower(snake_case(str_singular($this->argument('name'))));

        if (!$this->option('namespace')) {
            // Create Model "Name.php"
            $this->model($name, ucfirst(camel_case($name)), 'make-model.stub');

            // Create Attribute Trait "NameAttribute.php"
            $this->attribute($name, ucfirst(camel_case($name)) . "Attribute", 'make-attribute.stub');

            // Create Controller "NameController.php"
            $this->controller($name, ucfirst(camel_case($name)) . "Controller", 'make-controller.stub');

            // Create Repository "NameRepository.php"
            $this->repository($name, ucfirst(camel_case($name)) . "Repository", 'make-repository.stub');

            // Create Validation Request "ManageNameRequest.php"
            // Create Validation Request "StoreNameRequest.php"
            // Create Validation Request "UpdateNameRequest.php"
            $this->request($name, "Manage" . ucfirst(camel_case($name)) . "Request", 'make-manage-request.stub');
            $this->request($name, "Store"  . ucfirst(camel_case($name)) . "Request", 'make-store-request.stub');
            $this->request($name, "Update" . ucfirst(camel_case($name)) . "Request", 'make-update-request.stub');

            // Create Event "Events/Backend/Example/ExampleCreated.php"
            // Create Event "Events/Backend/Example/ExampleUpdated.php"
            // Create Event "Events/Backend/Example/ExampleDeleted.php"
            $this->event($name, ucfirst(camel_case($name)) . "Created", 'make-event-created.stub');
            $this->event($name, ucfirst(camel_case($name)) . "Updated", 'make-event-updated.stub');
            $this->event($name, ucfirst(camel_case($name)) . "Deleted", 'make-event-deleted.stub');

            // Create Listener "Listeners/Backend/Example/ExampleEventListener.php"
            $this->listener($name, ucfirst(camel_case($name)) . "EventListener", 'make-listener.stub');

            // Create Migration "YYYY_MM_DD_HHMMSS_create_names_table.php"
            $this->migration($name, date('Y_m_d_His_') . "create_" . str_plural($name) . "_table", 'make-migration.stub');

            // Create Routes "names.php"
            $this->routes($name, str_plural($name), 'make-routes.stub');

            // Create Breadcrumbs "names.php"
            $this->breadcrumbs($name, $name, 'make-breadcrumbs.stub');

            // Create View "name/index.blade.php"
            // Create View "example/create.blade.php"
            // Create View "example/edit.blade.php"
            // Create View "example/show.blade.php"
            // Create View "example/deleted.blade.php"
            // Create View "example/includes/breadcrumb-links.blade.php"
            // Create View "example/includes/header-buttons.blade.php"
            // Create View "example/includes/sidebar-examples.blade.php"
            $this->view($name, 'index', 'make-views-index.stub');
            $this->view($name, 'create', 'make-views-create.stub');
            $this->view($name, 'edit', 'make-views-edit.stub');
            $this->view($name, 'show', 'make-views-show.stub');
            $this->view($name, 'deleted', 'make-views-deleted.stub');
            $this->view($name, '/includes/breadcrumb-links', 'make-views-breadcrumb-links.stub');
            $this->view($name, '/includes/header-buttons', 'make-views-header-buttons.stub');
            $this->view($name, '/includes/sidebar-' . str_plural($name), 'make-views-sidebar.stub');

            $this->label($name, $name, 'make-backend-labels.stub');

            if ($this->option('frontend')) {
                $this->frontend_controller($name, ucfirst(camel_case($name)) . "Controller", 'make-frontend-controller.stub');
                $this->frontend_repository($name, ucfirst(camel_case($name)) . "Repository", 'make-frontend-repository.stub');

                $this->frontend_request($name, "Manage" . ucfirst(camel_case($name)) . "Request", 'make-frontend-manage-request.stub');
                $this->frontend_request($name, "Store"  . ucfirst(camel_case($name)) . "Request", 'make-frontend-store-request.stub');
                $this->frontend_request($name, "Update" . ucfirst(camel_case($name)) . "Request", 'make-frontend-update-request.stub');

                $this->frontend_event($name, ucfirst(camel_case($name)) . "Created", 'make-frontend-event-created.stub');
                $this->frontend_event($name, ucfirst(camel_case($name)) . "Updated", 'make-frontend-event-updated.stub');
                $this->frontend_event($name, ucfirst(camel_case($name)) . "Deleted", 'make-frontend-event-deleted.stub');

                $this->frontend_listener($name, ucfirst(camel_case($name)) . "EventListener", 'make-frontend-listener.stub');

                $this->frontend_routes($name, str_plural($name), 'make-frontend-routes.stub');

                $this->frontend_view($name, 'index', 'make-frontend-views-index.stub');
                $this->frontend_view($name, 'create', 'make-frontend-views-create.stub');
                $this->frontend_view($name, 'edit', 'make-frontend-views-edit.stub');
                $this->frontend_view($name, 'show', 'make-frontend-views-show.stub');
                $this->frontend_view($name, 'deleted', 'make-frontend-views-deleted.stub');
                $this->frontend_view($name, '/includes/header-buttons', 'make-frontend-views-header-buttons.stub');

                $this->frontend_label($name, $name, 'make-frontend-labels.stub');
            }
        }
        if ($this->option('namespace')) {
            $namespace = ucfirst($this->option('namespace'));

            // Create Model "Name.php"
            $this->model($name, ucfirst(camel_case($name)), 'make-ns-model.stub', $namespace);

            // Create Attribute Trait "NameAttribute.php"
            $this->attribute($name, ucfirst(camel_case($name)) . "Attribute", 'make-ns-attribute.stub', $namespace);

            // Create Controller "NameController.php"
            $this->controller($name, ucfirst(camel_case($name)) . "Controller", 'make-ns-controller.stub', $namespace);

            // Create Repository "NameRepository.php"
            $this->repository($name, ucfirst(camel_case($name)) . "Repository", 'make-ns-repository.stub', $namespace);

            // Create Validation Request "ManageNameRequest.php"
            // Create Validation Request "StoreNameRequest.php"
            // Create Validation Request "UpdateNameRequest.php"
            $this->request($name, "Manage" . ucfirst(camel_case($name)) . "Request", 'make-ns-manage-request.stub', $namespace);
            $this->request($name, "Store"  . ucfirst(camel_case($name)) . "Request", 'make-ns-store-request.stub', $namespace);
            $this->request($name, "Update" . ucfirst(camel_case($name)) . "Request", 'make-ns-update-request.stub', $namespace);

            // Create Event "Events/Backend/Example/ExampleCreated.php"
            // Create Event "Events/Backend/Example/ExampleUpdated.php"
            // Create Event "Events/Backend/Example/ExampleDeleted.php"
            $this->event($name, ucfirst(camel_case($name)) . "Created", 'make-ns-event-created.stub', $namespace);
            $this->event($name, ucfirst(camel_case($name)) . "Updated", 'make-ns-event-updated.stub', $namespace);
            $this->event($name, ucfirst(camel_case($name)) . "Deleted", 'make-ns-event-deleted.stub', $namespace);

            // Create Listener "Listeners/Backend/Example/ExampleEventListener.php"
            $this->listener($name, ucfirst(camel_case($name)) . "EventListener", 'make-ns-listener.stub', $namespace);

            // Create Migration "YYYY_MM_DD_HHMMSS_create_names_table.php"
            $this->migration($name, date('Y_m_d_His_') . "create_" . str_plural($name) . "_table", 'make-ns-migration.stub', $namespace);

            // Create Routes "names.php"
            $this->routes($name, str_plural($name), 'make-ns-routes.stub', $namespace);

            // Create Breadcrumbs "names.php"
            $this->breadcrumbs($name, $name, 'make-ns-breadcrumbs.stub', $namespace);

            // Create View "name/index.blade.php"
            // Create View "example/create.blade.php"
            // Create View "example/edit.blade.php"
            // Create View "example/show.blade.php"
            // Create View "example/deleted.blade.php"
            // Create View "example/includes/breadcrumb-links.blade.php"
            // Create View "example/includes/header-buttons.blade.php"
            // Create View "example/includes/sidebar-examples.blade.php"
            $this->view($name, 'index', 'make-ns-views-index.stub', $namespace);
            $this->view($name, 'create', 'make-ns-views-create.stub', $namespace);
            $this->view($name, 'edit', 'make-ns-views-edit.stub', $namespace);
            $this->view($name, 'show', 'make-ns-views-show.stub', $namespace);
            $this->view($name, 'deleted', 'make-ns-views-deleted.stub', $namespace);
            $this->view($name, '/includes/breadcrumb-links', 'make-ns-views-breadcrumb-links.stub', $namespace);
            $this->view($name, '/includes/header-buttons', 'make-ns-views-header-buttons.stub', $namespace);
            $this->view($name, '/includes/sidebar-' . str_plural($name), 'make-ns-views-sidebar.stub', $namespace);

            $this->label($name, $name, 'make-ns-backend-labels.stub', $namespace);

            if ($this->option('frontend')) {
                $this->frontend_controller($name, ucfirst(camel_case($name)) . "Controller", 'make-ns-frontend-controller.stub', $namespace);
                $this->frontend_repository($name, ucfirst(camel_case($name)) . "Repository", 'make-ns-frontend-repository.stub', $namespace);

                $this->frontend_request($name, "Manage" . ucfirst(camel_case($name)) . "Request", 'make-ns-frontend-manage-request.stub', $namespace);
                $this->frontend_request($name, "Store"  . ucfirst(camel_case($name)) . "Request", 'make-ns-frontend-store-request.stub', $namespace);
                $this->frontend_request($name, "Update" . ucfirst(camel_case($name)) . "Request", 'make-ns-frontend-update-request.stub', $namespace);

                $this->frontend_event($name, ucfirst(camel_case($name)) . "Created", 'make-ns-frontend-event-created.stub', $namespace);
                $this->frontend_event($name, ucfirst(camel_case($name)) . "Updated", 'make-ns-frontend-event-updated.stub', $namespace);
                $this->frontend_event($name, ucfirst(camel_case($name)) . "Deleted", 'make-ns-frontend-event-deleted.stub', $namespace);

                $this->frontend_listener($name, ucfirst(camel_case($name)) . "EventListener", 'make-ns-frontend-listener.stub', $namespace);

                $this->frontend_routes($name, str_plural($name), 'make-ns-frontend-routes.stub', $namespace);

                $this->frontend_view($name, 'index', 'make-ns-frontend-views-index.stub', $namespace);
                $this->frontend_view($name, 'create', 'make-ns-frontend-views-create.stub', $namespace);
                $this->frontend_view($name, 'edit', 'make-ns-frontend-views-edit.stub', $namespace);
                $this->frontend_view($name, 'show', 'make-ns-frontend-views-show.stub', $namespace);
                $this->frontend_view($name, 'deleted', 'make-ns-frontend-views-deleted.stub', $namespace);
                $this->frontend_view($name, '/includes/header-buttons', 'make-ns-frontend-views-header-buttons.stub', $namespace);

                $this->frontend_label($name, $name, 'make-ns-frontend-labels.stub', $namespace);
            }
        }
    }

    protected function model($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'              => $name,
            'ns'                => ucfirst($namespace),
            'stub'              => __DIR__ . '/Stubs/' . $stub,
            'namespace'         => '\Models' . ($namespace ? '\\' . ucfirst($namespace) : ''),
            'attribute'         => ucfirst(camel_case($key)) . "Attribute",
            'field'             => $this->option('field'),
            'model'             => ucfirst(camel_case($key)),
            '--force'           => $this->hasOption('force') ? $this->option('force') : false,
        ];

        Artisan::call('l5b:stub', $stubParams);
        $this->line('Model ' . $stubParams['name'] . Artisan::output());
    }

    protected function event($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'              => $name,
            'ns'                => ucfirst($namespace),
            'stub'              => __DIR__ . '/Stubs/' . $stub,
            'namespace'         => '\Events\Backend\\' . ($namespace ? ucfirst($namespace) . '\\' . ucfirst(camel_case($key)) : ucfirst(camel_case($key))),
            'event'             => ucfirst(camel_case($key)),
            'model'             => ucfirst(camel_case($key)),
            'table'             =>  str_plural($key),
            'field'             => $this->option('field'),
            '--force'           => $this->hasOption('force') ? $this->option('force') : false,
        ];

        Artisan::call('l5b:stub', $stubParams);
        $this->line('Event ' . $stubParams['name'] . Artisan::output());
    }

    protected function listener($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'              => $name,
            'ns'                => ucfirst($namespace),
            'stub'              => __DIR__ . '/Stubs/' . $stub,
            'namespace'         => '\Listeners\Backend\\' . ($namespace ? ucfirst($namespace) . '\\' . ucfirst(camel_case($key)) : ucfirst(camel_case($key))),
            'event'             => ucfirst(camel_case($key)),
            'field'             => $this->option('field'),
            'model'             => ucfirst(camel_case($key)),
            'table'             => $key,
            '--force'           => $this->hasOption('force') ? $this->option('force') : false,
        ];

        Artisan::call('l5b:stub', $stubParams);
        $this->line('Listener ' . $stubParams['name'] . Artisan::output());
    }

    protected function attribute($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'              => $name,
            'ns'                => ucfirst($namespace),
            'stub'              => __DIR__ . '/Stubs/' . $stub,
            'namespace'         => '\Models\Traits\Attribute' . ($namespace ? '\\' . ucfirst($namespace) : ''),
            'attribute'         => ucfirst(camel_case($key)) . "Attribute",
            'route'             => ($namespace ? str_plural(strtolower($namespace)) . '.' . str_plural($key) : str_plural($key)),
            'label'             => str_plural($key),
            '--force'           => $this->hasOption('force') ? $this->option('force') : false,
        ];

        Artisan::call('l5b:stub', $stubParams);
        $this->line('Attribute ' . $stubParams['name'] . Artisan::output());
    }

    protected function controller($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'                  => $name,
            'ns'                    => ucfirst($namespace),
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'namespace'             => '\Http\Controllers\Backend' . ($namespace ? '\\' . ucfirst($namespace) : ''),
            'array'                 => camel_case(str_plural($key)),
            'controller'            => ucfirst(camel_case($key)) . "Controller",
            'field'                 => $this->option('field'),
            'label'                 => str_plural($key),
            'model'                 => ucfirst(camel_case($key)),
            'repository'            => ucfirst(camel_case($key)) . "Repository",
            'repositoryVariable'    => $key . "Repository",
            'request'               => ucfirst(camel_case($key)) . "Request",
            'route'                 => ($namespace ? str_plural(strtolower($namespace)) . '.' . str_plural($key) : str_plural($key)),
            'variable'              => camel_case($key),
            'view'                  => ($namespace ? strtolower($namespace) . '.' . $key : $key),
            '--force'               => $this->hasOption('force') ? $this->option('force') : false,
        ];

        Artisan::call('l5b:stub', $stubParams);
        $this->line('Controller ' . $stubParams['name'] . Artisan::output());
    }

    protected function repository($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'                  => $name,
            'ns'                => ucfirst($namespace),
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'field'                 => $this->option('field'),
            'namespace'             => '\Repositories\Backend' . ($namespace ? '\\' . ucfirst($namespace) : ''),
            'model'                 => ucfirst(camel_case($key)),
            'repository'            => ucfirst(camel_case($key)) . "Repository",
            'variable'              => $key,
            'label'                 => str_plural($key),
            '--force'           => $this->hasOption('force') ? $this->option('force') : false,
        ];

        Artisan::call('l5b:stub', $stubParams);
        $this->line('Repository ' . $stubParams['name'] . Artisan::output());
    }

    protected function request($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'                  => $name,
            'ns'                    => ucfirst($namespace),
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'field'                 => $this->option('field'),
            'namespace'             => '\Http\Requests\Backend\\' . ($namespace ? ucfirst($namespace) . '\\' . ucfirst(camel_case($key)) : ucfirst(camel_case($key))),
            'model'                 => ucfirst(camel_case($key)),
            '--force'               => $this->hasOption('force') ? $this->option('force') : false,
        ];

        Artisan::call('l5b:stub', $stubParams);
        $this->line('Request ' . $stubParams['name'] . Artisan::output());
    }

    protected function migration($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'                  => $name,
            'ns'                => ucfirst($namespace),
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'field'                 => $this->option('field'),
            'namespace'             => '\..\database\migrations',
            'class'                 => "Create" . ucfirst(str_plural(camel_case($key))) . "Table",
            'table'                 => str_plural($key),
            '--force'           => $this->hasOption('force') ? $this->option('force') : false,
        ];

        // If no migration with name "*create_names_table.php" exists then create it
        if (!glob(database_path() . "/migrations/*create_" . str_plural($key) . "_table.php")) {
            Artisan::call('l5b:stub', $stubParams);
            $this->line('Migration ' . $stubParams['name'] . Artisan::output());
        } else {
            $this->line('A migration file for the table ' . str_plural($key) . " already exists!\n");
        }

        // If option -m|--migrate is true then migrate the table
        if ($this->option('migrate')) {
            Artisan::call('migrate');
            $this->line('Migrating table ' . $stubParams['name'] . "\n");
        }
    }

    protected function routes($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'                  => $name,
            'ns'                => ucfirst($namespace),
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'namespace'             => '\..\routes\backend' . ($namespace ? '\\' . strtolower($namespace) : ''),
            'controller'            => ucfirst(camel_case($key)) . "Controller",
            'model'                 => ucfirst(camel_case($key)),
            'route'                 => ($namespace ? str_plural(strtolower($namespace)) . '.' . str_plural($key) : str_plural($key)),
            'url'                   => ($namespace ? str_plural(strtolower($namespace)) . '/' . str_plural($key) : str_plural($key)),
            'variable'              => $key,
            '--force'           => $this->hasOption('force') ? $this->option('force') : false,
        ];

        Artisan::call('l5b:stub', $stubParams);
        $this->line('Routes ' . $stubParams['name'] . Artisan::output());
    }

    protected function breadcrumbs($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'                  => $name,
            'ns'                    => str_plural(strtolower($namespace)),
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'label'                 => str_plural($key),
            'namespace'             => '\..\routes\breadcrumbs\backend' . ($namespace ? '\\' . strtolower($namespace) : ''),
            'route'                 => ($namespace ? str_plural(strtolower($namespace)) . '.' . str_plural($key) : str_plural($key)),
            '--force'               => $this->hasOption('force') ? $this->option('force') : false,
        ];

        Artisan::call('l5b:stub', $stubParams);
        $this->line('Breadcrumbs ' . $stubParams['name'] . Artisan::output());

        // Include breadcrumb file in backend.php
        $require_breadcrumb = "require __DIR__.'/" . ($namespace ? strtolower($namespace) . "/$name.php';" : "$name.php';");

        $backend_path = base_path("routes/breadcrumbs/backend/backend.php");

        $breadcrumbs = explode("\n", file_get_contents($backend_path));

        if (!in_array($require_breadcrumb, $breadcrumbs)) {
            $myfile = file_put_contents($backend_path, PHP_EOL . $require_breadcrumb, FILE_APPEND | LOCK_EX);
        }
    }

    protected function view($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'                  => $name . ".blade",
            'ns'                => ucfirst($namespace),
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'namespace'             => '\..\resources\views\backend' . '\\' . ($namespace ? strtolower($namespace) . '\\' . $key : $key),
            'label'                 => str_plural($key),
            'array'                 => camel_case(str_plural($key)),
            'field'                 => $this->option('field'),
            'route'                 => ($namespace ? str_plural(strtolower($namespace)) . '.' . str_plural($key) : str_plural($key)),
            'url'                   => ($namespace ? str_plural(strtolower($namespace)) . '/' . str_plural($key) : str_plural($key)),
            'variable'              => camel_case($key),
            'view'                  => ($namespace ? strtolower($namespace) . '.' . $key : $key),
            '--force'           => $this->hasOption('force') ? $this->option('force') : false,
        ];

        Artisan::call('l5b:stub', $stubParams);
        $this->line('View ' . $stubParams['name'] . Artisan::output());
    }

    protected function label($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'                  => 'backend_' . str_plural($name),
            'ns'                    => ucfirst($namespace),
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'namespace'             => '\..\resources\lang\en\\',
            'label'                 => str_plural($key),
            'array'                 => camel_case(str_plural($key)),
            'field'                 => $this->option('field'),
            'route'                 => str_plural($key),
            'variable'              => camel_case($key),
            'view'                  => ($namespace ? strtolower($namespace) . '.' . $key : $key),
            'model'                 => ucfirst(camel_case($key)),
            '--force'               => $this->hasOption('force') ? $this->option('force') : false,
        ];

        Artisan::call('l5b:stub', $stubParams);
        $this->line('Label ' . $stubParams['name'] . Artisan::output());
    }

    /*
     *  Frontend
     */
    protected function frontend_controller($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'                  => $name,
            'ns'                    => ucfirst($namespace),
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'namespace'             => '\Http\Controllers\Frontend' . ($namespace ? '\\' . ucfirst($namespace) : ''),
            'array'                 => camel_case(str_plural($key)),
            'controller'            => ucfirst(camel_case($key)) . "Controller",
            'field'                 => $this->option('field'),
            'label'                 => str_plural($key),
            'model'                 => ucfirst(camel_case($key)),
            'repository'            => ucfirst(camel_case($key)) . "Repository",
            'repositoryVariable'    => $key . "Repository",
            'request'               => ucfirst(camel_case($key)) . "Request",
            'route'                 => ($namespace ? str_plural(strtolower($namespace)) . '.' . str_plural($key) : str_plural($key)),
            'variable'              => camel_case($key),
            'view'                  => ($namespace ? strtolower($namespace) . '.' . $key : $key),
            '--force'               => $this->hasOption('force') ? $this->option('force') : false,
        ];

        Artisan::call('l5b:stub', $stubParams);
        $this->line('Controller ' . $stubParams['name'] . Artisan::output());
    }

    protected function frontend_event($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'              => $name,
            'ns'                => ucfirst($namespace),
            'stub'              => __DIR__ . '/Stubs/' . $stub,
            'namespace'         => '\Events\Frontend\\' . ($namespace ? ucfirst($namespace) . '\\' . ucfirst(camel_case($key)) : ucfirst(camel_case($key))),
            'event'             => ucfirst(camel_case($key)),
            'model'             => ucfirst(camel_case($key)),
            'table'             => str_plural($key),
            'field'             => $this->option('field'),
            '--force'           => $this->hasOption('force') ? $this->option('force') : false,
        ];


        Artisan::call('l5b:stub', $stubParams);
        $this->line('Event ' . $stubParams['name'] . Artisan::output());
    }

    protected function frontend_listener($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'              => $name,
            'ns'                => ucfirst($namespace),
            'stub'              => __DIR__ . '/Stubs/' . $stub,
            'namespace'         => '\Listeners\Frontend\\' . ($namespace ? ucfirst($namespace) . '\\' . ucfirst(camel_case($key)) : ucfirst(camel_case($key))),
            'event'             => ucfirst(camel_case($key)),
            'field'             => $this->option('field'),
            'model'             => ucfirst(camel_case($key)),
            'table'             => $key,
            '--force'           => $this->hasOption('force') ? $this->option('force') : false,
        ];

        Artisan::call('l5b:stub', $stubParams);
        $this->line('Listener ' . $stubParams['name'] . Artisan::output());
    }

    protected function frontend_repository($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'                  => $name,
            'ns'                => ucfirst($namespace),
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'field'                 => $this->option('field'),
            'namespace'             => '\Repositories\Frontend\\' . ($namespace ? ucfirst($namespace) . '\\' . ucfirst(camel_case($key)) : ucfirst(camel_case($key))),
            'model'                 => ucfirst(camel_case($key)),
            'repository'            => ucfirst(camel_case($key)) . "Repository",
            'variable'              => $key,
            'label'                 => str_plural($key),
            '--force'           => $this->hasOption('force') ? $this->option('force') : false,
        ];

        Artisan::call('l5b:stub', $stubParams);
        $this->line('Repository ' . $stubParams['name'] . Artisan::output());
    }

    protected function frontend_request($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'                  => $name,
            'ns'                    => ucfirst($namespace),
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'field'                 => $this->option('field'),
            'namespace'             => '\Http\Requests\Frontend\\' . ($namespace ? ucfirst($namespace) . '\\' . ucfirst(camel_case($key)) : ucfirst(camel_case($key))),
            'model'                 => ucfirst(camel_case($key)),
            '--force'               => $this->hasOption('force') ? $this->option('force') : false,
        ];

        Artisan::call('l5b:stub', $stubParams);
        $this->line('Request ' . $stubParams['name'] . Artisan::output());
    }
    protected function frontend_routes($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'                  => str_replace('_', '', $name),
            'ns'                    => ucfirst($namespace),
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'namespace'             => '\..\routes\frontend' . ($namespace ? '\\' . strtolower($namespace) : ''),
            'controller'            => ucfirst(camel_case($key)) . "Controller",
            'model'                 => ucfirst(camel_case($key)),
            'route'                 => ($namespace ? str_plural(strtolower($namespace)) . '.' . str_plural($key) : str_plural($key)),
            'url'                   => ($namespace ? str_plural(strtolower($namespace)) . '/' . str_plural($key) : str_plural($key)),
            'variable'              => $key,
            '--force'               => $this->hasOption('force') ? $this->option('force') : false,
        ];

        Artisan::call('l5b:stub', $stubParams);
        $this->line('Routes ' . $stubParams['name'] . Artisan::output());
    }

    protected function frontend_view($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'                  => $name . ".blade",
            'ns'                => ucfirst($namespace),
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'namespace'             => '\..\resources\views\frontend' . '\\' . ($namespace ? strtolower($namespace) . '\\' . $key : $key),
            'label'                 => str_plural($key),
            'array'                 => camel_case(str_plural($key)),
            'field'                 => $this->option('field'),
            'route'                 => ($namespace ? str_plural(strtolower($namespace)) . '.' . str_plural($key) : str_plural($key)),
            'url'                   => ($namespace ? str_plural(strtolower($namespace)) . '/' . str_plural($key) : str_plural($key)),
            'variable'              => camel_case($key),
            'view'                  => ($namespace ? strtolower($namespace) . '.' . $key : $key),
            '--force'           => $this->hasOption('force') ? $this->option('force') : false,
        ];

        Artisan::call('l5b:stub', $stubParams);
        $this->line('View ' . $stubParams['name'] . Artisan::output());
    }

    protected function frontend_label($key, $name, $stub, $namespace = null)
    {
        $stubParams = [
            'name'                  => 'frontend_' . str_plural($name),
            'ns'                => ucfirst($namespace),
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'namespace'             => '\..\resources\lang\en\\',
            'label'                 => str_plural($key),
            'array'                 => camel_case(str_plural($key)),
            'field'                 => $this->option('field'),
            'route'                 => str_plural($key),
            'variable'              => camel_case($key),
            'view'                  => ($namespace ? strtolower($namespace) . '.' . $key : $key),
            'model'                 => ucfirst(camel_case($key)),
            '--force'           => $this->hasOption('force') ? $this->option('force') : false,
        ];

        Artisan::call('l5b:stub', $stubParams);
        $this->line('Label ' . $stubParams['name'] . Artisan::output());
    }
}
