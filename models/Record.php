<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string|null $title
 */
class Records extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'records';
    }
    public $id;
    public $fio;
    public $phone;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
         return [
            [['fio'], 'string', 'max' => 255]


        ];
    }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'fio' => 'Fio',
            'phone' => 'Phone',
        ];
    }

    public function getAll()
    {
        return Records::find()->all();
    }

}
