<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use common\components\Retrieve;

$this->title = 'Investor Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>investor-report/index</h1>

<p>
    You may change the content of this page by modifying INDEX_BAK
    the file <code><?= __FILE__; ?></code>.
</p>

<div class="investor-report-index">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Search</h3>
    </div>
    <div class="panel-body">
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">List</h3>
    </div>
    <div class="panel-body">
      <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Predefined Update', ['update', 'id'=>3], ['class' => 'btn btn-default modalUpdate']) ?>
        <?= Html::a('<i class="fa fa-wheelchair" aria-hidden="true"></i> Modal Testing Update', FALSE, ['value' => Url::to(['investor-report/update', 'id' => 3]), 'class' => 'btn btn-default modalButton','id'=>'modalButton' ]); ?>
      </p>

        <?php Pjax::begin(['id'=>'investor','enablePushState' => false]); ?>
         <?= GridView::widget([
            'dataProvider' => $dataProvider,
          //  'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                [
                  'attribute'=>'investor',
                  'format'=>'raw',
                  'value'=>function($model){
                    return  Html::a('<i class="fa fa-wheelchair" aria-hidden="true"></i> Modal Testing Update-3',FALSE, ['value' => Url::to(['investor-report/update', 'id' => $model->id]), 'class' => 'modalButton' ]);
                  //  return  Html::a('Profile', ['update', 'id' => 3], ['class' => 'modalButton']) ;
                    //return Retrieve::retrieveInvestor($model->investor);
                  },
                ],
                [
                  'attribute'=>'product',
                  'value'=>function($model){
                    return Retrieve::retrieveProductName($model->product);
                  },
                ],
                'share',
                [
                  'attribute'=>'price',
                  'value'=>function($model){
                    return Retrieve::retrieveFormat($model->price);
                  },
                ],
              //  'price',
                'date',
                [
                  'attribute'=>'salesperson',
                  'value'=>function($model){
                    return Retrieve::retrieveUsernameManagement($model->salesperson);
                  },
                ],
                 'remarks:ntext',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
      <?php Pjax::end(); ?>
    </div>
  </div>
</div>


<?php
  Modal::begin([
    'header'=>'Update test',
    'id'=>'modals',
    'size'=>'modal-lg',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
  //  'closeButton'=>'tag',
  ]);

 ?>

<div class="" id="modalContent">

</div>

<?php Modal::end() ?>

<?php
$this->registerJs(

                      '$("body").on("beforeSubmit", "form#investor-form", function () {
                        var form = $(this);
                        // return false if form still have some validation errors
                        if (form.find(".has-error").length)
                        {
                            return false;
                        }
                        // submit form
                        $.ajax({
                            url    : form.attr("action"),
                            type   : "post",
                            data   : form.serialize(),
                            success: function (response)
                            {
                                alert("File successfully updated");
                                $("#modals").modal("toggle");
                                $.pjax.reload({container:"#investor"}); //for pjax update
                                location.reload();
                            },
                            error  : function ()
                            {
                                console.log("internal server error");
                            }
                        });
                        return false;


    });'
);
?>
