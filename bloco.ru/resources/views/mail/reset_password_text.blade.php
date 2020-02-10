Здравствуйте, {{ $data['name'] }}!

Для смены пароля - перейдите по следующей ссылке:
{{ $data['link'] . str_replace("/", "%2F", $data['code']) . '/p/' . str_replace("/", "%2F", $data['token']) }}.

С уважением,
    Администрация Lazycode
