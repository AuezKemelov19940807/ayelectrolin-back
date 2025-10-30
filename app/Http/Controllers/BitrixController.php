<?php

namespace App\Http\Controllers;

use App\Services\BitrixService;
use Illuminate\Http\Request;

class BitrixController extends Controller
{
    public function createContact(Request $request, BitrixService $bitrix)
    {
        $id = $bitrix->addContact($request->name, $request->phone);

        return response()->json(['contact_id' => $id]);
    }

    public function createDeal(Request $request, BitrixService $bitrix)
    {
        $id = $bitrix->addDeal($request->title, $request->contact_id);

        return response()->json(['deal_id' => $id]);
    }

    public function listDeals(BitrixService $bitrix)
   {
    return response()->json($bitrix->getDeals());
    }
}
