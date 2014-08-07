<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "po".
 *
 * @property integer $id
 * @property integer $po_num
 * @property string $cpup
 * @property string $epup
 * @property string $esp
 * @property string $csp
 * @property integer $nop
 * @property string $cmp
 * @property string $emp
 * @property string $dmp
 * @property integer $npl
 * @property string $ctpl
 * @property string $etpl
 * @property string $dtpl
 * @property integer $end_user_id
 * @property integer $distributor_id
 * @property integer $country_id
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EndUsers $endUser
 * @property Country $country
 * @property Distributor $distributor
 * @property System[] $systems
 */
class PurchaseOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'po';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['po_num'], 'required'],
            [['cpup', 'epup', 'esp', 'csp', 'cmp', 'emp', 'dmp', 'ctpl', 'etpl', 'dtpl'], 'number'],
            [['po_num', 'nop', 'npl', 'end_user_id', 'distributor_id', 'country_id', 'currency_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['email'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'po_num' => 'Po Num',
            'cpup' => 'Cpup',
            'epup' => 'Epup',
            'esp' => 'Esp',
            'csp' => 'Csp',
            'nop' => 'Nop',
            'cmp' => 'Cmp',
            'emp' => 'Emp',
            'dmp' => 'Dmp',
            'npl' => 'Npl',
            'ctpl' => 'Ctpl',
            'etpl' => 'Etpl',
            'dtpl' => 'Dtpl',
            'end_user_id' => 'End User ID',
            'distributor_id' => 'Distributor ID',
            'country_id' => 'Country ID',
            'email' => 'Email',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEndUser()
    {
        return $this->hasOne(EndUsers::className(), ['id' => 'end_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->country->currency_name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistributor()
    {
        return $this->hasOne(Distributor::className(), ['id' => 'distributor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystems()
    {
        return $this->hasMany(System::className(), ['po' => 'id']);
    }
}
