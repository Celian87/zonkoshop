<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Aggiunge direttiva @currency() per formattare i $oldi
        Blade::directive('currency', function ($amount) {
            return "<?php echo number_format($amount, 2, ',', '.'); ?>";
        });
    }
}
