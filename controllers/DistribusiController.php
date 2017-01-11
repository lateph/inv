<?php

namespace app\controllers;

use Yii;
use app\models\DistribusiBarang;
use app\models\Barang;
use app\models\Project;
use app\models\Inout;
use app\models\DistribusiBarangDetail;
use app\models\BarangSearchDistribusiBarangSearch;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DistribusiController implements the CRUD actions for DistribusiBarang model.
 */
class DistribusiController extends Controller
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
     * Lists all DistribusiBarang models.
     * @return mixed
     */
    public function actionIndex()
    {

        $model = new DistribusiBarang();
        $model->tanggal_distribusi = date("Y-m-d H:i");
        $model->create_by = Yii::$app->user->id;
        $model->create_time = date("Y-m-d H:i:s");
        $modelDetails = [new DistribusiBarangDetail];

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->post('DistribusiBarangDetail') ) {
            $transaction = \Yii::$app->db->beginTransaction('REPEATABLE READ');

            if($model->kode_project == ''){
                $model->kode_project = null;
            }
            $modelDetails = [];
            foreach (Yii::$app->request->post('DistribusiBarangDetail') as $key => $value){
                $modelDetails[$key] = new DistribusiBarangDetail;
            }
            DistribusiBarangDetail::loadMultiple($modelDetails,Yii::$app->request->post() );

            $l = [];
            foreach (Yii::$app->request->post('DistribusiBarangDetail') as $key => $value){
                $modelDetails[$key]->no_distribusi = $model->no_distribusi;
                // $md = $modelDetails[$key];
                // if(!@$l[$md->kode_barang]){
                //     $l[$md->kode_barang] = true;

                //     $connection = Yii::$app->getDb();
                //     $command = $connection->createCommand('select * from barang where kode_barang = :kb FOR UPDATE', [':kb' => $md->kode_barang]);
                //     $result = $command->queryAll();
                // }
            }
            

            // validate all models
            $valid = $model->validate();

            $valid = DistribusiBarangDetail::validateMultiple($modelDetails) && $valid;

            if ($valid) {
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelDetails as $modelDetail) {
                            
                            if (! ($flag = $modelDetail->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                            else{
                                $stok = new Inout;
                                $stok->idgudang = $model->kode_unit;
                                $stok->kode_barang = $modelDetail->kode_barang;
                                $stok->tanggal = $model->tanggal_distribusi;
                                $stok->tipe = '2';
                                $stok->qty_in = $modelDetail->qty;
                                $stok->qty_out = 0;
                                $stok->referensi = $model->no_distribusi;
                                $stok->stok =  Inout::getCurrentStok($stok->idgudang,$stok->kode_barang) + $stok->qty_in;;
                                if (! ($flag = $stok->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                                else{
                                    // echo "error";
                                }

                                $stok = new Inout;
                                $stok->idgudang = 'G001';
                                $stok->kode_barang = $modelDetail->kode_barang;
                                $stok->tanggal = $model->tanggal_distribusi;
                                $stok->tipe = '2';
                                $stok->qty_in = 0;
                                $stok->qty_out = $modelDetail->qty;
                                $stok->referensi = $model->no_distribusi;
                                $stok->stok =  Inout::getCurrentStok($stok->idgudang,$stok->kode_barang) - $stok->qty_out;
                                if (! ($flag = $stok->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                                else{
                                    // echo "error";

                                }
                            }
                        }
                    }
                    else{
                                    // echo "error";

                    }

                    if ($flag) {
                        $transaction->commit();
                        // Yii::$app->session->setFlash('success', "Transaksi Berhasil Disimpan");
                        return $this->redirect(['laporandistribusi/view','id'=>$model->no_distribusi]);

                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            else{
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
     * Finds the DistribusiBarang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DistribusiBarang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DistribusiBarang::findOne($id)) !== null) {
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

    public function actionGetproject()
    {
        // some parameter from JS
        // ex. 127.0.0.1/?r=my-controller/quote&query=3
        // $queryTerm = 3;
        $queryTerm = Yii::$app->request->get('query');
        Yii::$app->response->format = 'json';
        $id = Yii::$app->getRequest()->getQueryParam('id');
        $b = Project::find()
                ->where(['perusahaan' => $id])
                ->all();

        return $b;
    }
}
