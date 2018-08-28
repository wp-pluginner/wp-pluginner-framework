<?php

namespace WpPluginner\Illuminate\Contracts\Support;

interface Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \WpPluginner\Illuminate\Http\Request  $request
     * @return \WpPluginner\Illuminate\Http\Response
     */
    public function toResponse($request);
}
