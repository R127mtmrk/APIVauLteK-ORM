<?php

return [

    'users' => [
        'id_user' => [
            'type' => 'INT',
            'primary' => true,
            'auto_increment' => true,
            'nullable' => false
        ],
        'email_user' => [
            'type' => 'VARCHAR',
            'length' => 255,
            'nullable' => false
        ],
        'id_card_user' => [
            'type' => 'INT',
            'nullable' => true,
            'foreign' => [
                'table' => 'debit_cards',
                'column' => 'id_card',
                'on_delete' => 'SET NULL',
                'on_update' => 'CASCADE'
            ]
        ],
        'mdp_user' => [
            'type' => 'VARCHAR',
            'length' => 255,
            'nullable' => false
        ],
        'psd_user' => [
            'type' => 'VARCHAR',
            'length' => 100,
            'nullable' => false
        ],
        'role_user' => [
            'type' => 'TINYINT',
            'nullable' => false
        ]
    ],


    'transac' => [
        'id_transac' => [
            'type' => 'INT',
            'primary' => true,
            'auto_increment' => true,
            'nullable' => false
        ],
        'date_transac' => [
            'type' => 'DATETIME',
            'nullable' => true,
        ],
        'id_receiver' => [
            'type' => 'INT',
            'nullable' => true,
            'foreign' => [
                'table' => 'users',
                'column' => 'id_user',
                'on_delete' => 'SET NULL',
                'on_update' => 'CASCADE'
            ]
        ],
        'id_sender' => [
            'type' => 'INT',
            'nullable' => true,
            'foreign' => [
                'table' => 'users',
                'column' => 'id_user',
                'on_delete' => 'SET NULL',
                'on_update' => 'CASCADE'
            ]
        ],
        'msg_transac' => [
            'type' => 'LONGTEXT',
            'nullable' => true
        ],
        'refund_transac' => [
            'type' => 'TINYINT',
            'nullable' => true
        ],
        'sum_transac' => [
            'type' => 'INT',
            'nullable' => true
        ]
    ],


    'debit_cards' => [
        'id_card' => [
            'type' => 'INT',
            'primary' => true,
            'auto_increment' => true,
            'nullable' => false
        ],
        'expiration_date' => [
            'type' => 'CHAR',
            'length' => 5,
            'nullable' => false
        ],
        'id_user_card' => [
            'type' => 'INT',
            'nullable' => true,
            'foreign' => [
                'table' => 'users',
                'column' => 'id_user',
                'on_delete' => 'SET NULL',
                'on_update' => 'CASCADE'
            ]
        ],
        'num_card' => [
            'type' => 'CHAR',
            'length' => 16,
            'nullable' => false
        ]
    ]

];
