<?php

return 
[
    [
    'user'     => 'ADMIN',
    'resource' => 
        [
            'MasterUser', 
            'MasterTenant', 
            'MasterSubunit',
            'MasterUnit',
            'MasterRoom',
            'MasterDepartment',
            'MasterFacility',
            'Complaint',
            'Suggest',
            'ViewSuggest',
            'Report1',
            'Report2',
            'Report3',
            'Report4',
        ]
    ],
    [
    'user'     => 'MANAGER',
    'resource' => 
        [
            'ViewSuggest',
            'Report1',
            'Report2',
            'Report3',
            'Report4',
        ]
    ],
    [
    'user'     => 'SPV_TEKNISI',
    'resource' => 
        [
            'ViewSuggest',
            'Report1',
            'Report2',
            'Report3',
            'Report4',
        ]
    ],

    
];
