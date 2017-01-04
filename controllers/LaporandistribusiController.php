<?php

namespace app\controllers;

use Yii;
use app\models\DistribusiBarang;
use app\models\LaporanDistribusiBarangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LaporanDistribusiController implements the CRUD actions for DistribusiBarang model.
 */
class LaporandistribusiController extends Controller
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
        $searchModel = new LaporanDistribusiBarangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DistribusiBarang model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DistribusiBarang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DistribusiBarang();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->no_distribusi]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DistribusiBarang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->no_distribusi]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionPrint($id){
        $model = $this->findModel($id);

        $objPHPExcel = new \PHPExcel();
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load(Yii::getAlias('@app')."/delivery-note.xls");
        $objPHPExcel->getActiveSheet()->setCellValue('B5', $model->no_distribusi);
        $objPHPExcel->getActiveSheet()->setCellValue('D5', $model->no_request);
        $objPHPExcel->getActiveSheet()->setCellValue('B8', Yii::$app->formatter->format($model->tanggal_distribusi, 'date'));
        $objPHPExcel->getActiveSheet()->setCellValue('D8', $model->date_of_order ? Yii::$app->formatter->format($model->date_of_order, 'date') : ' - ' ) ;
        $objPHPExcel->getActiveSheet()->setCellValue('D11', $model->issued_by);
        $objPHPExcel->getActiveSheet()->setCellValue('B11', $model->unit->delivery_address);
        $objPHPExcel->getActiveSheet()->setCellValue('B20', $model->project->nama_project);
        $objPHPExcel->getActiveSheet()->setCellValue('B17', $model->penerima);

        $baseRow = 22;
        foreach($model->details as $r => $dataRow) {
            $row = $baseRow + $r;
            $objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $r+1)
                                      ->setCellValue('C'.$row, $dataRow->barang->nama_barang)
                                      ->setCellValue('G'.$row, $dataRow->qty)
                                      ->setCellValue('H'.$row, $dataRow->barang->satuan->singkatan);
                                      // ->setCellValue('E'.$row, '=C'.$row.'*D'.$row);
        }
        $objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
        // header('Content-type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment; filename="file.xls"');
        $objWriter->save('php://output');
    }

    /**
     * Deletes an existing DistribusiBarang model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
}
