<?php

namespace app\controllers;

use Yii;
use app\models\Adjustment;
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
        if ($model->load(Yii::$app->request->post())) {
            $transaction = \Yii::$app->db->beginTransaction();

            try {
                if ($flag = $model->save()) {
                    $stok = new Inout;
                    $stok->idgudang = 'G001';
                    $stok->kode_barang = $model->kode_barang;
                    $stok->tanggal = $model->tanggal_adjustment;
                    $stok->tipe = '3';

                    if($model->kondisi == 1 or $model->kondisi == 3){
                        $stok->qty_in = 0;
                        $stok->qty_out = $model->qty;
                    }
                    if($model->kondisi == 2 or $model->kondisi == 4){
                        $stok->qty_in = $model->qty;
                        $stok->qty_out = 0;
                    }

                    $stok->referensi = $model->no_adjustment;
                    $stok->stok =  Inout::getCurrentStok($stok->idgudang,$stok->kode_barang) + ($stok->qty_in - $stok->qty_out);
                    if (! ($flag = $stok->save(false))) {
                        $transaction->rollBack();
                    }
                }

                if ($flag) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Transaksi Berhasil Disimpan");
                    return $this->redirect(['index']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        } 
        return $this->render('create', [
            'model' => $model,
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
