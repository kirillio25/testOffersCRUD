<?php

namespace app\controllers;

use Yii;
use app\models\Offer;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class OfferController extends Controller
{
    public function actionIndex()
    {
        $query = Offer::find();

        // Фильтрация по названию и email
        $title = Yii::$app->request->get('title');
        $email = Yii::$app->request->get('email');

        if ($title) {
            $query->andWhere(['like', 'title', $title]);
        }
        if ($email) {
            $query->andWhere(['like', 'email', $email]);
        }

        // Сортировка
        $query->orderBy([
            Yii::$app->request->get('sort') ?? 'id' => SORT_ASC,
        ]);

        // Пагинация
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEdit($id = null)
{
    // Если запрос GET, значит, нужно загрузить данные для модального окна
    if (Yii::$app->request->isGet) {
        $id = Yii::$app->request->get('id');
        $model = Offer::findOne($id);

        if (!$model) {
            return $this->asJson(['success' => false, 'message' => 'Оффер не найден']);
        }

        return $this->asJson([
            'id' => $model->id,
            'title' => $model->title,
            'email' => $model->email,
            'phone' => $model->phone
        ]);
    }

    // Если запрос POST, значит, нужно сохранить изменения
    if (Yii::$app->request->isPost) {
        $id = Yii::$app->request->post('id');
        $model = Offer::findOne($id);

        if (!$model) {
            return $this->asJson(['success' => false, 'message' => 'Оффер не найден']);
        }

        $model->title = Yii::$app->request->post('title');
        $model->email = Yii::$app->request->post('email');
        $model->phone = Yii::$app->request->post('phone');

        if ($model->save()) {
            return $this->asJson(['success' => true]);
        } else {
            return $this->asJson(['success' => false, 'message' => 'Ошибка сохранения', 'errors' => $model->errors]);
        }
    }

    // Если метод запроса не GET и не POST
    return $this->asJson(['success' => false, 'message' => 'Неверный метод запроса']);
}

    


public function actionDelete()
{
    $id = Yii::$app->request->post('id');
    $model = Offer::findOne($id);

    if (!$model) {
        return $this->asJson(['success' => false, 'message' => 'Оффер не найден']);
    }

    if ($model->delete()) {
        return $this->asJson(['success' => true]);
    } else {
        return $this->asJson(['success' => false, 'message' => 'Ошибка при удалении']);
    }
}

}
