<?php

declare(strict_types=1);

namespace app\repositories;

use app\models\Offer;
use yii\data\ActiveDataProvider;

class OfferRepository
{
    public function findById($id)
    {
        return Offer::findOne((int)$id);
    }

    public function createDataProvider(array $filters = [], $sort = 'id', $pageSize = 10)
    {
        $query = Offer::find();

        if (!empty($filters['title'])) {
            $query->andWhere(['like', 'title', $filters['title']]);
        }
        if (!empty($filters['email'])) {
            $query->andWhere(['like', 'email', $filters['email']]);
        }

        $query->orderBy([$sort => SORT_ASC]);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => $pageSize],
        ]);
    }

    public function save(Offer $model)
    {
        return $model->save();
    }

    public function delete(Offer $model)
    {
        return (bool)$model->delete();
    }
}
