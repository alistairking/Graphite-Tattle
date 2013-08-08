<?php

// DATABASE TYPE
// Right now, only 'mysql' is supported
$GLOBALS['DATABASE_TYPE'] = 'mysql';

// DATABASE SETTINGS
$GLOBALS['DATABASE_HOST'] = 'sock:/tmp/mysql.sock';
#$GLOBALS['DATABASE_PORT'] = '3306';
$GLOBALS['DATABASE_NAME'] = 'charthouse_tattle';
$GLOBALS['DATABASE_USER'] = 'telescp';
$GLOBALS['DATABASE_PASS'] = '';
$GLOBALS['TATTLE_DOMAIN'] = 'http://thor.caida.org:8353/tattle';

// GRAPHITE and GANGLIA Settings
$GLOBALS['PRIMARY_SOURCE'] = 'GRAPHITE'; //Currently can be GRAPHITE or GANGLIA
$GLOBALS['GRAPHITE_URL'] = 'http://localhost:8353';
#$GLOBALS['GANGLIA_URL'] = 'http://localhost:8000/ganglia2';
$GLOBALS['PROCESSOR_GRAPHITE_URL'] = $GLOBALS['GRAPHITE_URL'];

// Graph Styling
$GLOBALS['ERROR_COLOR'] = 'red';
$GLOBALS['WARN_COLOR'] = 'yellow';
$GLOBALS['GRAPH_WIDTH'] = '586';
$GLOBALS['GRAPH_HEIGHT'] = '308';
$GLOBALS['WHISPER_DIR'] = '/db/graphite/whisper/';

// Flourish Related Settings
$GLOBALS['FLOURISHLIB_PATH'] = 'inc/flourish/';
$GLOBALS['SESSION_FILES'] = '/tmp';

// Processor Logging Files
$GLOBALS['PROCESSOR_LOG_PATH'] = '/db/graphite/log/tattle';
// Bootstrap Settings
$GLOBALS['BOOTSTRAP_PATH'] = 'bootstrap/';

// Allow HTTP auth as user management
$GLOBALS['ALLOW_HTTP_AUTH'] = false;

// Number of elements per page (checks, alerts, subscriptions)
$GLOBALS['PAGE_SIZE'] = 15;

// Locale settings
$GLOBALS['TIMEZONE'] = 'Etc/UTC';

