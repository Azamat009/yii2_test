<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=yii_postgres;dbname=yii',
    'username' => 'yii',
    'password' => 'password',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
