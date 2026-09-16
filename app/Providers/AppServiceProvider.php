<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        app()->setLocale('es');
        $menu = [[
            'text' => 'Panel de inicio', 'icon' => 'bi bi-grid-1x2',
            'submenu' => [
                ['text' => 'Resumen general', 'url' => 'dashboard'],
                ['text' => 'Indicadores', 'url' => 'dashboard#indicadores'],
                ['text' => 'Gráficos', 'url' => 'dashboard#graficos'],
            ],
        ]];
        foreach (config('interfaz') as $modulo => $datos) {
            $submenu = [];
            foreach ($datos['secciones'] as $seccion => $titulo) {
                $submenu[] = ['text' => $titulo, 'url' => "interfaz/{$modulo}/{$seccion}", 'icon' => 'bi bi-circle'];
            }
            $menu[] = ['text' => $datos['titulo'], 'icon' => $datos['icono'], 'submenu' => $submenu];
        }
        config(['adminlte.menu' => $menu]);
    }
}
