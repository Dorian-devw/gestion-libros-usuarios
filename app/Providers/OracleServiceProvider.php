<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Yajra\Oci8\Oci8ServiceProvider;

class OracleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(Oci8ServiceProvider::class);
        
        $this->app->bind('db.connector.oracle', function() {
            return new class extends \Yajra\Oci8\Connectors\OracleConnector {
                protected function configureSession($connection, $config)
                {
                    // Configuración mínima de sesión sin la parte de EDITION
                    $sessionVars = [
                        'NLS_TIME_FORMAT' => 'HH24:MI:SS',
                        'NLS_DATE_FORMAT' => 'YYYY-MM-DD HH24:MI:SS',
                        'NLS_TIMESTAMP_FORMAT' => 'YYYY-MM-DD HH24:MI:SS',
                        'NLS_TIMESTAMP_TZ_FORMAT' => 'YYYY-MM-DD HH24:MI:SS TZH:TZM',
                        'NLS_NUMERIC_CHARACTERS' => '.,'
                    ];
                    
                    foreach ($sessionVars as $var => $value) {
                        $connection->exec("ALTER SESSION SET $var = '$value'");
                    }
                }
            };
        });
    }
}