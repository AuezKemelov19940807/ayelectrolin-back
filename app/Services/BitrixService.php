<?php

namespace App\Services;

use Bitrix24\SDK\Services\ServiceBuilderFactory;
use Illuminate\Support\Facades\Http;
class BitrixService
{
    private $b24;

    public function __construct()
    {
        // ⚠️ webhooks лучше хранить в .env
        $this->b24 = ServiceBuilderFactory::createServiceBuilderFromWebhook(
            config('bitrix.webhook')
        );
    }

    // Добавить контакт
    public function addContact(string $name, string $phone): int
    {
        return $this->b24->getCRMScope()->contact()->add([
            'NAME'  => $name,
            'PHONE' => [['VALUE' => $phone, 'VALUE_TYPE' => 'WORK']],
        ])->getId();
    }

    // Добавить сделку
    public function addDeal(string $title, int $contactId): int
    {
        return $this->b24->getCRMScope()->deal()->add([
            'TITLE'      => $title,
            'CONTACT_ID' => $contactId,
            'TYPE_ID'    => 'SALE',
            'STAGE_ID'   => 'NEW',
        ])->getId();
    }

    // Получить список сделок (ID, название, контакт, телефоны)
//     public function getDeals()
// {
//     $deals = $this->b24->getCRMScope()->deal()->list(
//         ['*'],   // поля
//         [],      // фильтр
//         ['ID' => 'DESC'],
//         50
//     );



//     $result = [];

//     foreach ($deals->getDeals() as $deal) {
//         $contact = null;
//         $phones = [];

//         if (!empty($deal->contactId)) {
//             $contactResult = $this->b24->getCRMScope()->contact()->get($deal->contactId);
//             $contactData   = $contactResult->getContact();

//             $contact = trim(($contactData->name ?? '') . ' ' . ($contactData->lastName ?? ''));

//             if (!empty($contactData->phones)) {
//                 foreach ($contactData->phones as $phone) {
//                     $phones[] = $phone->value;
//                 }
//             }
//         }

//         $result[] = [
//             // 'deal_id'    => $deal->id,
//             'title'      => $this->b24->getCRMScope(),
//             'stage'      => $deal->stageId,
//             // 'amount'     => $deal->opportunity,
//             'contact'    => $contact,
//             'phones'     => $phones,
//             'created_at' => $deal->dateCreate ?? null,
//         ];
//     }

//     return response()->json($result);
// }


// public function getDeals()
// {
//     $dealsResult = $this->b24
//         ->getCRMScope()
//         ->deal()
//         ->list(
//             ['ID', 'TITLE', 'STAGE_ID', 'CONTACT_ID', 'DATE_CREATE'],
//             [],
//             ['ID' => 'DESC'],
//             50
//         );

//     $result = [];

//     foreach ($dealsResult->getDeals() as $deal) {
//         $contact = null;
//         $phones = [];

//         if (!empty($deal->contactId)) {
//             $contactResult = $this->b24->getCRMScope()->contact()->get($deal->contactId);
//             $contactData   = $contactResult->getContact();

//             $contact = trim(($contactData->name ?? '') . ' ' . ($contactData->lastName ?? ''));

//             if (!empty($contactData->phones)) {
//                 foreach ($contactData->phones as $phone) {
//                     $phones[] = $phone->value;
//                 }
//             }
//         }

//         $result[] = [
//             'id'         => $deal->id ?? null,
//             'title'      => $deal->title ?? null,
//             'stage'      => $deal->stageId ?? null,
//             'contact'    => $contact,
//             'phones'     => $phones,
//             'created_at' => $deal->dateCreate ?? null,
//         ];
//     }

//     return response()->json($result);
// }

public function getDeals()
{
    try {
        $response = $this->b24
            ->core
            ->call(
                'crm.deal.list',
                [
                    'select' => ['ID', 'TITLE', 'STAGE_ID', 'CONTACT_ID', 'DATE_CREATE'],
                    'filter' => [],
                    'order'  => ['ID' => 'DESC'],
                    'start'  => 0
                ]
            );

        // getResult() уже возвращает массив
        $result = $response->getResponseData()->getResult();

        // Если ошибка в массиве
        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 500);
        }

        // Возвращаем сделки
        return response()->json($result['result'] ?? []);

    } catch (\Throwable $e) {
        return response()->json([
            'error' => 'Error fetching deal list: ' . $e->getMessage()
        ], 500);
    }
}



// public function getDeals()
// {
//     $dealsResult = $this->b24->getCRMScope()->deal()->list(
//         ['*'],   // какие поля тянуть
//         [],      // фильтр
//         ['ID' => 'DESC'],
//         50       // лимит
//     );

//     $result = [];

//     // ⚡️ тут достаем сами сделки
//     foreach ($dealsResult->getDeals() as $dealItem) {
//         $deal = $dealItem->toArray();

//         $contact = null;
//         $phones = [];

//         if (!empty($deal['CONTACT_ID'])) {
//             $contactResult = $this->b24->getCRMScope()->contact()->get((int)$deal['CONTACT_ID']);
//             $contactData   = $contactResult->getContact()->toArray();

//             $contact = trim(($contactData['NAME'] ?? '') . ' ' . ($contactData['LAST_NAME'] ?? ''));

//             if (!empty($contactData['PHONE'])) {
//                 foreach ($contactData['PHONE'] as $phone) {
//                     $phones[] = $phone['VALUE'];
//                 }
//             }
//         }

//         $result[] = [
//             'id'         => $deal['ID'] ?? null,
//             'title'      => $deal['TITLE'] ?? null,
//             'stage'      => $deal['STAGE_ID'] ?? null,
//             'contact'    => $contact,
//             'phones'     => $phones,
//             'created_at' => $deal['DATE_CREATE'] ?? null,
//         ];
//     }

//     return response()->json($result);
// }





}
