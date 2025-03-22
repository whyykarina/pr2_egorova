<?php

namespace App\Providers;

use App\Policies\TopicPolicy;
use App\Models\Topic;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
         Topic::class => TopicPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-topic', [TopicPolicy::class, 'update']);
        Gate::define('delete-topic', [TopicPolicy::class, 'delete']);
    }
}