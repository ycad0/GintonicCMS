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
            'belongsTo' => ['GintonicCMS.Files'],
            'belongsToMany' => ['GintonicCMS.Threads']
        ]);
    }

    /**
     * TODO: blockquote
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
     * TODO: blockquote
     */
    public function findProfile(Query $query, array $options)
    {
        return $query
            ->find('avatar')
            ->conditions(['Users.id' => $options])
            ->first();
    }

    /**
     * TODO: doccomment
     */
    public function changePassword($newPassword, $userId)
    {
        $user = $this->get($userId);

        // TODO: make sure to test that the password is correctly
        // encrypted and updated
        $users = $this->patchEntity($user, $passwordInfo);

        return $this->save($users);
    }
}
