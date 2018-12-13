<?php

namespace app\models\department;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property int $id
 * @property string $name
 *
 * @property StaffMember[] $staffMembers
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['name'], 'unique', 'message' => 'Department name must be unique.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app','Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffMembers()
    {
        return $this->hasMany(StaffMember::className(), ['department_id' => 'id']);
    }
}
