<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Task;
use App\Policies\TaskPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
       // Task::class => TaskPolicy::class,
           \App\Models\Task::class => \App\Policies\TaskPolicy::class,

    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
