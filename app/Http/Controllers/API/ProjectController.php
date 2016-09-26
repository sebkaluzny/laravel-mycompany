<?php

namespace App\Http\Controllers\API;

use App\Repositories\Project\ProjectInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{

    /**
     * @var ProjectInterface
     */
    private $project;

    /**
     * ProjectController constructor.
     * @param ProjectInterface $project
     */
    public function __construct(ProjectInterface $project)
    {
        $this->project = $project;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = $this->project->all();

        return response()->json([
            'projects' => $all
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = $this->project->create($request->all());

        return response()->json([
            'project' => $model,
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
        $model = $this->project->get($id);

        return response()->json([
            'project' => $model,
        ]);
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
        $model = $this->project->get($id);

        $model = $this->project->update($model, $request->all());

        return response()->json([
            'project' => $model,
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
