
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$backUrlFull = Yii::$app->request->referrer;
$exBackUrlFull = explode('?r=', $backUrlFull);
$backUrl = '#';
if ( isset ( $exBackUrlFull[1] ) ) {
$backUrl = $exBackUrlFull[1];
}
 ?>

 <div class="user-permission-form">
 	<section class="content">
         <div class="row">
             <div class="col-xs-12">

                 <div class="box">
                   <div class="panel panel-default">
                     <div class="box-header with-border panel-heading">
                       <h3 class="box-title panel-title">Permission Setting</h3>
                     </div>
                     <!-- /.box-header -->
                     <div class="box-body panel-body">

 				    <?php $form = ActiveForm::begin(); ?>
 				    	<div class="row">
 					    	<div class="col-sm-3 col-xs-12">
 								<select id="controllerName" name="controllerName" class="form-control">
 						    	<?php foreach ( $controllerList as $cName => $cL ) {  ?>

 						    		<?php  $selected = $controllerNameChosen == $cName ?  'selected' : ''?>
 						    		<option <?= $selected ?>><?= $cName ?></option>
 					    		<?php } ?>
 					    		</select>
 				    		</div>
 					    	<div class="col-sm-3 col-xs-12">
 								<select id="userGroup" name="userGroup" class="form-control">
 									<option vale="0">Please select</option>
 				    				<?php foreach ( $userGroup as $uG ) { ?>
 				    					<?php  $selected = $userGroupId == $uG->id ?  'selected' : ''?>
                      <option value="<?= $uG->id ?>" <?= $selected ?>><?= $uG->usergroup ?></option>
 			    					<?php } /* foreach */ ?>
 			    				</select>
 				    		</div>

 			    		</div>
 				    <?php ActiveForm::end(); ?>
 					    <div class="row">
                   <br>
 				    		<?php $form = ActiveForm::begin(); ?>
 						    <div class="item col-sm-12">
 					    		<input type="hidden" name="controllerName" value="<?= $controllerNameLong ?>">
 					    		<input type="hidden" name="controllerNameChosen" value="<?= $controllerNameChosen ?>">
 					    		<input type="hidden" name="userGroup" value="<?= $userGroupId ?>">
 				    			<?php if ( $controllerActions ) {  ?>

 				    				<?php
 				    					foreach ( $controllerActions as $cA ) { ?>
 				    					<?php
 				    					/* if within the permission table */
 				    					$checked = '';
 				    					if ( in_array($cA, $permission, true) ){
 				    						$checked = 'checked';
 				    					}

 				    					?>
 				    					<input type="checkbox" name="checkBox[<?= $cA ?>]" <?= $checked ?> > <?= $cA ?> <br>
 			    					<?php } /* foreach */ ?>
 					    		<input type="hidden" name="controllerNameChosen" value="<?= $controllerNameChosen ?>">
 					    		<div class=" col-sm-12 text-right">
 								    <div class="form-group">
 					    				<input type="button" id="select-all" value="Select All" class="btn btn-default">
 								      <?= Html::submitButton('<i class=\'fa fa-save\'></i> Save', ['class' => 'btn btn-default']) ?>
 								    </div>
 							    </div>
 			    				<?php } /* if */ ?>
 				    		</div>

 				    		<?php ActiveForm::end(); ?>
 					    </div>
 				    </div>


 				    </div>
            </div>
 			    </div>
 		    </div>
 	    </div>


     </section>
 </div>


<?php

 ?>
