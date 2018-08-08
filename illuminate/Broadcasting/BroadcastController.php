<?php

namespace WpPluginner\Illuminate\Broadcasting;

use WpPluginner\Illuminate\Http\Request;
use WpPluginner\Illuminate\Routing\Controller;
use WpPluginner\Illuminate\Support\Facades\Broadcast;

class BroadcastController extends Controller
{
    /**
     * Authenticate the request for channel access.
     *
     * @param  \WpPluginner\Illuminate\Http\Request  $request
     * @return \WpPluginner\Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        return Broadcast::auth($request);
    }
}
