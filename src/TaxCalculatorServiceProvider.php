<?php

/*
 * This file is part of Laravel Tax Calculator.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\TaxCalculator;

use BrianFaust\ServiceProvider\ServiceProvider;

class TaxCalculatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishConfig();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        parent::register();

        $this->mergeConfig();

        $this->app->singleton('tax-calculator', function ($app) {
            $config = $app->config['tax-calculator'];

            return new Calculator($config['currency'], $config['locale'], $config['tax_rate']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_merge(parent::provides(), ['tax-calculator']);
    }

    /**
     * Get the default package name.
     *
     * @return string
     */
    public function getPackageName()
    {
        return 'tax-calculator';
    }
}
