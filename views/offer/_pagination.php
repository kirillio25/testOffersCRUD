<!-- _pagination.php -->
 <?php use yii\widgets\LinkPager; ?>
<div id="pagination" class="d-flex justify-content-center">
    <?= LinkPager::widget([
        'pagination' => $dataProvider->pagination,
        'options' => ['class' => 'pagination'],
        'linkOptions' => ['class' => 'page-link'],
        'prevPageCssClass' => 'd-none', 
        'nextPageCssClass' => 'd-none', 
        'firstPageCssClass' => 'page-item',
        'lastPageCssClass' => 'page-item',
        'activePageCssClass' => 'active',
        'disabledPageCssClass' => 'disabled',
    ]) ?>
</div>
