<?php

namespace App\Http\Controllers\API;

use App\Repositories\Element\ElementTaskInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ElementTaskController extends Controller
{

    /**
     * @var ElementTaskInterface
     */
    private $elementTask;

    /**
     * ElementTaskController constructor.
     * @param ElementTaskInterface $elementTask
     */
    public function __construct(ElementTaskInterface $elementTask)
    {
        $this->elementTask = $elementTask;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = $this->elementTask->all();

        return response()->json([
            'element_tasks' => $all
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
        $model = $this->elementTask->create($request->all());

        return response()->json([
            'element_task' => $model
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
        $model = $this->elementTask->get($id);

        return response()->json([
            'element_task' => $model
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
        $model = $this->elementTask->get($id);

        $model = $this->elementTask->update($model, $request->all());

        return response()->json([
            'element_task' => $model
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
