<?php
namespace app\models;

use app\core\Auth;
use app\core\Authenticable;
use app\core\Model;

class User extends Model implements Authenticable
{
    public $name;
    public $email;
    public $password;
    public $confirmPassword;

    public function rules()
    {
        return [
            'name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
//            'password' => [self::RULE_REQUIRED, self::RULE_MIN.':3'],
            'confirmPassword' => [self::RULE_REQUIRED, self::RULE_MATCH.':password']
        ];
    }

    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        parent::save();
    }

    protected function getAttributes()
    {
        return ['name', 'email', 'password'];
    }

    protected static function getTableName()
    {
        return 'users';
    }
}
