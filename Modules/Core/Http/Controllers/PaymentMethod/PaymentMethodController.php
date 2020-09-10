<?php

namespace Modules\Core\Http\Controllers\PaymentMethod;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class PaymentMethodController extends Controller
{
    /**
     * Return a listing of the resource.
     * @return Response
     */
    public function paymentMethodList()
    {
        return response_json(true, null, 'Data Retrieved', payment_methods_list());
    }
}
