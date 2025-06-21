<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class HelloController extends Controller
{
    /**
     * Gera um hash de palavra-passe seguro.
     * @param string $password A palavra-passe a ser hasheada.
     */
    public function actionGeneratePasswordHash($password)
    {
        $hash = Yii::$app->security->generatePasswordHash($password);
        echo "\nPalavra-passe: " . $password . "\n";
        echo "Hash gerado: " . $hash . "\n\n";
    }
}
