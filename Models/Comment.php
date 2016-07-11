<?php

namespace jarrus90\WebsiteComments\Models;

use Yii;
use yii\db\ActiveRecord;
use jarrus90\User\models\User;
use jarrus90\User\models\Profile;

class Comment extends ActiveRecord {

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

    public function attributeLabels() {
        return [
            'content' => Yii::t('website-comments', 'Content'),
        ];
    }

    /**
     * Validation rules
     * @return array
     */
    public function rules() {
        return [
            'required' => [['content', 'from_id'], 'required', 'on' => ['create', 'update']],
            'safeSearch' => [['content', 'from_id', 'created_at', 'parent_id'], 'safe', 'on' => ['search']],
            'userExists' => ['from_id', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id', 'on' => ['create', 'update']],
            'parentExists' => ['parent_id', 'exist', 'targetClass' => Comment::className(), 'targetAttribute' => 'id', 'on' => ['create', 'update']],
        ];
    }

    public function setItem($item) {
        if ($item instanceof Comment) {
            $this->id = $item->id;
            $this->setAttributes($item->getAttributes());
            $this->setIsNewRecord($item->getIsNewRecord());
        }
    }

    public function formName() {
        if ($this->scenario == 'search') {
            return '';
        }
        return parent::formName();
    }

    /**
     * Get parent
     * @return Comment
     */
    public function getParent() {
        return $this->hasOne(Comment::className(), ['id' => 'parent_id']);
    }

    /**
     * Get list of childs
     * @return Comment[]
     */
    public function getChilds() {
        return $this->hasMany(Comment::className(), ['parent_id' => 'id']);
    }

    /**
     * Get profile of creator
     * @return Profile
     */
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
