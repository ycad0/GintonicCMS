<?php

namespace GintonicCMS\Model\Table;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\Network\Email\Email;
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
            'belongsTo' => ['Files' => [
                    'className' => 'GintonicCMS.Files',
                    'foreignKey' => 'file_id',
                    'propertyName' => 'file'
                ]],
        ]);
    }

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
    public function verifyUser($userId, $token)
    {
        $response = [
            'success' => false,
            'class' => 'alert-danger',
            'message' => __('Error occure while validate your account. Please try again.')
        ];

        if (empty($userId) || empty($token)) {
            return $response = [
                'success' => false,
                'message' => __('The authorization link provided is erroneous, please contact an administrator.'),
                'class' => 'alert-danger',
            ];
        }

        $user = $this->find('usersDetails', ['Users.id' => $userId]);

        if (!empty($user['verified'])) {
            $response = [
                'success' => true,
                'alreadyVarified' => true,
                'class' => 'alert-success',
                'message' => __('Your email address is already validated.')
            ];
        } else if (!empty($user)) {

            if ($user['token'] != $token) {
                $response = [
                    'success' => false,
                    'message' => __('Error occure while validate your account. Please try again.')
                ];
            } else {
                $user['verified'] = true;
                if ($this->save($user)) {
                    $response = [
                        'success' => true,
                        'class' => 'alert-success',
                        'user' => $user,
                        'message' => __('Email address has been successfuly validated.')
                    ];
                }
            }
        }
        return $response;
    }

    /**
     * TODO: doccomment
     */
    public function sendPasswordRecovery($email)
    {
        $user = $this->find('usersDetails', ['email' => $email]);

        $response = [
            'status' => false,
            'class' => 'alert-danger',
            'message' => 'Error occure while sending password recovery email.'
        ];
        if (empty($user)) {
            return [
                'status' => false,
                'class' => 'alert-danger',
                'message' => 'No matching email address found.'
            ];
        }
        unset($user->password);
        $user->token = md5(uniqid(rand(), true));
        $user->token_creation = date("Y-m-d H:i:s");

        $this->save($user);
        if ($this->sendForgotPasswordEmail($user)) {
            $response = [
                'status' => true,
                'class' => 'alert-success',
                'message' => 'An email was sent with password recovery instructions.'
            ];
        }
        return $response;
    }

    /**
     * TODO: doccomment
     */
    public function sendForgotPasswordEmail($user)
    {
        $email = new Email('default');
        $email->viewVars(array('userId' => $user->id, 'token' => $user->token));
        $email->template('GintonicCMS.forgot_password')
            ->emailFormat('html')
            ->to($user->email)
            ->from([Configure::read('admin_mail') => Configure::read('site_name')])
            ->subject('Forgot Password');
        return $email->send();
    }

    /**
     * TODO: doccomment
     */
    public function findCustomPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }

    /**
     * TODO: doccomment
     */
    public function verifyToken($userId, $token)
    {
        $response = [
            'status' => 'fail',
            'message' => 'Invalid forgot password token'
        ];

        $user = $this->find('usersDetails', ['Users.id' => $userId]);

        if (!empty($user) && $user->token == $token) {
            $time = new Time($user->token_creation);
            if (!$time->wasWithinLast('+1 day')) {
                $response = [
                    'status' => 'fail',
                    'message' => 'Forgot Password token is expired'
                ];
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Valid Token'
                ];
            }
        }
        return $response;
    }

    /**
     * TODO: doccomment
     */
    public function resendVerification($email)
    {
        $user = $this->find('usersDetails', ['email' => $email]);

        if (empty($user)) {
            $response = [
                'success' => false,
                'class' => 'alert-danger',
                'message' => __('No matching email found. Please try with correct email address.')
            ];
        } elseif (!empty($user['validated'])) {
            $response = [
                'success' => false,
                'class' => 'alert-info',
                'message' => __('Your email address is already validated.')
            ];
        } else {
            $user['token'] = md5(uniqid(rand(), true));
            $user['token_creation'] = date("Y-m-d H:i:s");
            $this->save($user);
            $this->resendVerificationEmail($user);
            $response = [
                'success' => false,
                'class' => 'alert-success',
                'message' => __('The email was resent. Please check your inbox.')
            ];
        }
        return $response;
    }

    /**
     * TODO: doccomment
     */
    public function resendVerificationEmail($user)
    {
        $email = new Email('default');
        $email->viewVars([
            'userId' => $user->id,
            'token' => $user->token, 'user' => $user
        ]);
        $email->template('GintonicCMS.resend_code')
            ->emailFormat('html')
            ->to($user->email)
            ->from([Configure::read('admin_mail') => Configure::read('site_name')])
            ->subject('Account validation');
        return $email->send();
    }

    public function recoverPassword($passwordInfo, $userId)
    {
        $response = [
            'success' => false,
            'message' => __('Error occure while reseting your password, Please try again.')
        ];
        if ($passwordInfo['new_password'] != $passwordInfo['confirm_password']) {
            $response = [
                'success' => false,
                'message' => __('New Password and Confirm Password must be same.')
            ];
        } else {
            $passwordInfo['id'] = $userId;
            $passwordInfo['password'] = $passwordInfo['new_password'];
            $passwordInfo['token'] = md5(uniqid(rand(), true));
            $passwordInfo['token_creation'] = date("Y-m-d H:i:s");
            $users = $this->newEntity($passwordInfo);
            $this->save($users);
            $response = [
                'success' => true,
                'message' => __('Your password has been updated successfully.')
            ];
        }
        return $response;
    }

    public function changePassword($passwordInfo, $userId = null)
    {
        $response = [
            'success' => false,
            'class' => 'alert-danger',
            'message' => __('Unable to Change Password, Please try again.')
        ];
        $userDetail = $this->get($userId);

        if ($passwordInfo['new_password'] != $passwordInfo['confirm_password']) {
            $response = [
                'success' => false,
                'class' => 'alert-danger',
                'message' => __('Confirm Password entered does not match.')
            ];
        } elseif ($passwordInfo['new_password'] == "") {
            $response = [
                'success' => false,
                'class' => 'alert-danger',
                'message' => __('New Password Must Not Blank.')
            ];
        } else {
            $passwordInfo['id'] = $userId;
            $passwordInfo['password'] = $passwordInfo['new_password'];
            $users = $this->patchEntity($userDetail, $passwordInfo);

            if ($this->save($users)) {
                $response = [
                    'success' => false,
                    'class' => 'alert-success',
                    'message' => __('Password has been updated Successfully.')
                ];
            }
        }
        return $response;
    }
}
