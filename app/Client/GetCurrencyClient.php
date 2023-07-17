<?php

declare(strict_types=1);

namespace App\Client;

use App\DTO\CurrencyRateCbr;
use App\VO\Money;

class GetCurrencyClient
{
    /**
     * @param \Illuminate\Support\Carbon $date
     * @return CurrencyRateCbr[]
     * @throws \SoapFault
     */
    public function getCurrency(\Illuminate\Support\Carbon $date): array
    {
        $soap_client = new \SoapClient(
            'http://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?WSDL',
            ['connection_timeout' => \App\Dictionary\TimeDictionary::SECONDS_IN_MINUTES]
        );
        try {
            /** @noinspection PhpUndefinedMethodInspection */
            $data = $soap_client->GetCursOnDate(['On_date' => $date->toDateString()]);
        } catch (\Exception) {
            return [];
        }

        if (!$xml_string = $data->GetCursOnDateResult->any) {
            return [];
        }

        if (!$xml = simplexml_load_string($xml_string)) {
            return [];
        }

        $result = [];
        foreach ($xml->ValuteData->ValuteCursOnDate as $element) {
            $result[] = new CurrencyRateCbr(
                (int)$element->Vcode,
                (int)$element->Vnom,
                Money::getFromDecimal((float)$element->Vcurs)
            );
        }

        return $result;
    }
}
