<?php

namespace Modules\Core\Http\Controllers\Occupation;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class OccupationController extends Controller
{
    /**
     * Return a listing of the resource.
     * @return Response
     */
    public function occupationList()
    {
        return response_json(true, null, 'Data Retrieved', occupations_list());
    }
}
