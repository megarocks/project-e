<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "systems".
 *
 * @property integer $id
 * @property integer $sn
 * @property string $po
 * @property string $status
 * @property string $cpup
 * @property string $epup
 * @property string $esp
 * @property string $csp
 * @property string $nop
 * @property string $cmp
 * @property string $emp
 * @property string $dmp
 * @property string $npl
 * @property string $ctpl
 * @property string $etpl
 * @property string $dtpl
 * @property string $current_code
 * @property string $next_lock_date
 * @property string $main_unlock_code
 * @property integer $end_user_id
 * @property integer $distributor_id
 * @property integer $country_id
 * @property integer $currency_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Country $country
 * @property EndUser $endUser
 * @property Currency $currency
 * @property Distributor $distributor
 */
class System extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'systems';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sn'], 'required'],
            [['id', 'sn', 'end_user_id', 'distributor_id', 'country_id', 'currency_id'], 'integer'],
            [['status'], 'string'],
            [['cpup', 'epup', 'esp', 'csp', 'nop', 'cmp', 'emp', 'dmp', 'npl', 'ctpl', 'etpl', 'dtpl'], 'number'],
            [['next_lock_date', 'created_at', 'updated_at'], 'safe'],
            [['po'], 'string', 'max' => 45],
            [['current_code', 'main_unlock_code'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sn' => 'Serial Number',
            'po' => 'PO#',
            'status' => 'Status',
            'cpup' => 'CPUP (Customer Payment Upon Purchase)',
            'epup' => 'EPUP (EndyMed Payment Upon Purchase)',
            'esp' => 'ESP (EndyMed System Price)',
            'csp' => 'CSP (Customer System Price)',
            'nop' => 'NOP (Number of Payments in Plan)',
            'cmp' => 'CMP',
            'emp' => 'EMP',
            'dmp' => 'DMP',
            'npl' => 'NPL',
            'ctpl' => 'CTPL',
            'etpl' => 'ETPL',
            'dtpl' => 'DTPL',
            'current_code' => 'Current Code',
            'next_lock_date' => 'Next Lock Date',
            'main_unlock_code' => 'Main Unlock Code',
            'end_user_id' => 'End User ID',
            'distributor_id' => 'Distributor ID',
            'country_id' => 'Country ID',
            'currency_id' => 'Currency ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEndUser()
    {
        return $this->hasOne(EndUser::className(), ['id' => 'end_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistributor()
    {
        return $this->hasOne(Distributor::className(), ['id' => 'distributor_id']);
    }
}
