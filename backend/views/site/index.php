<?php
use yii\widgets\Pjax;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */

$this->title = 'Envy Asset';
?>
<div class="site-index">

  <ul class="nav nav-pills">
    <li class="active"><a href="#news" data-toggle="pill">News</a></li>
    <li><a href="#contract" data-toggle="pill">Expiring Contracts</a></li>
  </ul>

  <div class="tab-content">

    <div class="tab-pane fade in active" id="news"><!-- start of news tab--->
      <br>
      <?php foreach ($announce as $key => $value): ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">
              <p><?php echo $value->title ?></p>
            </h3>
          </div>
          <div class="panel-body">
            <?php echo nl2br($value->announcement) ?>
          </div>
        </div>
      <?php endforeach; ?>
     <?= LinkPager::widget(['pagination' => $pagination]) ?>
   </div><!-- End of news tab--->
   <div class="tab-pane fade" id="contract">
     <br>
     <h3>Insert Expiring Contract table here</h3>
   </div>

  </div>
  <hr>
</div>
