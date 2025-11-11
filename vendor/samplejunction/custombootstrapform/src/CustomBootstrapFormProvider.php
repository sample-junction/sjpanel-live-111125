<?php

namespace Samplejunction\CustomBootstrapForm;

use Illuminate\Support\ServiceProvider;

class CustomBootstrapFormProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('custom_bootstrap_form', function($app) {
            return new CustomBootstrapForm($app, 'byepass');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['custom_bootstrap_form'];
    }
}
