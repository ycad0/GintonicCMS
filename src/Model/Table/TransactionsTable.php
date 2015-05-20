<?php

namespace GintonicCMS\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;

class TransactionsTable extends Table
{
    /**
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
                'Users',
                'TransactionsTypes'
            ]
        ]);
    }

    /**
     * TODO: write comment
     */
    public function findTransactions(Query $query, array $options)
    {
        return $query
            ->where($options)
            ->contain([
                'Users' => function ($q) {
                    return $q
                        ->select(['Users.id', 'Users.first', 'Users.last']);
                },
                'TransactionsTypes' => function ($qt) {
                    return $qt
                            ->select(['TransactionsTypes.name']);
                }
            ])
            ->order(['Transactions.created' => 'desc']);
    }

    /**
     * TODO: write comment
     */
    public function addTransaction($arrDetail = [], $userId = null)
    {
        if (empty($userId)) {
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
            'paid' => $arrDetail['stripe']->paid,
            'captured' => (isset($arrDetail['stripe']->captured) ? $arrDetail['stripe']->captured : ''),
        ];
        if (!empty($arrDetail['stripe']['source'])) {
            $arrTransaction['email'] = $arrDetail['stripe']['source']->name;
            $arrTransaction['brand'] = $arrDetail['stripe']['source']->brand;
            $arrTransaction['paid'] = $arrDetail['stripe']['source']->last4;
        } elseif (!empty($arrDetail['stripe']['card'])) {
            $arrTransaction['email'] = $arrDetail['stripe']['card']->name;
            $arrTransaction['brand'] = $arrDetail['stripe']['card']->brand;
            $arrTransaction['paid'] = $arrDetail['stripe']['card']->last4;
        }
        if (isset($arrDetail['plan_id'])) {
            $arrTransaction['plan_id'] = $arrDetail['plan_id'];
        }
        if (isset($arrDetail['plan_name'])) {
            $arrTransaction['plan_name'] = $arrDetail['plan_name'];
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
