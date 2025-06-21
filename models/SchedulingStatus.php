<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "vetlife.scheduling_status".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property Scheduling[] $schedulings
 */
class SchedulingStatus extends ActiveRecord
{
    public static function tableName()
    {
        return 'vetlife.scheduling_status';
    }

    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nome do Status',
        ];
    }

    public function getSchedulings()
    {
        return $this->hasMany(Scheduling::class, ['id_status' => 'id']);
    }
}