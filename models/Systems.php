<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "systems".
 *
 * @property integer $id
 * @property integer $sn
 * @property string $po
 * @property string $email
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
 * @property Countries $country
 * @property EndUsers $endUser
 * @property Currencies $currency
 * @property Distributors $distributor
 */
class Systems extends \yii\db\ActiveRecord
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
            [['sn', 'end_user_id', 'distributor_id', 'country_id', 'currency_id'], 'integer'],
            [['status'], 'string'],
            [['cpup', 'epup', 'esp', 'csp', 'nop', 'cmp', 'emp', 'dmp', 'npl', 'ctpl', 'etpl', 'dtpl'], 'number'],
            [['next_lock_date', 'created_at', 'updated_at'], 'safe'],
            [['po', 'email'], 'string', 'max' => 45],
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
            'email' => 'Related Email',
            'status' => 'Status',
            'cpup' => 'CPUP (Customer payment upon purchase)',
            'epup' => 'EPUP (EndyMed payment upon purchase)',
            'esp' => 'ESP (EndyMed system price)',
            'csp' => 'CSP (Customer System price)',
            'nop' => 'NOP (Number of payments in plan)',
            'cmp' => 'CMP',
            'emp' => 'EMP',
            'dmp' => 'DMP',
            'npl' => 'NPL',
            'ctpl' => 'CTPL',
            'etpl' => 'ETPL',
            'dtpl' => 'DTPL',
            'current_code' => 'Current Code',
            'next_lock_date' => 'Next Locking Date',
            'main_unlock_code' => 'Main Unlock Code',
            'end_user_id' => 'End User ID',
            'distributor_id' => 'Distributor ID',
            'country_id' => 'Country ID',
            'currency_id' => 'Currency ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'endusertitle' => 'End-User',
            'distributortitle' => 'Distributor'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEndUser()
    {
        return $this->hasOne(EndUsers::className(), ['id' => 'end_user_id']);
    }

    public function getEndUserTitle()
    {
        return $this->endUser->title;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currencies::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistributor()
    {
        return $this->hasOne(Distributors::className(), ['id' => 'distributor_id']);
    }

    public function getDistributorTitle()
    {
        return $this->distributor->title;
    }
}
