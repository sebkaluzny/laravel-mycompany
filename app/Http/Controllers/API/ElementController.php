<?php

namespace App\Http\Controllers\API;

use App\Lib\ElementsExporter\CSVExporter;
use App\Models\ElementsExport;
use App\Repositories\Element\ElementInterface;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class ElementController extends Controller
{

    protected $types = ['csv', 'pdf'];

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

    public function attachTask(Request $request)
    {
        $elementId = $request->get('element_id');
        $taskId = $request->get('id');

        $model = $this->element->get($elementId);

        $this->element->attachTask($model, $taskId, $request->get('fields'), $request->get('quantity'));

//        dd($model);
//        $this->element->attachFile($model, $fileId);

        return response()->json([
            'success' => 1,
        ]);
    }

    public function detachTask(Request $request)
    {
        $elementId = $request->get('element_id');
        $taskId = $request->get('task_id');

        $model = $this->element->get($elementId);

        $this->element->detachTask($model, $taskId);

        return response()->json([
            'success' => 1,
        ]);
    }

    public function replicate(Request $request)
    {
        $id = $request->get('id');
        $name = $request->get('name');

        $model = $this->element->replicate($this->element->get($id), $name);

        return response()->json([
            'element' => $model
        ]);
    }

    public function postExport(Request $request)
    {

        $type = $request->get('type');
        $exportData = $request->get('export_data');
        $elements = $request->get('elements');

        if (!in_array($type, $this->types))
        {
            throw new \Exception('Invalid type');
        }

        $data = $this->element->exportData($elements, $exportData);

        $hash = str_random(8);

        $elExportModel = new ElementsExport();
        $elExportModel->hash = $hash;
//        $elExportModel->type = $type;
        $elExportModel->export_data = $exportData;
        $elExportModel->data = $data;
        $elExportModel->save();

        return response()->json([
            'url' => action('API\ElementController@getExport', ['hash' => $hash, 'type' => $type]),
        ]);
    }

    public function getExport($hash, $type)
    {
        if (!in_array($type, $this->types))
        {
            throw new \Exception('Invalid type');
        }

        $ElementsExport = ElementsExport::where('hash', $hash)->first();

        if($ElementsExport == null)
        {
            throw new \Exception('Invalid hash');
        }

        $data = [];

        $columns = $ElementsExport->export_data;

        foreach ($ElementsExport->data as $k => $item)
        {
            $array = [];

            foreach($columns as $column)
            {
                if($column == 'position')
                {
                    $array['Nazwa'] = $item->name;
                }
                else if($column == 'making')
                {
                    $array['Materiał'] = isset($item->making) ? $item->making : '-' ;
                }
                else if($column == 'size')
                {
                    $array['Wymiary'] = isset($item->thickness) ? "{$item->thickness} x {$item->width} x {$item->length}" : '-' ;
                }
                else if($column == 'quantity')
                {
                    $array['Sztuk'] = (int) $item->quantity;
                }
                else if($column == 'done_quantity')
                {
                    $array['Wyk. szt.'] = (int) $item->done_quantity;
                }
                else if($column == 'tasks')
                {
                    $tasks = [];

                    foreach($item->tasks as $task)
                    {
                        $fieldsValue = json_decode($task->pivot->fields);

                        $fields = [];

                        foreach($task->fields as $k => $field)
                        {
                            $fields[] = "{$field->name}: {$fieldsValue[$k]}{$field->unit}";
                        }

                        $tasks[] = "{$task->name} x{$task->pivot->quantity} " . implode(',', $fields) . "; ";
                    }

                    $array['Zadania'] = count($item->tasks) ? $tasks : '-';
                }
            }

            $data[] = $array;
        }

        $data = json_decode(json_encode($data));

        if($type == 'csv')
        {
            $fileName = date('d-m-Y') . '_'.$hash.'.csv';

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=' . $fileName);
            header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
            header("Pragma: no-cache");
            header("Expires: 0");
            header("FileName: " . $fileName);

            $csvExport = new CSVExporter($ElementsExport->data);
            $csvExport->export();
        }

        if($type == 'pdf')
        {
            $pdf = App::make('dompdf.wrapper');

            $viewData = [
                'data' => $data
            ];

            $pdf->loadView('pdf.elements-export', $viewData);
            return $pdf->stream();
//            return view('pdf.elements-export')->withData($data);
        }


    }

    public function pricing(Request $request)
    {
        $elements = $request->get('elements');

        $data = $this->element->pickElements($elements, ['tasks', 'files', 'project']);

        foreach($data as $i => $item)
        {
            foreach($item->tasks()->get() as $j=> $task)
            {
                $data[$i]['tasks'][$j]['price'] = 0;
            }
        }

        return response()->json([
            'elements' => $data
        ]);
    }
}
