<?php

namespace App\Http\Controllers\API;

use App\Repositories\GoodsReceived\GoodsReceivedInterface;
use App\Services\GoodsReceivedService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GoodsReceivedController extends Controller
{

    /**
     * @var GoodsReceivedInterface
     */
    private $goodsReceived;
    /**
     * @var GoodsReceivedService
     */
    private $goodsReceivedService;

    /**
     * GoodsReceivedController constructor.
     * @param GoodsReceivedInterface $goodsReceived
     * @param GoodsReceivedService $goodsReceivedService
     */
    public function __construct(GoodsReceivedInterface $goodsReceived, GoodsReceivedService $goodsReceivedService)
    {
        $this->goodsReceived = $goodsReceived;
        $this->goodsReceivedService = $goodsReceivedService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = $this->goodsReceived->index();

        return response()->json([
            'goods_received' => $models,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = $this->goodsReceivedService->addGoods($request->all());
//        $model = $this->goodsReceived->create($request->all());
//        $elements = $this->goodsReceived->syncFormElements($model, $request->all());

        return response()->json([
            'goods_received' => $model
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->goodsReceived->get($id);

        return response()->json([
            'goods_received' => $model,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = $this->goodsReceived->get($id);

        $model = $this->goodsReceivedService->updateGoods($model, $request->all());

        return response()->json([
            'goods_received' => $model,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
