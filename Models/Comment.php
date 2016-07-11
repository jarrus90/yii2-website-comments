<?php

namespace jarrus90\WebsiteComments\Models;

use Yii;
use yii\db\ActiveRecord;
use jarrus90\User\models\Profile;
class Comment extends ActiveRecord {
    
    /**
     * @var Reply 
     */
    public $item;
    
    /** @inheritdoc */
    public static function tableName() {
        return '{{%website_comments}}';
    }

    public function scenarios() {
        return [
            'create' => ['content', 'from_id', 'created_at', 'parent_id'],
            'update' => ['content'],
            'search' => ['content', 'from_id', 'created_at', 'parent_id'],
        ];
    }
    
    public function attributeLabels(){
        return [
            'content' => Yii::t('support', 'Content'),
        ];
    }

    /**
     * Validation rules
     * @return array
     */
    public function rules() {
        return [
            'required' => [['content'], 'required', 'on' => ['create', 'update']],
            'safeSearch' => [['content', 'from_id', 'created_at', 'parent_id'], 'safe', 'on' => ['search']],
            'userExists' => ['from_id', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
        ];
    }

    /** @inheritdoc */
    public function init() {
        parent::init();
        if ($this->item instanceof Reply) {
            $this->id = $this->item->id;
            $this->setAttributes($this->item->getAttributes());
            $this->setIsNewRecord($this->item->getIsNewRecord());
        }
    }
    
    public function formName() {
        if($this->scenario == 'seacrh') {
            return;
        }
        return parent::formName();
    }
    
    public function getParent() {
        return $this->hasOne(Reply::className(), ['id' => 'parent_id']);
    }
    
    public function getChilds() {
        return $this->hasMany(Reply::className(), ['parent_id' => 'id']);
    }
    
    public function getFrom() {
        return $this->hasOne(Profile::className(), ['user_id' => 'from_id']);
    }

    /**
     * Search categories list
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params) {
        $query = static::find()->with('from');
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'content', $this->content]);
            $query->andFilterWhere(['from_id' => $this->from_id]);
            $query->andWhere(['parent_id' => $this->parent_id]);
        }
        return $dataProvider;
    }

}