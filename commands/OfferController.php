<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\db\Exception;
use Faker\Factory;

class OfferController extends Controller
{
    public function actionGenerate($count = 10)
    {
        $faker = Factory::create();

        for ($i = 0; $i < $count; $i++) {
            try {
                Yii::$app->db->createCommand()->insert('offers', [
                    'title' => $faker->company,
                    'email' => $faker->unique()->companyEmail,
                    'phone' => $faker->optional()->phoneNumber,
                    'created_at' => date('Y-m-d H:i:s'),
                ])->execute();
            } catch (Exception $e) {
                echo "Ошибка: " . $e->getMessage() . "\n";
            }
        }

        echo "Generated {$count} offers.\n";
    }
}
