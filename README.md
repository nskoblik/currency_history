Получение курсов, кроскурсов ЦБ

Доступные команды

Получить курс на заданную дату:
sail artisan app:get-rate {date} {currency} {base_currency=RUB}
где date - дата в формате 'Y-m-d', 
currency - строковый код валюты по ISO 4217, 
base_currency - строковый код базовой валюты по ISO 4217 (по умолчанию - RUB).
Пример:  sail artisan app:get-rate 2023-07-15 USD
Список доступных для теста кодов:
- RUB
- TRY
- USD
- EUR
- GBP
- BYR
- BYN
- UAH
- KGS
- KZT
- BDT
- EGP
- IRR

Собрать курсы валют за последние 180 дней:
1. start a queue worker: 
    sail artisan queue:work redis
2. start parse command:
    sail artisan app:parse-history

Примечание

1. По-хорошему, стоит забирать курсы с ЦБ каждый день по крону за последний день, настроить мониторинг и повторный сбор при недоступности веб-сервиса цб.
2. В \App\Dictionary\CurrencyDictionary ограниченный список кодов валют, нужно описать все коды из справочника цб.
3. Есть редкие виды валют, которые нельзя получить с сайта.
3. Реализация VO \App\VO\Money примитивна, по-хорошему, код валюты должен быть внутри VO.
