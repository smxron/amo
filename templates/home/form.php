<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Добро пожаловать!</title>
    <link href="../www/css/style.css" rel="stylesheet">
</head>

<body>

<div>
    <h1>TEST AMOCRM API</h1>
    <hr>
    <form action="send" method="post">
        <label for="login">API-логин
            <input type="text" name="auth[login]" id="login">
        </label>

        <label for="hash">API-ключ
            <input type="text" name="auth[hash]" id="hash">
        </label>

        <hr/>

        <label for="name">Название сделки
            <input type="text" name="data[name]" id="name">
        </label>

        <label for="company">Компания
            <input type="text" name="data[company]" id="company">
        </label>

        <label for="oferta">Согласны с правилами оферты?
            <input type="checkbox" name="data[oferta]" id="oferta">
        </label>

        <label for="contactName">Имя
            <input type="text" name="data[contactName]" id="contactName">
        </label>

        <label for="phone">Номер телефона
            <input type="text" name="data[phone]" id="phone">
        </label>

        <label for="mailAgree">Хотите получать письма?
            <input type="checkbox" name="data[mailAgree]" id="mailAgree">
        </label>

        <label for="formId">Form Id
            <input type="text" name="data[formId]" id="formId">
        </label>
        <hr/>
        <?php foreach ($get as $key => $value):?>
        <label for="<?=$key?>"> <?=$key?>
            <input type="text" readonly name="data[<?=$key?>]" id="<?=$key?>" value="<?=$value?>">
        </label>
        <?php endforeach; ?>

        <input type="submit" value="Отправить">
    </form>
</div>
</body>

</html>