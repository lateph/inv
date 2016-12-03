<?php

namespace app\controllers;

use Yii;
use app\models\PenerimaanBarang;
use app\models\Barang;
use app\models\Inout;
use app\models\PenerimaanBarangDetail;
use app\models\BarangSearchPenerimaanBarangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PenerimaanController implements the CRUD actions for PenerimaanBarang model.
 */
class PenerimaanController extends Controller
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
     * Lists all PenerimaanBarang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new PenerimaanBarang();
        $model->tanggal_penerimaan = date("Y-m-d H:i");
        $modelDetails = [new PenerimaanBarangDetail];
        $modelDetails[0]->qty = 2;

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->post('PenerimaanBarangDetail') ) {
            $modelDetails = [];
            foreach (Yii::$app->request->post('PenerimaanBarangDetail') as $key => $value){
                $modelDetails[$key] = new PenerimaanBarangDetail;
            }
            PenerimaanBarangDetail::loadMultiple($modelDetails,Yii::$app->request->post() );
            foreach (Yii::$app->request->post('PenerimaanBarangDetail') as $key => $value){
                $modelDetails[$key]->no_penerimaan = $model->no_penerimaan;
            }
            

            // validate all models
            $valid = $model->validate();
            $valid = PenerimaanBarangDetail::validateMultiple($modelDetails) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelDetails as $modelDetail) {
                            
                            if (! ($flag = $modelDetail->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                            else{
                                $stok = new Inout;
                                $stok->idgudang = 'G001';
                                $stok->kode_barang = $modelDetail->kode_barang;
                                $stok->tanggal = $model->tanggal_penerimaan;
                                $stok->tipe = '1';
                                $stok->qty_in = $modelDetail->qty;
                                $stok->qty_out = 0;
                                $stok->referensi = $model->no_penerimaan;
                                $stok->stok = Inout::getCurrentStok($stok->idgudang,$stok->kode_barang) + $stok->qty_in;
                                if (! ($flag = $stok->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
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
            else{
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
     * Finds the PenerimaanBarang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PenerimaanBarang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PenerimaanBarang::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetbarang()
    {
        // some parameter from JS
        // ex. 127.0.0.1/?r=my-controller/quote&query=3
        // $queryTerm = 3;
        $queryTerm = Yii::$app->request->get('query');
        Yii::$app->response->format = 'json';
        $id = Yii::$app->getRequest()->getQueryParam('id');
        $b = Barang::find()
                ->where(['kode_barang' => $id])
                ->one();

        return $b;
    }
}
