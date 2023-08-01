<?php
    // DB接続設定（MySQL用）
    define('DSN', "sqlsrv:server = tcp:22yn0120db.database.windows.net,1433; Database = 22yn0120DB", "jndb", "{your_password_here}");
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');

	// DB接続設定
	// define('DSN', 'sqlsrv:server = tcp:22yn0120db.database.windows.net,1433; Database = 22yn0120DB", "jndb", "{your_password_here}');
	// define('DB_USER', '22yn0120');
	// define('DB_PASSWORD', '22yn0120');