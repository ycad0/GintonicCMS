<?php
/**
 * GintonicCMS : Full Stack Content Management System (http://gintoniccms.com)
 * Copyright (c) Philippe Lafrance (http://phillafrance.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Philippe Lafrance (http://phillafrance.com)
 * @link          http://gintoniccms.com GintonicCMS Project
 * @since         0.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace GintonicCMS\Model\Table;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Query;
use Cake\ORM\ResultSet;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Represents the Users Table
 *
 * A user is the most elementary unit of information necessary to manage
 * connections and permissions.
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
                    'message' => __('This email is already registered')
                ]
            ])
            ->requirePresence('password')
            ->notEmpty('password', ['message' => __('Password cannot be blank')]);
    }

    /**
     * TODO: Write Document.
     */
    public function validationChangePassword(Validator $validator)
    {
        return $validator
            ->notEmpty('current_password', ['message' => __('Current Password is required')])
            ->notEmpty('new_password', ['message' => __('New Password is required')]);
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
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always'
                ]
            ]
        ]);
        $this->addAssociations([
            'belongsToMany' => ['GintonicCMS.Threads'],
            'hasMany' => [
                'Acl.Aros' => [
                    'conditions' => ['Aros.model' => 'Users'],
                    'foreignKey' => 'foreign_key'
                ]
            ]
        ]);
    }

    /**
     * TODO: docblock
     */
    public function bindRoles(ResultSet $users)
    {
        // Avoid loading the association and condition in current model by using
        // the aros directly from the TableRegistry
        $aros = TableRegistry::get('Aros');

        return $users->map(function ($row) use (&$aros) {
            $row->roles = [];

            foreach ($row->aros as $aro) {
                $roles = $aros
                    ->find('path', ['for' => $aro['id']])
                    ->select(['id'])
                    ->distinct();
                $roleGroup = $aros->find()
                    ->where([
                        'Aros.id IN' => $roles,
                    ])
                    ->where(['alias IS NOT' => null])
                    ->hydrate(false);
                foreach ($roleGroup as $role) {
                    $row->roles[] = $role;
                }
            }

            return $row;
        });
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
