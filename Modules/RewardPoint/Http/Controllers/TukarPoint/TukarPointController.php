<?php

namespace Modules\RewardPoint\Http\Controllers\TukarPoint;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\RewardPoint\Entities\RewardCategory;
use Modules\RewardPoint\Entities\RewardPoint;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TukarPointController extends Controller
{
     /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->breadcrumbs = [
            ['href' => url('/'), 'text' => 'Home'],
            ['href' => route('tukar-point.index'), 'text' => 'Tukar Point'],
        ];
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $this->table_headers = [
            [
                "text" => 'Nama Sub Agent',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Total Point',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Korwil',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            [
                "text" => 'Koordinator Utama',
                "align" => 'center',
                "sortable" => true,
                "value" => '',
            ],
            
        ];
        return view('rewardpoint::TukarPoint.index', [
            'page' => $this,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['href' => route('tukar-point.index'), 'text' => 'Tambah Tukar Point'];

        return view('rewardpoint::TukarPoint.create', [
            'page' => $this,
        ])->with($this->getHelper());
    }



   public function data(RewardPoint $tukar_point)
    {
        try {
            return response_json(true, null, 'Sukses mengambil data.', $tukar_point);
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
   public function getHelper()
    {
        return [
            'category' => RewardCategory::select('id AS value', 'category_name AS text')->get(),
            'reward_name' => RewardPoint::select('category_reward_id AS value', 'reward_name AS text')->get()
       
        ];
    }

    /**
     *
     * Handle incoming request for form helper
     *
     */
    public function formHelper()
    {
        try {
            return response_json(true, null, 'Sukses mengambil data.', $this->getHelper());
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

}
