<?php

namespace jarrus90\WebsiteComments\Models;

use Yii;
use yii\db\ActiveRecord;
use jarrus90\User\models\User;
use jarrus90\User\models\Profile;

class Comment extends ActiveRecord {

    public $user_name;
    /** @inheritdoc */
    public static function tableName() {
        return '{{%website_comments}}';
    }

    public function scenarios() {
        return [
            'create' => ['content'],
            'update' => ['content'],
            'search' => ['content', 'from_id', 'created_at', 'parent_id', 'user_name', 'is_blocked'],
            'block' => ['is_blocked', 'blocked_by', 'blocked_at']
        ];
    }

    public function attributeLabels() {
        return [
            'content' => Yii::t('website-comments', 'Content'),
            'from_id' => Yii::t('website-comments', 'From'),
            'is_blocked' => Yii::t('website-comments', 'Is blocked'),
            'created_at' => Yii::t('website-comments', 'Created at')
        ];
    }

    /**
     * Validation rules
     * @return array
     */
    public function rules() {
        return [
            'required' => [['content', 'from_id'], 'required', 'on' => ['create', 'update']],
            'safeSearch' => [['content', 'from_id', 'created_at', 'parent_id', 'user_name'], 'safe', 'on' => ['search']],
            'userExists' => ['from_id', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id', 'on' => ['create', 'update']],
            'parentExists' => ['parent_id', 'exist', 'targetClass' => Comment::className(), 'targetAttribute' => 'id', 'on' => ['create', 'update']],
        ];
    }

    public function setItem($item) {
        if ($item instanceof Comment) {
            $this->id = $item->id;
            $this->setAttributes($item->getAttributes(), false);
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
    
    public function block($user_id){
        $this->scenario = 'block';
        $this->setAttributes([
            'is_blocked' => true,
            'blocked_at' => time(),
            'blocked_by' => $user_id
        ], false);
        return $this->save();
    }
    
    public function unblock($user_id){
        $this->scenario = 'block';
        $this->setAttributes([
            'is_blocked' => false,
            'blocked_at' => time(),
            'blocked_by' => $user_id
        ], false);
        return $this->save();
    }

    /**
     * Search categories list
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params, $parentIsNull = false) {
        $query = static::find()->with(['from']);
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
            $query->andFilterWhere(['is_blocked' => $this->is_blocked]);
            if($parentIsNull) {
                $query->andWhere(['parent_id' => $this->parent_id]);
            } else {
                $query->andFilterWhere(['parent_id' => $this->parent_id]);
            }
            if($this->user_name) {
                $query->andFilterWhere(['or',
                    ['like', Profile::tableName() . '.name', Yii::$app->request->get('name', NULL)],
                    ['like', Profile::tableName() . '.surname', Yii::$app->request->get('name', NULL)]
                ]);
            }
        }
        return $dataProvider;
    }
    
    public function getSearchUserData() {
        if(!empty($this->from_id) && is_int($this->from_id)) {
            $profile = Profile::findOne(['user_id' => $this->from_id]);
            return [
                'id' => $this->from_id,
                'name' => "{$profile->name} {$profile->surname}"
            ];
        }
        return;
    }
    
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)) {
            if($this->isAttributeChanged('content')) {
                $this->content = nl2br(htmlspecialchars(strip_tags($this->content)));
            }
            return true;
        }
        return false;
    }
    
    public function delete() {
        if(parent::delete()) {
            foreach($this->childs AS $child) {
                $child->delete();
            }
        }
        return false;
    }

}
