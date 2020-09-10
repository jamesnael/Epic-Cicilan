<?php

namespace Modules\Core\Http\Controllers\Bank;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class BankController extends Controller
{
    /**
     * Return a listing of the resource.
     * @return Response
     */
    public function bankList()
    {
        return response_json(true, null, 'Data Retrieved', banks_list());
    }
}
