<?php

namespace App\Http\Controllers\API;

use App\Repositories\Element\ElementInterface;
use App\Repositories\Element\ElementPricingInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class ElementPricingController extends Controller
{

    /**
     * @var ElementPricingInterface
     */
    private $pricing;
    /**
     * @var ElementInterface
     */
    private $element;

    /**
     * ElementPricingController constructor.
     * @param ElementPricingInterface $pricing
     * @param ElementInterface $element
     */
    public function __construct(ElementPricingInterface $pricing, ElementInterface $element)
    {
        $this->pricing = $pricing;
        $this->element = $element;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'pricings' => $this->pricing->index()
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
        $pricing = $this->pricing->create($request->all());

        return response()->json([
            'id' => $pricing->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $real = $request->get('real', 0);

        $pricing = $this->pricing->get($id);

        if ((int) $real == 1)
        {
            $oldPricing = $pricing;

            $elementsToPick = [];

            $pricingData = json_decode($pricing->data);

            foreach ($pricingData as $k => $item)
            {
                $elementsToPick[] = $item->id;
            }

            $elements = $this->element->pickElements($elementsToPick, ['tasks', 'files', 'project']);

            foreach ($elements as $i => $item)
            {
                foreach ($item->tasks()->get() as $j => $task)
                {
                    $find = collect($pricingData)->where('id', $item->id)->first();

                    $price = 0;

                    if ($find !== null)
                    {
                        $findTask = collect($find->tasks)->where('id', $task->id)->first();

                        if ($findTask !== null)
                        {
                            $price = isset($findTask->price) ? $findTask->price : 0;
                        }
                    }

                    $elements[$i]['tasks'][$j]['price'] = $price;
                }
            }

            $pricing->data = json_encode($elements);
        }

        $pricing['real'] = $real;

        return response()->json([
            'pricing' => $pricing
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
        $pricing = $this->pricing->get($id);

        $pricing = $this->pricing->update($pricing, $request->all());

        return response()->json([
            'id' => $pricing->id
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

    public function pdf($id, Request $request)
    {
        $sortBy = $request->get('sortBy', 'name');

        $pricing = $this->pricing->get($id);

        $ElementsExport = [];
        $columns = ['position', 'note', 'making', 'note', 'size', 'done_quantity', 'tasks', 'price'];

        $countDoneQuantity = 0;

        $price = 0;


        foreach(json_decode($pricing->data) as $item)
        {
            $ElementsExport[] = $item;
        }

        if($sortBy)
        {
            $ElementsDataCollection = collect($ElementsExport)->sortBy($sortBy);
        }
        else
        {
            $ElementsDataCollection = $ElementsExport->data;
        }

        foreach ($ElementsDataCollection as $k => $item)
        {
            $array = [];

            if(isset($item->done_quantity))
            {
                $countDoneQuantity += (int) $item->done_quantity;
            }

            if(isset($item->tasks))
            {
                $elementPrice = 0;

                foreach($item->tasks as $task)
                {
                    if(isset($task->price))
                    {
                        $elementPrice += (int) $task->price * $task->pivot->quantity;
                    }
                }

                $elementPrice = $elementPrice * $item->done_quantity;

                $price += $elementPrice;
            }

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
                else if($column == 'note')
                {
                    $array['Notka'] = $item->note;
                }
                else if($column == 'size')
                {
                    $array['Wymiary'] = isset($item->thickness) ? "{$item->thickness} x {$item->width} x {$item->length}" : '-' ;
                }
                else if($column == 'quantity')
                {
                    $array['S'] = (int) $item->quantity;
                }
                else if($column == 'done_quantity')
                {
                    $array['W'] = (int) $item->done_quantity;
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
                else if($column == 'price')
                {
                    $cena = 0;

                    foreach($item->tasks as $task)
                    {
                        if(isset($task->price))
                        {
                            $cena += (int) ($task->price * $task->pivot->quantity) * $item->done_quantity;
                        }
                    }

                    $array['Cena'] = (int) $cena;
                }
            }

            $data[] = $array;
        }

        $data = json_decode(json_encode($data));

        $landscape = $request->get('landscape', true);

        $pdf = App::make('dompdf.wrapper');

        $viewData = [
            'data' => $data,
            'countDoneQuantity' => $countDoneQuantity,
            'price' => $price,
            'pricing' => $pricing,
        ];

        $pdf->loadView('pdf.elements-pricing', $viewData);

        if($landscape)
            $pdf->setPaper('a4', 'landscape');

        return $pdf->stream();

//        return view('pdf.elements-pricing')->withData($data)->with('countDoneQuantity', $countDoneQuantity)->with('price', $price)->with('pricing', $pricing);

    }
}
