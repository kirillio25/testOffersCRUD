<?php

declare(strict_types=1);

namespace app\services;

use app\models\Offer;
use app\repositories\OfferRepository;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Request;

class OfferService
{
    private $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function getFilteredOffers(array $filters): ActiveDataProvider
    {
         // Создание DataProvider с фильтрацией
        return $this->offerRepository->createDataProvider(
            [
                'title' => $filters['title'] ?? null,
                'email' => $filters['email'] ?? null
            ],
            $filters['sort'] ?? 'id'
        );
    }

    public function editOffer(Request $request, $id = null): array
    {
        // Проверка типа запроса
        if ($request->isGet) {
            $offer = $this->getOffer((int)($id ?? $request->get('id')));
            return [
                'id' => $offer->id,
                'title' => $offer->title,
                'email' => $offer->email,
                'phone' => $offer->phone
            ];
        }
        // Обновление данных оффера для запроса типа POST
        if ($request->isPost) {
            $offer = $this->getOffer((int)$request->post('id'));
            $offer->setAttributes($request->post());

            if ($offer->validate() && $this->offerRepository->save($offer)) {
                return ['success' => true];
            }

            return [
                'success' => false,
                'message' => 'Ошибка сохранения',
                'errors' => $offer->errors
            ];
        }

        return ['success' => false, 'message' => 'Неверный метод запроса'];
    }

    public function deleteOffer(int $id): array
    {
        $offer = $this->getOffer($id);
        // Проверка успешности удаления и возвращение результата
        if ($this->offerRepository->delete($offer)) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Ошибка при удалении'];
    }

    private function getOffer(int $id): Offer
    {
        $offer = $this->offerRepository->findById($id);
        if (!$offer) {
            throw new NotFoundHttpException('Оффер не найден');
        }
        return $offer;
    }
}
