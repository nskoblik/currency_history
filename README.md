# Получение курсов, кроскурсов ЦБ

`git clone https://github.com/nskoblik/currency_history.git`

`cp .env.example .env`

`docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html laravelsail/php82-composer:latest composer install --ignore-platform-reqs`

`./vendor/bin/sail up`

`./vendor/bin/sail artisan migrate`

## Доступные команды

Получить курс на заданную дату:
`./vendor/bin/sail artisan app:get-rate {date} {currency} {base_currency=RUB}`, где `date` - дата в формате `'Y-m-d'`, 
`currency` - строковый код валюты по ISO 4217, 
`base_currency` - строковый код базовой валюты по ISO 4217 (по умолчанию - RUB).

Пример:  `./vendor/bin/sail artisan app:get-rate 2023-07-15 USD`

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
   `./vendor/bin/sail artisan queue:work redis`
2. start parse command:
   `./vendor/bin/sail artisan app:parse-history`

Примечание

1. Если говорить про реализацию на проекте, стоит забирать курсы с ЦБ каждый день по крону за последний день, настроить мониторинг и повторный сбор при недоступности веб-сервиса цб.
2. В \App\Dictionary\CurrencyDictionary ограниченный список кодов валют, нужно описать все коды из справочника цб.
3. Есть редкие виды валют, которые нельзя получить с сайта.
4. Не поддерживала логику со старыми кодами валют (если говорить про RUR).
3. Реализация VO \App\VO\Money примитивна, по-хорошему, код валюты должен быть внутри VO.
