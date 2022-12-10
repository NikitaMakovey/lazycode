<div style="padding: 10px;
        background-color: #8EC5FC;
        background-image: linear-gradient(62deg, #8EC5FC 0%, #E0C3FC 100%);"
>
    <p style="font-size: 1.2rem">
        Здравствуйте, <strong>{{ $data['name'] }}</strong>!
    </p>
    <p style="margin-top: 0; font-size: 1rem; margin-bottom: 15px">
        Для подтверждения e-mail - нажмите на кнопку ниже.
    </p>
    <div style="align-items: center; justify-items: center">
        <a href="{{ $data['link'] . str_replace("/", "%2F", $data['code']) }}">
            <button
                style="
                    color: #000;
                    border-radius: 10px;
                    font-size: 1.5rem;
                    border: 1px solid #000;
                    height: 3rem;
                    width: auto;
                    padding: 5px;
                    background-color: #D9AFD9;
                    background-image: linear-gradient(225deg, #D9AFD9 0%, #97D9E1 100%);
                    "
            >
                Подтверждение E-mail
            </button>
        </a>
    </div>
    <div style="margin-top: 20px;">
            <span style="font-size: 1rem">
                С уважением,
            </span>
        <br>
        <span style="color: #000; margin-left: 20px; font-size: 1rem">
                <strong>Администрация Lazycode</strong>
            </span>
    </div>
</div>
