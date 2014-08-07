<?php

namespace app\models;

use app\models\behaviors\DateTimeStampBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

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
            'dateTimeStampBehavior' => [
                'class' => DateTimeStampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ]
            ]
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
            [['po_num', 'nop', 'npl', 'end_user_id', 'distributor_id', 'country_id'], 'integer'],
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
            'po_num' => 'PO#',
            'cpup' => 'CPUP',
            'epup' => 'EPUP',
            'esp' => 'ESP',
            'csp' => 'CSP',
            'nop' => 'NOP',
            'cmp' => 'CMP',
            'emp' => 'EMP',
            'dmp' => 'DMP',
            'npl' => 'NPL',
            'ctpl' => 'CTPL',
            'etpl' => 'ETPL',
            'dtpl' => 'DTPL',
            'end_user_id' => 'End-User',
            'distributor_id' => 'Distributor',
            'country_id' => 'Country',
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

    private function calculateValues()
    {
        if ($this->nop != 0) {
            $this->cmp = ($this->csp - $this->cpup) / $this->nop;
            if ($this->epup >= $this->esp) {
                $this->emp = 0;
            } else {
                $this->emp = ($this->esp - $this->epup) / $this->nop;
            }
            $this->dmp = $this->cmp - $this->emp;
        }
    }

}
