<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;
use app\services\OfferService;
use yii\web\Controller;
use yii\web\Response;

class OfferController extends Controller
{
    private $offerService;

    public function __construct($id, $module, OfferService $offerService, $config = [])
    {
        $this->offerService = $offerService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(): string
    {
        // Получение фильтров из запроса
        $dataProvider = $this->offerService->getFilteredOffers(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionEdit($id = null): Response
    {
        // Делегирование логики редактирования и получения оффера в сервисный метод
        $response = $this->offerService->editOffer(Yii::$app->request, $id);
        return $this->asJson($response);
    }

    public function actionDelete(): Response
    {
        // Удаление оффера с помощью сервиса и возвращение JSON-ответа с результатом
        $response = $this->offerService->deleteOffer((int)Yii::$app->request->post('id'));
        return $this->asJson($response);
    }
}
