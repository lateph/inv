<?php

namespace app\models;
use yii\web\IdentityInterface;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $kode_user
 * @property string $username
 * @property string $password
 * @property string $nama
 * @property string $kode_unit
 * @property string $hak_akses
 *
 * @property Unit $kodeUnit
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password1;
    public $passwordre;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_user', 'username'], 'required'],
            [['kode_user', 'username', 'password', 'nama', 'kode_unit', 'hak_akses'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['passwordre'], 'compare','compareAttribute'=>'password1', 'on' => 'create'],
            [['password1'], 'required', 'on' => 'create'],
            [['password1'], 'string', 'min' => 6],
            [['kode_unit'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['kode_unit' => 'kode_unit']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode_user' => 'Kode User',
            'username' => 'Username',
            'password' => 'Password',
            'password1' => 'Password',
            'passwordre' => 'Re Password',
            'nama' => 'Nama',
            'kode_unit' => 'Kode Unit',
            'hak_akses' => 'Hak Akses',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['kode_unit' => 'kode_unit']);
    }

    public function beforeSave($insert)
    {
        if($this->password1){
            $this->password = md5($this->password1);
        }
        parent::beforeSave($insert);
        return true;
    }


    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->kode_user;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findByUsername($u){
        return static::findOne(['username'=>$u]);
    }

    public function validatePassword($pass){
        if(md5($pass) == $this->password){
            return true;
        }
        else
            return false;
    }
}
