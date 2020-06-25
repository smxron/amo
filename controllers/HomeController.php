<?php

namespace App\Controller;

use App\Component\AmoCRM;

class HomeController
{
    public function actionIndex()
    {
        include_once(ROOT . "/templates/home/index.php");
        return true;
    }

    public function actionForm()
    {
        $get = $_GET;
        include_once(ROOT . "/templates/home/form.php");
        return true;
    }

    public function actionSend()
    {
        $data = $_POST['data'];

        $amoCRM = new AmoCRM($_POST['auth']);
        $amoCRM->sendData($data);

        //header('Location: '. "/index");
        return true;
    }
}