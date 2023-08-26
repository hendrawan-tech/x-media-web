<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'apps' => [
        'name' => 'Apps',
        'index_title' => 'Apps List',
        'new_title' => 'New App',
        'create_title' => 'Create App',
        'edit_title' => 'Edit App',
        'show_title' => 'Show App',
        'inputs' => [
            'title' => 'Title',
            'image' => 'Image',
            'description' => 'Description',
            'type' => 'Type',
        ],
    ],

    'invoices' => [
        'name' => 'Invoices',
        'index_title' => 'Invoices List',
        'new_title' => 'New Invoice',
        'create_title' => 'Create Invoice',
        'edit_title' => 'Edit Invoice',
        'show_title' => 'Show Invoice',
        'inputs' => [
            'external_id' => 'External Id',
            'invoice_url' => 'Invoice Url',
            'price' => 'Price',
            'status' => 'Status',
            'user_id' => 'User',
        ],
    ],

    'packages' => [
        'name' => 'Packages',
        'index_title' => 'Packages List',
        'new_title' => 'New Package',
        'create_title' => 'Create Package',
        'edit_title' => 'Edit Package',
        'show_title' => 'Show Package',
        'inputs' => [
            'name' => 'Name',
            'price' => 'Price',
            'month' => 'Month',
            'speed' => 'Speed',
            'description' => 'Description',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'role' => 'Role',
            'user_meta_id' => 'User Meta',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
