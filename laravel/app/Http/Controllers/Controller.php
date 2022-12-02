<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function render_page($page_slug, $page_data = null) {
        return view($page_slug)->with($page_data);
    }

    protected function revert_сreating_object($obj_instance) {
        return $obj_instance->delete();
    }
}
