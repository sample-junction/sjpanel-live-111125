<?php

namespace Samplejunction\CustomBootstrapForm\Facades;

use Illuminate\Support\Facades\Facade;

class CustomBootstrapForm extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'custom_bootstrap_form';
    }
}
