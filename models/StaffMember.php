<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "staff_member".
 *
 * @property int $id
 * @property int $departament_id
 * @property string $member_name
 * @property string $date_hire
 *
 * @property Department $departament
 */
class StaffMember extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['departament_id', 'member_name'], 'required'],
            [['departament_id'], 'integer'],
            [['date_hire'], 'safe'],
            [['member_name'], 'string', 'max' => 100],
            [['departament_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['departament_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'departament_id' => 'Departament ID',
            'member_name' => 'Member Name',
            'date_hire' => 'Date Hire',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartament()
    {
        return $this->hasOne(Department::className(), ['id' => 'departament_id']);
    }
}
