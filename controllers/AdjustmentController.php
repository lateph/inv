<?php

namespace app\controllers;

use Yii;
use app\models\Adjustment;
use app\models\AdjustmentDetail;
use app\models\AdjustmentSearch;
use app\models\Inout;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdjustmentController implements the CRUD actions for Adjustment model.
 */
class AdjustmentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Adjustment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Adjustment();
        $model->tanggal_adjustment = date("Y-m-d H:i");
        $modelDetails = [new AdjustmentDetail];
        $modelDetails[0]->qty = 1;  

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->post('AdjustmentDetail')) {
            $transaction = \Yii::$app->db->beginTransaction('REPEATABLE READ');

             $modelDetails = [];
            foreach (Yii::$app->request->post('AdjustmentDetail') as $key => $value){
                $modelDetails[$key] = new AdjustmentDetail;
            }
            AdjustmentDetail::loadMultiple($modelDetails,Yii::$app->request->post() );

            foreach (Yii::$app->request->post('AdjustmentDetail') as $key => $value){
                $modelDetails[$key]->no_adjustment = $model->no_adjustment;
                $modelDetails[$key]->kondisi = $model->kondisi;
            }
            

            // validate all models
            $valid = $model->validate();
            $valid = AdjustmentDetail::validateMultiple($modelDetails) && $valid;
            
            if ($valid) {
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelDetails as $modelDetail) {
                            $stok = new Inout;
                            $stok->idgudang = 'G001';
                            $stok->kode_barang = $modelDetail->kode_barang;
                            $stok->tanggal = $model->tanggal_adjustment;
                            $stok->tipe = '3';

                            if($modelDetail->kondisi == 1 or $modelDetail->kondisi == 3){
                                $stok->qty_in = 0;
                                $stok->qty_out = $modelDetail->qty;
                            }
                            if($modelDetail->kondisi == 2 or $modelDetail->kondisi == 4){
                                $stok->qty_in = $modelDetail->qty;
                                $stok->qty_out = 0;
                            }

                            $stok->referensi = $modelDetail->no_adjustment;
                            $stok->stok =  Inout::getCurrentStok($stok->idgudang,$stok->kode_barang) + ($stok->qty_in - $stok->qty_out);
                            if (! ($flag = $stok->save(false))) {
                                $transaction->rollBack();
                                break;
                            }

                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        // Yii::$app->session->setFlash('success', "Transaksi Berhasil Disimpan");
                        return $this->redirect(['laporanadjustment/view','id'=>$model->no_adjustment]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    // echo "error1";
                }
            }
            else{
                    // echo "error2";

                $transaction->rollBack();
                foreach ($modelDetails as $key => $value){
                    $modelDetails[$key]->isNewRecord = false;
                    // print_r($modelDetails[$key]->)
                }
            }
        } 
        return $this->render('create', [
            'model' => $model,
            'modelDetails' => $modelDetails
        ]);

    }

    /**
     * Finds the Adjustment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Adjustment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adjustment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
