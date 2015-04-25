<?php

namespace GintonicCMS\Model\Table;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\I18n\Time;
use Cake\Network\Email\Email;
use Cake\Network\Session;
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
        $this->addAssociations([
            'belongsTo' => ['Files' => [
                'className' => 'GintonicCMS.Files',
                'foreignKey' => 'file_id',
                'propertyName' => 'file'
            ]],
        ]);
    }
    
    /**
     * TODO: doccomment
     */
    public function isValidated($email)
    {
        $user = $this->safeRead(['email' => $email]);
        if (!isset($user)) {
            return false;
        }
        return $user->validated;
    }
    
    /**
     * TODO: doccomment
     */
    public function signupMail($email)
    {
        $user = $this->safeRead(['email' => $email]);
        if (!empty($user)) {
            unset($user->password);
            $user->token = md5(uniqid(rand(), true));
            $user->token_creation = date("Y-m-d H:i:s");
            ;
            $this->save($user);
            $this->sendSignupMail($user);
        }
        return true;
    }
    
    /**
     * TODO: doccomment
     */
    public function sendSignupMail($user)
    {
        $email = new Email();
        $email->profile('default');
        $email->viewVars(array('userId' => $user->id, 'token' => $user->token));
        $email->template('GintonicCMS.signup')
             ->emailFormat('html')
             ->to($user->email)
             ->from(Configure::read('admin_mail'))
             ->subject('Account validation');
        return $email->send();
    }
    
    /**
     * TODO: doccomment
     */
    public function safeRead($conditions = null, $withPassword = false)
    {
        $this->data = $this->find()
            ->where([$conditions])
            ->contain(['Files' => ['fields' => ['Files.id', 'Files.filename']]])
            ->first();
        if (empty($this->data['file'])) {
            $this->data['file'] = ['id' => 0, 'filename' => 'default'];
        }
        if (isset($this->data->password) && empty($withPassword)) {
            unset($this->data->password);
        }
        return $this->data;
    }
    
    /**
     * TODO: doccomment
     */
    public function confirmation($userId, $token)
    {
        $user = $this->safeRead(['Users.id' => $userId]);
        if (!$user) {
            return false;
        }
        if ($user['token'] != $token) {
            return false;
        }
        $user['validated'] = true;
        if (!$this->save($user)) {
            return false;
        }
        return $user;
    }
    
    /**
     * TODO: doccomment
     */
    public function forgotPasswordEmail($email)
    {
        $user = $this->safeRead(['email' => $email]);
        $response = [
            'status' => 'fail',
            'message' => 'Unable to send forgot password email, Please try again'
        ];
        if (empty($user)) {
            return array('status' => 'fail', 'message' => 'No matching email found');
        }
        unset($user->password);
        $user->token = md5(uniqid(rand(), true));
        $user->token_creation = date("Y-m-d H:i:s");

        $this->save($user);
        if ($this->sendForgotPasswordEmail($user)) {
            $response = [
                'status' => 'success',
                'message' => 'Please check your e-mail for forgot password'
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
    public function checkForgotPassword($userId, $token)
    {
        $response = [
            'status' => 'fail',
            'message' => 'Invalid forgot password token'
        ];
        $user = $this->safeRead(['Users.id' => $userId]);
        if (!empty($user) && $user->token == $token) {
            $time = new Time($this->data->token_creation);
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
        $user = $this->safeRead(['email' => $email]);
        if (empty($user)) {
            return [
                'status' => 'fail',
                'message' => 'No matching email found. Please try with correct email address.'
            ];
        } elseif (!empty($user['validated'])) {
            return [
                'status' => 'fail',
                'message' => 'Your email address is already validated, please use email and password to login'
            ];
        } else {
            $user['token'] = md5(uniqid(rand(), true));
            $user['token_creation'] = date("Y-m-d H:i:s");
            $this->save($user);
            $this->resendVerificationEmail($user);
            return [
                'status' => 'success',
                'message' => __('The email was resent. Please check your inbox.')
            ];
        }
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
}
