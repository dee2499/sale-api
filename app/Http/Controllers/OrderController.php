<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ApplyRuleRequest;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function applyRule(ApplyRuleRequest $request)
    {
        // Get the input items and sort them in descending order
        $items = collect($request->input('items'));
        $rule = $request->input('rule');

        $discounted = [];
        $payable = [];

        switch ($rule) {
            case 1:
                $result = $this->applyRule1($items);
                break;
            case 2:
                $result = $this->applyRule2($items);
                break;
            case 3:
                $result = $this->applyRule3($items);
                break;
            default:
                return response()->json(['error' => 'Invalid rule'], 400);
        }

        return new OrderResource((object)[
            'discounted' => $result['discounted'],
            'payable' => $result['payable'],
        ]);
    }

    private function applyRule1($items)
    {

        $items = $items->sortDesc()->values();

        $payable = [];
        $discounted = [];

        for ($i = 0; $i < $items->count(); $i++) {
            $payable[] = $items[$i];
            if ($i + 1 < $items->count() && $items[$i + 1] <= $items[$i]) {
                $discounted[] = $items[$i + 1];
                $i++;
            }
        }

        return [
            'payable' => $payable,
            'discounted' => $discounted
        ];
    }

    private function applyRule2($items)
    {
        $items = $items->sortDesc()->values();

        $payable = [];
        $discounted = [];

        while ($items->isNotEmpty()) {

            $currentPayable = $items->shift();
            $payable[] = $currentPayable;


            $discountIndex = null;
            foreach ($items as $index => $item) {
                if ($item < $currentPayable) {
                    $discountIndex = $index;
                    break;
                }
            }


            if (!is_null($discountIndex)) {
                $discounted[] = $items->pull($discountIndex);
            }
        }

        return [
            'payable' => $payable,
            'discounted' => $discounted
        ];
    }

    private function applyRule3($items)
    {
        $items = $items->toArray();
        arsort($items);

        $payable = [];
        $discounted = [];

        while (count($items) >= 4) {

            $currentPayable1 = array_shift($items);
            $currentPayable2 = array_shift($items);
            $payable[] = $currentPayable1;
            $payable[] = $currentPayable2;


            $potentialDiscounts = [];
            foreach ($items as $key => $item) {
                if ($item < $currentPayable1) {
                    $potentialDiscounts[] = $item;
                    unset($items[$key]);
                }
                if (count($potentialDiscounts) == 2) {
                    break;
                }
            }


            foreach ($potentialDiscounts as $discountedItem) {
                $discounted[] = $discountedItem;
            }
        }


        foreach ($items as $item) {
            $payable[] = $item;
        }

        return [
            'payable' => $payable,
            'discounted' => $discounted
        ];
    }
}
