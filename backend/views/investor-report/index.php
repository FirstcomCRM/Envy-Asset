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

<div class="investor-report-index">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Search</h3>
    </div>
    <div class="panel-body">
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= Html::checkbox('confirm', false, ['label' => 'Confirm Report' ,'class'=>'email-checkbox']); ?>
        <div id="email-div">
          <?php echo Html::a('<i class="fa fa-envelope-open" aria-hidden="true"></i> Send Email',
          ['compose-email'],['class' => 'btn btn-warning send-email', 'id'=>'email-button']) ?>
        </div>


    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">List</h3>
    </div>
    <div class="panel-body">
      <p>
        <?php Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Predefined Update', ['update', 'id'=>3], ['class' => 'btn btn-default modalUpdate']) ?>
        <?php Html::a('<i class="fa fa-wheelchair" aria-hidden="true"></i> Modal Testing Update', FALSE, ['value' => Url::to(['investor-report/update', 'id' => 3]), 'class' => 'btn btn-default modalButton','id'=>'modalButton' ]); ?>
      </p>

        <?php Pjax::begin(['id'=>'investor', 'linkSelector'=>false]); ?>
         <?= GridView::widget([
            'dataProvider' => $dataProvider,
          //  'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
            //    'id',
                [
                  'attribute'=>'investor',
                  'format'=>'raw',
                  'value'=>function($model){
                  //  return  Html::a('<i class="fa fa-wheelchair" aria-hidden="true"></i> Modal Testing Update-3',FALSE, ['value' => Url::to(['investor-report/update', 'id' => $model->id]), 'class' => 'modalButton btn btn-default', 'data-pjax'=>0]);
                  //  return  Html::a('Profile', ['update', 'id' => 3], ['class' => 'modalButton']) ;
                    return Retrieve::retrieveInvestor($model->investor);
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

              //  ['class' => 'yii\grid\ActionColumn'],
              [
                'header'=>'Action',
                'class'=>'yii\grid\ActionColumn',
                'template'=>'{view}{update}',
                'options'=>['style'=>'padding:5px'],
                'buttons'=>[
                  'view'=>function($url,$model,$key){
                    return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>',$url,
                    [
                //    'id'=>'test',
                    'data-pjax'=>0,
                    'class'=>'modalButton',
                  //  'value'=>Yii::$app->urlManager->createUrl('investor-report/view?'),
                    'value' => Url::to(['investor-report/view', 'id' => $key])
                    ]
                  );

                  },
                  'update'=>function($url,$model,$key){
                    return Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',$url,
                    [
                    //  'id'=>$model->id,
                      'data-pjax'=>0,
                      'class'=>'modalButton',
                      'value' => Url::to(['investor-report/update', 'id' => $key])
                    ]
                  );
                  },
                ],
              ],
            ],
        ]); ?>
      <?php Pjax::end(); ?>
    </div>
  </div>
</div>




<?php
  Modal::begin([
    'header'=>'Investor Report',
    'id'=>'modals',
    'size'=>'modal-lg',
    //'clientOptions' => ['backdrop' => false],
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
