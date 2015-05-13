<?php

namespace GintonicCMS\Model\Table;

use Cake\I18n\Time;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    /**
     * TODO: doccomment
     */
    public function validationDefault(Validator $validator)
    {
        return $validator
                ->notEmpty('email', __('A username is required'))
                ->notEmpty('role', __('A role is required'))
                ->add('email', [
                    'unique' => [
                        'rule' => ['validateUnique'],
                        'provider' => 'table',
                        'message' => __('Email adress already exists.')
                    ]
                ])
                ->requirePresence('password')
                ->notEmpty('password', ['message' => __('Please enter password.')]);
    }

    /**
     * TODO: doccomment
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->primaryKey('id');
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always'
                ]
            ]
        ]);
        $this->addBehavior('GintonicCMS.File', [
            'allowedTypes' => ['image/png', 'image/jpeg', 'image/gif']
        ]);

        $this->addAssociations([
            'belongsTo' => ['Files'],
            'belongsToMany' => ['Threads']
        ]);
    }

    /**
     * TODO: blockquote
     */
    public function findUsersDetails(Query $query, array $options)
    {
        return $query
                ->where($options)
                ->contain(['Files' => ['fields' => ['Files.id', 'Files.filename']]])
                ->first();
    }

    /**
     * TODO: doccomment
     */
    public function verifyUser(Entity $user, $token)
    {
        $user->verified = true;
        if ($this->save($user)) {
            return true;
        }
        return false;
    }

    /**
     * TODO: doccomment
     */
    public function sendPasswordRecovery(Entity $user)
    {
        //unset($user->password);
        $user->token = md5(uniqid(rand(), true));
        $user->token_creation = date("Y-m-d H:i:s");

        $this->save($user);
        if ($user->sendRecovery()) {
            return true;
        }
        return false;
    }

    /**
     * TODO: doccomment
     */
    public function verifyToken($userId, $token)
    {
        $user = $this->find('usersDetails', ['Users.id' => $userId]);

        if (!empty($user) && $user->token == $token) {
            $time = new Time($user->token_creation);
            if (!$time->wasWithinLast('+1 day')) {
                return false;
            }
        }
        return true;
    }

    /**
     * TODO: doccomment
     */
    public function sendVerification(Entity $user, $email)
    {
        $user->token = md5(uniqid(rand(), true));
        $user->token_creation = date("Y-m-d H:i:s");
        if ($this->save($user)) {
            return $user->sendVerification();
        }
        return false;
    }

    /**
     * TODO: doccomment
     */
    public function recoverPassword($userInfo, $userId)
    {
        $userInfo['id'] = $userId;
        $userInfo['password'] = $userInfo['new_password'];
        $userInfo['token'] = md5(uniqid(rand(), true));
        $userInfo['token_creation'] = date("Y-m-d H:i:s");
        $users = $this->newEntity($userInfo);
        return $this->save($users);
    }

    /**
     * TODO: doccomment
     */
    public function changePassword($passwordInfo, $userId = null)
    {
        $user = $this->get($userId);
        $passwordInfo['password'] = $passwordInfo['new_password'];
        $users = $this->patchEntity($user, $passwordInfo);

        if ($this->save($users)) {
            return true;
        }
        return false;
    }
}
