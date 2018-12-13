<?php

namespace app\models\member;

use app\models\department\Department;
use DateTime;
use yii\base\Module;

use Yii;

/**
 * This is the model class for table "staff_member".
 *
 * @property int $id
 * @property int $department_id
 * @property string $member_name
 * @property string $date_hire
 *
 * @property Department $department
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
            [['department_id', 'member_name', 'date_hire'], 'required'],
           // [['department_id'], 'integer'],
            [['date_hire'], 'safe'],
            [['member_name'], 'string', 'max' => 100],
            [['member_name'], 'unique', 'message' => 'Member name must be unique.'],
            [['date_hire'], 'validateDate', 'message' => 'Date with invalid format.'],
            [['department_id'], 'exist', 'skipOnError' => true, 
              'targetClass' => Department::className(), 
              'targetAttribute' => ['department_id' => 'id']
            ],
        ];
    }
    
    /**
     * Date validation
     */
    public static function isValidDate($dateVar) {
        if ($dateVar != '') {
            if (strtotime($dateVar) == null) {
                return false;
            }
            $date = date_parse($dateVar);
            if (!checkdate($date["month"], $date["day"], $date["year"])) {
                return false;
            }
        }
        return true;
    }

    /**
     * date validation rule for the model
     */ 
    public function validateDate($attribute, $params) {
        //if (!self::isValidDate($this->$attribute) || !self::validDateFormat($this->$attribute,'m/d/Y')) {
        if (!self::isValidDate($this->$attribute)) {
            $this->addError($attribute, 
                Yii::t('app','Invalid {attribute} (format is MM/DD/YYYY).', 
                        array('attribute' => $this->getAttributeLabel($attribute)))
            );
        }
        
//        if (!self::isValidDateUntil($this->$attribute)) {
//            $this->addError($attribute, 
//                Yii::t('app','Invalid {attribute} cannot be major than one month of difference.', 
//                        array('attribute' => $this->getAttributeLabel($attribute)))
//            );
//        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'department_id' => Yii::t('app','Department'),
            'member_name' => Yii::t('app','Member Name'),
            'date_hire' => Yii::t('app','Date of Hire'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }
    
    
    /**
     * @description Validation Next Month 
     * @param type $date
     * @return boolean
     */
//    public static function isValidDateUntil($date){
//        $dateNextMonth = date('Y-m-d', strtotime('+1 month'));
//        if(date_create($date)>$dateNextMonth){
//            return false;
//        }
//        return true;
//    }
//
//    public static function validDateFormat($date, $format = 'Y-m-d H:i:s')
//    {
//        $d = DateTime::createFromFormat($format, $date);
//        return $d && $d->format($format) == $date;
//    }
}
