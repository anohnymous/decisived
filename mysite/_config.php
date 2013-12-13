<?php
require_once('conf/ConfigureFromEnv.php');

global $project;
$project = 'mysite';

global $database;
$database = '';

Object::add_extension('Decision', 'Hierarchy');
Object::add_extension('Decision', 'Versioned("Live")');
// Set the site locale
i18n::set_locale('en_US');

SS_Log::add_writer(new SS_LogFileWriter('/home1/resolut1/public_html/decisived/error.log'), SS_Log::WARN, '<=');