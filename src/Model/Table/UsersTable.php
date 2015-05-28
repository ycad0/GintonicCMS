<?php

/**
 * GintonicCMS : Full Stack Content Management System (http://cms.gintonicweb.com)
 * Copyright (c) Philippe Lafrance, Inc. (http://phillafrance.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Philippe Lafrance (http://phillafrance.com)
 * @link          http://cms.gintonicweb.com GintonicCMS Project
 * @since         0.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace GintonicCMS\Model\Table;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Represents the Users Table
 *
 * Contain the actions for user related things like change password,
 * find profile etc.
 */
class UsersTable extends Table
{
    /**
     * Validate user input while interaction with user.
     * validation may contain like username must not empty,
     * role of the user is require,
     * email address must be valid and unique across the existing records.
     *
     * @param Cake\Validation\Validator $validator Instance of validator
     * @return Cake\Validation\Validator Instance of validator
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
     * TODO: Write Document.
     */
    public function validationChangePassword(Validator $validator)
    {
        return $validator
                ->notEmpty('current_password', ['message' => __('Current Password is required')])
                ->notEmpty('new_password', ['message' => __('New Password is required')])
                ->notEmpty('confirm_password', ['message' => __('Confirm Password is required')]);
    }

    /**
     * Initilize the Users Table.
     * also set Relationship of this Table with other tables and add
     * required behaviour for this Table.
     *
     * @param array $config configuration array for Table.
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
            'belongsTo' => ['GintonicCMS.Files'],
            'belongsToMany' => ['GintonicCMS.Threads']
        ]);
    }

    /**
     * Dynamic finder that find User Avatar.
     *
     * @param \Cake\ORM\Query $query the original query to append to
     * @param array $options null
     * @return \Cake\ORM\Query The amended query
     */
    public function findAvatar(Query $query, array $options)
    {
        return $query
                ->contain([
                    'Files' => [
                        'fields' => ['Files.id', 'Files.filename']
                    ]
                ]);
    }

    /**
     * Dynamic finder that find User Profile.
     *
     * @param \Cake\ORM\Query $query the original query to append to
     * @param array $options containing id of User.
     * @return \Cake\ORM\Query The amended query
     */
    public function findProfile(Query $query, array $options)
    {
        return $query
                ->find('avatar')
                ->conditions(['Users.id' => $options])
                ->first();
    }

    /**
     * Change the user password. its take new password and user Id
     * as argument and return true if password change successfully else false.
     *
     * @param string $newPassword new password supplied by user.
     * @param int $userId unique id of user.
     * @return true|false return True if password change successfully else return false.
     */
    public function changePassword($passwordInfo, $userId)
    {
        $user = $this->get($userId);
        $verify = (new DefaultPasswordHasher)
            ->check($passwordInfo['current_password'], $user->password);
        if ($verify) {
            $user->password = $passwordInfo['new_password'];
            $users = $this->patchEntity($user, $passwordInfo, ['validate' => 'changePassword']);
            return $this->save($users);
        }
        return false;
    }
}
