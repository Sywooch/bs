<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property string $id
 * @property string $email
 * @property string $password
 * @property int $role
 * @property string $last_login
 * @property string $name
 * @property string $surname
 * @property string $phone
 * @property string $address
 * @property string $created_at
 * @property string $updated_at
 * @property string $blocked_at
 * @property int $status
 * @property string $version
 */
class User extends CustomActiveRecord implements IdentityInterface
{
    const USER_BUYER = 1;
    const USER_MANAGER = 128;
    const USER_ADMIN = 250;

    public $authKey;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'role', 'name', 'surname'], 'required'],
            [['email', 'password','name', 'surname', 'phone', 'address'], 'filter', 'filter' => 'trim'],
            [['email'], 'unique'],
            [['role', 'last_login', 'created_at', 'updated_at', 'blocked_at', 'status', 'version'], 'integer'],
            [['email'], 'string', 'length' => [5, 50]],
            [['password'], 'string', 'length' => [6, 18]],
            [['name', 'surname'], 'string', 'max' => 25],
            [['phone'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'role' => Yii::t('app', 'Role'),
            'last_login' => Yii::t('app', 'Last Login'),
            'name' => Yii::t('app', 'Name'),
            'surname' => Yii::t('app', 'Surname'),
            'phone' => Yii::t('app', 'Phone'),
            'address' => Yii::t('app', 'Address'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'blocked_at' => Yii::t('app', 'Blocked At'),
            'status' => Yii::t('app', 'Status'),
            'version' => Yii::t('app', 'Version'),
        ];
    }

    /**
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
//            'authenticator' => [
//                'class' => HttpBasicAuth::className(),
//                'realm' => 'Protected area',
//                'auth' => function($username, $password) {
//                    $user = User::findByUsername($username);
//                    if ($user && $user->validatePassword($password)) {
//                        return $user;
//                    } else {
//                        return null;
//                    }
//                }
//            ],
            'TimestampBehavior' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @param $password
     * @return string
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        return $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        return $this->authKey = Yii::$app->security->generateRandomString();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Return user Role
     *
     * @return int
     */
    public static function getRole()
    {
        return Yii::$app->user->identity['role'];
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id,
            'status' => self::STATUS_ACTIVE
        ]);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return void|IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
//        return static::findOne(['access_token' => $token]);
        throw new NotSupportedException('findIdentityByAccessToken is not implemented');
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     *
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     *
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     *
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
