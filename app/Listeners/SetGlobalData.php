<?php

namespace App\Listeners;

use App\Models\ContentNav;
use App\Models\Define;
use App\Models\Integration;
use Illuminate\Support\Facades\Config;

class SetGlobalData {
    /**
     * Create the event listener.
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void {
        //
        Config::set('defines', Define::first());

        $navs = ContentNav::orderBy('type')->get()->mapWithKeys(function ($item) {
            return [$item['slug'] => $item];
        });
        foreach ($navs as $nav => $id) {
            Config::set('contentNavs.' . $nav, $id);
        }

        $integrations = Integration::all()->mapWithKeys(function ($item) {
            return [$item['integration'] => $item];
        });
        foreach ($integrations as $integration => $item) {
            Config::set(
                'integrations.' . $item['type'] . '.' . $integration,
                ['id' => $item['id'], 'status' => $item['status'], 'defines' => json_decode($item['defines'], true), 'editable' => $item['editable']]
            );
        }
    }
}
