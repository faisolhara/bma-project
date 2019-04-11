<?php

return  
[
    [
    'label' => 'master',
    'children' => 
        [
            [
            'icon'      => 'icon mdi mdi-accounts',
            'label'     => 'master-user',
            'route'     => 'master-user',
            'resource'  => 'MasterUser',
            ],
            [
            'icon'      => 'icon mdi mdi-accounts-list',
            'label'     => 'master-tenant',
            'route'     => 'master-tenant',
            'resource'  => 'MasterTenant',
            ],
            [
            'icon'      => 'icon mdi mdi-washing-machine',
            'label'     => 'master-subunit',
            'route'     => 'master-subunit',
            'resource'  => 'MasterSubunit',
            ],
            [
            'icon'      => 'icon mdi mdi-seat',
            'label'     => 'master-unit',
            'route'     => 'master-unit',
            'resource'  => 'MasterUnit',
            ],
            [
            'icon'      => 'icon mdi mdi-local-hotel',
            'label'     => 'master-room',
            'route'     => 'master-room',
            'resource'  => 'MasterRoom',
            ],
            [
            'icon'      => 'icon mdi mdi-wrench',
            'label'     => 'master-department',
            'route'     => 'master-department',
            'resource'  => 'MasterDepartment',
            ],
            [
            'icon'      => 'icon mdi mdi-local-wc',
            'label'     => 'master-facility',
            'route'     => 'master-facility',
            'resource'  => 'MasterFacility',
            ],
        ],
    ],
    [
    'label' => 'transaction',
    'children' =>
        [
            [
            'icon'      => 'icon mdi mdi-phone-in-talk',
            'label'     => 'complaint',
            'route'     => 'complaint',
            'resource'  => 'Complaint',
            ],
            [
            'icon'      => 'icon mdi mdi-email',
            'label'     => 'suggest',
            'route'     => 'suggest',
            'resource'  => 'Suggest',
            ],
        ]
    ],
    [
    'label' => 'report',
    'children' =>
        [
            [
            'icon'      => 'icon mdi mdi-comments',
            'label'     => 'view-suggest',
            'route'     => 'view-suggest',
            'resource'  => 'ViewSuggest',
            ],
            [
            'icon'      => 'icon mdi mdi-phone-msg',
            'label'     => 'report1',
            'route'     => 'report1',
            'resource'  => 'Report1',
            ],
            [
            'icon'      => 'icon mdi mdi-phone-forwarded',
            'label'     => 'report2',
            'route'     => 'report2',
            'resource'  => 'Report2',
            ],
            [
            'icon'      => 'icon mdi mdi-star',
            'label'     => 'report3',
            'route'     => 'report3',
            'resource'  => 'Report3',
            ],
            [
            'icon'      => 'icon mdi mdi-star-outline',
            'label'     => 'report4',
            'route'     => 'report4',
            'resource'  => 'Report4',
            ],
        ],
    ]
];
