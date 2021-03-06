<?php

namespace ErpNET\Delivery\v1\Controllers;

use ErpNET\Delivery\v1\Interfaces\DeliveryService;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 *  Delivery resource representation.
 *
 * @Resource("Delivery", uri="/delivery")
 */
class DeliveryServiceController extends Controller
{

    protected $service;

    /**
     * Controller constructor.
     */
    public function __construct(DeliveryService $deliveryService)
    {
        if (!request()->wantsJson()) {

            $this->middleware('web');
        }
        $this->service = $deliveryService;
    }

    public function config()
    {
        
    }

    public function createUser()
    {
        try{
            DB::beginTransaction();
            $fields = request()->all();
            if(config('app.debug')) logger($fields);

            $createdData = $this->service->createUser($fields);

            $response = [
                'message' => 'Resource created.',
                'data'    => $createdData->toArray(),
            ];

            DB::commit();

            if (request()->wantsJson()) {

                return response()->json($response);
            }

            return redirect('welcome');

        } catch (ValidatorException $e) {
            DB::rollBack();
            if (request()->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }
    
    public function productStock()
    {
//        list($render, $allData) = $this->getIndexData();

        $allData = $this->service->productStock();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $allData,
            ]);
        }

        return view('welcome')->with(['data'=>$allData]);

        //Render welcome if view with route's name not available
//        return $this->render('index', $allData, null, $render);
    }
    
    public function package()
    {
        try{
            $fields = request()->all();
            if(config('app.debug')) logger($fields);

            $createdData = $this->service->createPackage($fields);
            
            $response = [
                'message' => 'Resource created.',
                'data'    => $createdData->toArray(),
            ];
            
            if (request()->wantsJson()) {

                return response()->json($response);
            }
            
            return redirect('welcome');
            
        } catch (ValidatorException $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }
}
