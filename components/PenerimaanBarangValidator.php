<?php
namespace app\components;

use yii\validators\Validator;

class PenerimaanBarangValidator extends Validator
{
    public function init()
    {
        parent::init();
        $this->message = 'Kode Barang tidak boleh sama';
    }

    public function validateAttribute($model, $attribute)
    {

    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return <<<JS
        var arr = $(".val-kode-barang")  // for all checkboxes
            .map(function () {
    return this.value; // $(this).val()
}).get();
        var sorted_arr = arr.slice().sort(); // You can define the comparing function here. 
                                     // JS by default uses a crappy string compare.
                                     // (we use slice to clone the array so the
                                     // original array won't be modified)
        var results = [];
        for (var i = 0; i < arr.length - 1; i++) {
            if (sorted_arr[i + 1] == sorted_arr[i]) {
                results.push(sorted_arr[i]);
            }
        }
        if(results.length > 0){

            messages.push($message);
        }
JS;
    }
}