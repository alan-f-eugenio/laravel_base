<?php

namespace App\Providers;

use App\Models\Define;
use App\Models\Integration;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        //
        if (!app()->runningInConsole()) {
            Config::set('defines', Define::first());

            $integrations = Integration::all()->mapWithKeys(function ($item) {
                return [$item['integration'] => $item];
            });
            foreach ($integrations as $integration => $item) {
                Config::set(
                    'integrations.' . $item['type'] . '.' . $integration,
                    ['id' => $item['id'], 'status' => $item['status'], 'defines' => json_decode($item['defines'], true), 'editable' => $item['editable']]
                );
            }

            $modules = json_decode(file_get_contents('../modules_statuses.json'));
            $contentModule = isset($modules->Content) && $modules->Content == true;

            if ($contentModule) {
                $navs = \Modules\Content\Entities\ContentNav::orderBy('type')->get()->mapWithKeys(function ($item) {
                    return [$item['slug'] => $item];
                });
                foreach ($navs as $nav => $id) {
                    Config::set('contentNavs.' . $nav, $id);
                }
            }

        }
    }
}
