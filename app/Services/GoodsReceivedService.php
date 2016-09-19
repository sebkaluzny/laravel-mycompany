<?php


namespace App\Services;


use App\Repositories\Element\ElementInterface;
use App\Repositories\GoodsReceived\GoodsReceivedInterface;

class GoodsReceivedService extends BaseService
{

    /**
     * @var ElementInterface
     */
    private $element;

    /**
     * @var GoodsReceivedInterface
     */
    private $goodsReceived;


    /**
     * GoodsReceivedService constructor.
     * @param ElementInterface $element
     * @param GoodsReceivedInterface $goodsReceived
     */
    public function __construct(ElementInterface $element, GoodsReceivedInterface $goodsReceived)
    {
        $this->element = $element;
        $this->goodsReceived = $goodsReceived;
    }

    public function repository()
    {
        return $this->goodsReceived;
    }

    /**
     * Create goods received & sync elements
     *
     * @param array $input
     * @return mixed
     */
    public function addGoods(array $input = [])
    {
        $goodsReceived = $this->goodsReceived->create($input);

        $elements = $this->goodsReceived->syncFormElements($goodsReceived, $input);

        $this->setElementQuantities($elements);

        return $goodsReceived;
    }

    /**
     * Set element quantities
     *
     * @param $elements
     * @param bool $old
     */
    private function setElementQuantities($elements, $old = false)
    {
        foreach ($elements as $id => $element)
        {
            $elementModel = $this->element->get($id);

            $quantity = $elementModel->quantity;

            if($old)
            {
                $find = $old->whereStrict('id', $elementModel->id)->first();

                if($find)
                {
                    $quantity -= (int) $find->pivot->quantity;
                }
            }

            // TODO try catch

            $this->element->setQuantities($elementModel, [
                'quantity'      => $quantity + $element['quantity'],
                'done_quantity' => $elementModel->done_quantity,
            ]);
        }
    }

    /**
     * Perform update form goods received.
     * Sync & Update Elements quantities
     *
     * @param $model
     * @param array $input
     * @return mixed
     */
    public function updateGoods($model, array $input = [])
    {
        $old = $model->elements()->get();

        $model->update($input);

        $elements = $this->goodsReceived->syncFormElements($model, $input);

        $this->setElementQuantities($elements, $old);

        return $model;
    }
}