<?php

return [
    ['name' => 'Admin control',
        'children' => [
            ['name' => 'Users',
                'children' => [
                    ['name' => 'Users', 'route' => 'users.index', 'access' => 'Readers Admin Control',],
                    ['name' => 'Groups', 'route' => 'groups.index', 'access' => 'Readers Admin Control'],
                    ['name' => 'Access control', 'route' => 'access-control.index', 'access' => 'Readers Admin Control'],
                ]
            ],

        ],
    ],

    ['name' => 'Activities',
    'children' => [
        ['name' => 'To-Dos',
        'children' => [
          ['name' => 'To Do', 'route' => 'todos.index', 'access' => 'Readers Services', 'tenant_permission' => 'To Do']
        ]
   ],

    ],
 ],


    ];
