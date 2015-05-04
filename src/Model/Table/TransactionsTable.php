<?php

namespace GintonicCMS\Model\Table;

use Cake\ORM\Table;

class TransactionsTable extends Table
{
    /**
     * 
     * TODO: write comment.
     */
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always'
                ]
            ]
        ]);
        
        $this->addAssociations([
            'belongsTo' => [
                'Users' => [
                    'className' => 'Users',
                    'foreignKey' => 'user_id',
                    'propertyName' => 'Users'
                ],
                'TransactionTypes' => [
                    'className' => 'TransactionTypes',
                    'foreignKey' => 'transaction_type_id',
                    'propertyName' => 'TransactionTypes'
                ]
            ]
        ]);
    }
    
    /**
     * TODO: write comment
     */
    public function addTransaction($arrDetail = [], $userId = null)
    {
        if(empty($userId)){
            $userId = 0;
        }
        $arrTransaction = [
            'user_id' => $userId,
            'transaction_type_id' => $arrDetail['transaction_type_id'],
            'fixed_price' => $arrDetail['fixed_price'],
            'amount' => ($arrDetail['stripe']->amount / 100), // Convert to amount
            'currency' => $arrDetail['stripe']->currency,
            'transaction_id' => $arrDetail['stripe']->id,
            'customer_id' => $arrDetail['stripe']->customer,
            'email' => $arrDetail['stripe']['source']->name,
            'brand' => $arrDetail['stripe']['source']->brand,
            'last4' => $arrDetail['stripe']['source']->last4,
            'paid' => $arrDetail['stripe']->paid,
            'captured' => (isset($arrDetail['stripe']->captured)?$arrDetail['stripe']->captured:''),
        ];
        if(isset($arrDetail['plan_id'])){
            $arrTransaction['plan_id']=$arrDetail['plan_id'];
        }
        if(isset($arrDetail['plan_name'])){
            $arrTransaction['plan_name']=$arrDetail['plan_name'];
        }
        $transaction = $this->newEntity($arrTransaction);
        $transaction = $this->save($transaction);
        return $transaction;
    }
    
    /**
     * TODO: Write Comment
     */
    public function afterTransaction()
    {
        //Handle after Payment process here.
    }
}
