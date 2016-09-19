<?php

namespace App\Http\Controllers\API;

use App\Repositories\Element\ElementInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ElementController extends Controller
{

    /**
     * @var ElementInterface
     */
    private $element;

    /**
     * ElementController constructor.
     * @param ElementInterface $element
     */
    public function __construct(ElementInterface $element)
    {
        $this->element = $element;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json([
            'elements' => $this->element->index($request->all())
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $element = $this->element->create($request->all());

        return response()->json([
            'element' => $element
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $element = $this->element->get($id);

        return response()->json([
            'element' => $element
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $element = $this->element->get($id);

        $element = $this->element->update($element, $request->all());

//        $element = $this->element->get($id);

        return response()->json([
            'element' => $element
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Search for elements by request params
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $elements = $this->element->search($request->all());

        return response()->json([
            'elements' => $elements
        ]);
    }

    /**
     * Attach file to element
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachFile(Request $request)
    {
        $elementId = $request->get('element_id');
        $fileId = $request->get('file_id');

        $model = $this->element->get($elementId);

//        dd($model);

        $this->element->attachFile($model, $fileId);

        return response()->json([
            'success' => 1,
        ]);
    }

    /**
     * Detach file from element
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detachFile(Request $request)
    {
        $elementId = $request->get('element_id');
        $fileId = $request->get('file_id');

        $model = $this->element->get($elementId);

        $this->element->unattachFile($model, $fileId);

        return response()->json([
            'success' => 1,
        ]);
    }
}
