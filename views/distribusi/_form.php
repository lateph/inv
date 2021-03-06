<?php

use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap\Html;
use kartik\select2\Select2Asset;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Barang;
use app\models\Unit;
use app\models\Project;
use yii\helpers\Url;
use kartik\datetime\DateTimePicker;
use kartik\date\DatePicker;


$url = \yii\helpers\Url::to(['ajax/barang']);
Select2Asset::register($this);
$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    $(item).find("select").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Barang -","language":"en-US",
        "minimumInputLength" : 3,
        "ajax" : {
            "url" : "'.$url.'",
            "dataType" : "json",
            "data" : function(params) { return {q:params.term}; }
        },
        "escapeMarkup" : function (markup) { return markup; },
        "templateResult" : function(city) { return city.text; },
        "templateSelection" : function (city) { return city.text; },
    });
    $(item).find(".val-qty").val(1);
    $(item).find("select").on("select2:select", function(e) { 
        console.log($(item).find("select").val());
        $.ajax({
            url: "'.Url::to(['distribusi/getbarang']).'",
            dataType: "json",
            data :  {
                    id : $(item).find("select").val()
            },
            success: function(data) {
                $(item).find(".val-satuan").val(data.satuan.satuan_barang);
            }
        })
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Address: " + (index + 1))
    });
});
prjs = [];
$(".form-options-item").find("select").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Barang -","language":"en-US",
        "minimumInputLength" : 3,
        "ajax" : {
            "url" : "'.$url.'",
            "dataType" : "json",
            "data" : function(params) { return {q:params.term}; }
        },
        "escapeMarkup" : function (markup) { return markup; },
        "templateResult" : function(city) { return city.text; },
        "templateSelection" : function (city) { return city.text; },});
$("#distribusibarang-kode_unit").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Unit -","language":"en-US"});
$("#distribusibarang-kode_project").select2({"allowClear":true,"theme":"bootstrap","width":"100%","placeholder":"- Pilih Project -","language":"en-US"});
$(".form-options-item").find("select").on("select2:select", function(e) { 
        console.log($(this).val());
        var myS = $(this);
        $.ajax({
            url: "'.Url::to(['distribusi/getbarang']).'",
            dataType: "json",
            data :  {
                    id : $(this).val()
            },
            success: function(data) {
                myS.closest(".form-options-item").find(".val-satuan").val(data.satuan.satuan_barang);
            }
        })
    });
$("#distribusibarang-kode_unit").on("select2:select", function(e) { 
    console.log($(this).val());
    var myS = $(this);
    $.ajax({
        url: "'.Url::to(['distribusi/getproject']).'",
        dataType: "json",
        data :  {
                id : $(this).val()
        },
        success: function(data) {
            var $el = $("#distribusibarang-kode_project");
            $el.empty(); // remove old options
            console.log(data);
            $.each(data, function(key,value) {
                $el.append("<option></option>");
                $el.append($("<option></option>")
                 .attr("value", value.kode_project).text(value.nama_project));
            });
        }
    })
});

';

$this->registerJs($js);
/* @var $this yii\web\View */
/* @var $model app\models\DistribusiBarang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="distribusi-barang-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal','id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'no_distribusi')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'tanggal_distribusi', [
      
            ])->widget(DateTimePicker::classname(),[
      'options' => ['placeholder' => ''],
      'value' => date('d-M-Y'),
      'readonly' => true,
      
      'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd hh:ii',
        'todayHighlight' => TRUE,
    ]
    ]);
    ?>

    <?= $form->field($model, "kode_unit")->dropDownList(ArrayHelper::map(Unit::find()->all(), 'kode_unit', 'unit_kerja'),['prompt'=>''] ) ?>

    <?php 
        $prjs = [];
        if($model->kode_unit){
            $prjs = ArrayHelper::map(Project::find()->where(['perusahaan' => $model->kode_unit])->all(), 'kode_project', 'nama_project');
        }
    ?>
    <?= $form->field($model, "kode_project")->dropDownList($prjs,['prompt'=>'']) ?>

    <?= $form->field($model, 'no_request')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_of_order', [
      
            ])->widget(DatePicker::classname(),[
      'options' => ['placeholder' => ''],
      'value' => date('d-M-Y'),
      'readonly' => true,
      
      'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => TRUE,
    ]
    ]);
    ?>

    <?= $form->field($model, 'issued_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'penerima')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keterangan')->textArea() // keterangan ?>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.form-options-body', // required: css class selector
        'widgetItem' => '.form-options-item', // required: css class
        'limit' => 999, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.delete-item', // css class
        'model' => $modelDetails[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'kode_barang',
            'qty',
            'keterangan',
        ],
    ]); ?>
    <table class="table table-bordered table-striped margin-b-none">
        <thead>
            <tr>
                <th style="width: 120px;">Nama Barang</th>
                <th style="width: 120px;">QTY</th>
                <th style="width: 120px;">Satuan</th>
                <th style="width: 500px;">Keterangan</th>
                <th style="width: 90px; text-align: center">Actions</th>
            </tr>
        </thead>
        <tbody class="form-options-body"><!-- widgetContainer -->
            <?php foreach ($modelDetails as $index => $modelDetail): ?>
                <tr class="form-options-item">
                    <td>
                        <?php
                            $barang = Barang::findOne(['kode_barang'=>$modelDetail->kode_barang]);
                            $ar = [];
                            if($barang){
                                $ar = [$barang->kode_barang=>$barang->kode_barang.' - '.$barang->nama_barang];
                            }
                        ?>
                        <?= $form->field($modelDetail, "[{$index}]kode_barang",['template'=>'{input}{error}'])->label(false)->dropDownList($ar ,['prompt'=>'','target'=>'asdasdas{$index}','class'=>'val-kode-barang'] ) ?>
                    </td>
                    <td>
                        <?= $form->field($modelDetail, "[{$index}]qty",['template'=>'{input}{error}'])->label(false)->textInput(['maxlength' => true,'type'=>'number','min'=>0,'class'=>'val-qty form-control']) ?>
                    </td>
                    <td>
                        <?= Html::activeTextInput($modelDetail,"[{$index}]satuan",['class'=>'form-control val-satuan','readonly'=>true]) ?>
                    </td>
                    <td>
                        <?= $form->field($modelDetail, "[{$index}]keterangan",['template'=>'{input}{error}'])->label(false)->textInput(['maxlength' => true]) ?>
                    </td>
                    <td class="text-center vcenter">
                        <button type="button" class="delete-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"></td>
                <td><button type="button" class="add-item btn btn-success btn-sm"><span class="fa fa-plus"></span> New</button></td>
            </tr>
        </tfoot>
    </table>
    <?php DynamicFormWidget::end(); ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
