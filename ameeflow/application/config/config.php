<?php
defined('BASEPATH') OR exit('No direct script access allowed');
         
$config['base_url'] = 'https://www.dev-work.assessmentmadeeasy.com/ameeflow/'; 
$config['ajax_base_url'] = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'].'/ameeflow/';
$config['product_name'] = 'AMEE Flow';
$config['short_product_desc'] = 'Balancing Energy, Workload, and Efficiency';
$config['project_name_page_first'] = 'AMEE';
$config['project_name_page_second'] = 'Flow';
$config['project_name_page_third'] = 'Panel';
$config['system_directory_name'] = 'system-admin/';
$config['admin_directory_name'] = 'super-admin/';

$config['aiButtonTxt'] = 'AI Assistant';

$config['gptApiKey'] = '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'; 

$config['admin_email_sent_to'] = 'sakilekai@yahoo.com||Sakile';
$config['admin_email_sent_to_cc'] = 'sakilekai@yahoo.com||Sakile';
$config['support_email_address'] = 'support@deireadiness.com';

$config['paypal_client_id_test'] = 'ASgOt44kt0yDKZs4PfAd22TPjjHw15E7pZ40ysARhZBr3rfm8w32mleZ1PCjd681GsUhPlijMjpYfrdM'; 
$config['paypal_client_id_live'] = 'AXgeMcp4obT4dErfqvW7m2Idz5NLRlpbltP5DOAkESWPdfJbmmfPdWVjV0MVX1HWChrfZmC9a_O-wuAf';

$config['terms_assessment_array_config']=array(
	'1'=>array('name'=>'Fall','short_name'=>'FA','slug'=>'fall','startMonth'=>'8','status'=>'0'),
	'2'=>array('name'=>'Winter','short_name'=>'WI','slug'=>'winter','startMonth'=>'12','status'=>'0'),
	'3'=>array('name'=>'Spring','short_name'=>'SP','slug'=>'spring','startMonth'=>'1','status'=>'0'),
	'4'=>array('name'=>'Summer','short_name'=>'SU','slug'=>'summer','startMonth'=>'6','status'=>'0'));

$config['share_report_for_array_config']=array(
	'1'=>array('name'=>'Sampling Plan Report','controllerName'=>'sampling_plan','reviewPromptId'=>'1','approvalPromptId'=>'2'),
	'2'=>array('name'=>'LOADs Report','controllerName'=>'loads_report','reviewPromptId'=>'8','approvalPromptId'=>'9'),
	'3'=>array('name'=>'General Report','controllerName'=>'general_reports','reviewPromptId'=>'10','approvalPromptId'=>'11'));

$config['user_roles_array_config']=array(
	'1'=>array('name'=>'Admin 1','shortDesc'=>'Dean, Assoc. Dean, etc.','assRoleFrm'=>'1','status'=>'0'),
	'2'=>array('name'=>'Admin 2','shortDesc'=>'Chairs, Directors, Coordinators','assRoleFrm'=>'1','status'=>'0'),
	'3'=>array('name'=>'Faculty','shortDesc'=>'','assRoleFrm'=>'1','status'=>'0'),
	'4'=>array('name'=>'Faculty Assessor(s)','shortDesc'=>'','assRoleFrm'=>'0','status'=>'0'),
	'5'=>array('name'=>'Staff/Colleague','shortDesc'=>'','assRoleFrm'=>'1','status'=>'0'),
	'6'=>array('name'=>'Student Asst','shortDesc'=>'','assRoleFrm'=>'1','status'=>'0'));

$config['task_priority_options_array_config']=array(
	'1'=>array('name'=>'Critical','slug'=>'critical','bgColor'=>'333333','fontColor'=>'ffffff','clsName'=>'cscritical','icon'=>'<i class="fa fa-exclamation-triangle iwarning"></i>','iconColor'=>'','status'=>'0'),
	'2'=>array('name'=>'High','slug'=>'high','bgColor'=>'ff6725','fontColor'=>'ffffff','clsName'=>'cshigh','icon'=>'','iconColor'=>'','status'=>'0'),
	'3'=>array('name'=>'Medium','slug'=>'medium','bgColor'=>'fad83b','fontColor'=>'333333','clsName'=>'csmedium','icon'=>'','iconColor'=>'','status'=>'0'),
	'4'=>array('name'=>'Low','slug'=>'low','bgColor'=>'00d76d','fontColor'=>'333333','clsName'=>'cslow','icon'=>'','iconColor'=>'','status'=>'0'));

$config['user_types_array_config']=array(
	'1'=>array('name'=>'Area Expert','slug'=>'area-expert','moreInfo'=>' (Dashboard)','status'=>'0'),
	'2'=>array('name'=>'Collaborators','slug'=>'collaborators','moreInfo'=>' (Dashboard)','status'=>'0'),
	'3'=>array('name'=>'Reviewers / Approvers','slug'=>'reviewers-approvers','moreInfo'=>' (Notification Only)','status'=>'0'));

$config['support_types_array_config']=array(
'1'=>array('name'=>'Report a Problem','slug'=>'report-a-problem','status'=>'0'),
'2'=>array('name'=>'Submit a Question','slug'=>'submit-a-question','status'=>'0'),
'3'=>array('name'=>'Offer Suggestions','slug'=>'offer-suggestions','status'=>'0'),
'4'=>array('name'=>'Give Feedback','slug'=>'give-feedback','status'=>'0'));

$config['timezone_array_config'] = array( 
    '1' => array('name' => 'India Standard Time', 'short_name' => 'IST', 'slug' => 'india-standard-time', 'offset' => '+05:30', 'timezone' => 'Asia/Kolkata', 'status' => '1'),
    '2' => array('name' => 'Pacific Standard Time', 'short_name' => 'PST', 'slug' => 'pacific-standard-time', 'offset' => '-08:00', 'timezone' => 'America/Los_Angeles', 'status' => '1'),
    '3' => array('name' => 'Pacific Daylight Time', 'short_name' => 'PDT', 'slug' => 'pacific-daylight-time', 'offset' => '-07:00', 'timezone' => 'America/Los_Angeles', 'status' => '1'),
    '4' => array('name' => 'Eastern Standard Time', 'short_name' => 'EST', 'slug' => 'eastern-standard-time', 'offset' => '-05:00', 'timezone' => 'America/New_York', 'status' => '1'),
    '5' => array('name' => 'Eastern Daylight Time', 'short_name' => 'EDT', 'slug' => 'eastern-daylight-time', 'offset' => '-04:00', 'timezone' => 'America/New_York', 'status' => '1'),
    '6' => array('name' => 'Central Standard Time', 'short_name' => 'CST', 'slug' => 'central-standard-time', 'offset' => '-06:00', 'timezone' => 'America/Chicago', 'status' => '1'),
    '7' => array('name' => 'Central Daylight Time', 'short_name' => 'CDT', 'slug' => 'central-daylight-time', 'offset' => '-05:00', 'timezone' => 'America/Chicago', 'status' => '1'),
    '8' => array('name' => 'Mountain Standard Time', 'short_name' => 'MST', 'slug' => 'mountain-standard-time', 'offset' => '-07:00', 'timezone' => 'America/Denver', 'status' => '1'),
    '9' => array('name' => 'Mountain Daylight Time', 'short_name' => 'MDT', 'slug' => 'mountain-daylight-time', 'offset' => '-06:00', 'timezone' => 'America/Denver', 'status' => '1'),
    '10' => array('name' => 'Greenwich Mean Time', 'short_name' => 'GMT', 'slug' => 'greenwich-mean-time', 'offset' => '+00:00', 'timezone' => 'Etc/GMT', 'status' => '1'),
    '11' => array('name' => 'British Summer Time', 'short_name' => 'BST', 'slug' => 'british-summer-time', 'offset' => '+01:00', 'timezone' => 'Europe/London', 'status' => '1'),
    '12' => array('name' => 'Central European Time', 'short_name' => 'CET', 'slug' => 'central-european-time', 'offset' => '+01:00', 'timezone' => 'Europe/Berlin', 'status' => '1'),
    '13' => array('name' => 'Central European Summer Time', 'short_name' => 'CEST', 'slug' => 'central-european-summer-time', 'offset' => '+02:00', 'timezone' => 'Europe/Berlin', 'status' => '1'),
    '14' => array('name' => 'Australian Eastern Standard Time', 'short_name' => 'AEST', 'slug' => 'australian-eastern-standard-time', 'offset' => '+10:00', 'timezone' => 'Australia/Sydney', 'status' => '1'),
    '15' => array('name' => 'Australian Eastern Daylight Time', 'short_name' => 'AEDT', 'slug' => 'australian-eastern-daylight-time', 'offset' => '+11:00', 'timezone' => 'Australia/Sydney', 'status' => '1'),
    '16' => array('name' => 'Australian Western Standard Time', 'short_name' => 'AWST', 'slug' => 'australian-western-standard-time', 'offset' => '+08:00', 'timezone' => 'Australia/Perth', 'status' => '1'),
    '17' => array('name' => 'China Standard Time', 'short_name' => 'CST', 'slug' => 'china-standard-time', 'offset' => '+08:00', 'timezone' => 'Asia/Shanghai', 'status' => '1'),
    '18' => array('name' => 'Japan Standard Time', 'short_name' => 'JST', 'slug' => 'japan-standard-time', 'offset' => '+09:00', 'timezone' => 'Asia/Tokyo', 'status' => '1'),
    '19' => array('name' => 'Korea Standard Time', 'short_name' => 'KST', 'slug' => 'korea-standard-time', 'offset' => '+09:00', 'timezone' => 'Asia/Seoul', 'status' => '1'),
    '20' => array('name' => 'Arabia Standard Time', 'short_name' => 'AST', 'slug' => 'arabia-standard-time', 'offset' => '+03:00', 'timezone' => 'Asia/Riyadh', 'status' => '1'),
    '21' => array('name' => 'New Zealand Standard Time', 'short_name' => 'NZST', 'slug' => 'new-zealand-standard-time', 'offset' => '+12:00', 'timezone' => 'Pacific/Auckland', 'status' => '1'),
    '22' => array('name' => 'New Zealand Daylight Time', 'short_name' => 'NZDT', 'slug' => 'new-zealand-daylight-time', 'offset' => '+13:00', 'timezone' => 'Pacific/Auckland', 'status' => '1'),
    '23' => array('name' => 'Hawaii Standard Time', 'short_name' => 'HST', 'slug' => 'hawaii-standard-time', 'offset' => '-10:00', 'timezone' => 'Pacific/Honolulu', 'status' => '1'),
    '24' => array('name' => 'Alaska Standard Time', 'short_name' => 'AKST', 'slug' => 'alaska-standard-time', 'offset' => '-09:00', 'timezone' => 'America/Anchorage', 'status' => '1'),
    '25' => array('name' => 'Alaska Daylight Time', 'short_name' => 'AKDT', 'slug' => 'alaska-daylight-time', 'offset' => '-08:00', 'timezone' => 'America/Anchorage', 'status' => '1'),
);


$config['usa_states_array_config']=array(
	'1'=>array('name'=>'Alabama', 'code'=>'AL', 'status'=>'0'),
	'2'=>array('name'=>'Alaska', 'code'=>'AK', 'status'=>'0'),
	'3'=>array('name'=>'Arizona', 'code'=>'AZ', 'status'=>'0'),
	'4'=>array('name'=>'Arkansas', 'code'=>'AR', 'status'=>'0'),
	'5'=>array('name'=>'California', 'code'=>'CA', 'status'=>'0'),
	'6'=>array('name'=>'Colorado', 'code'=>'CO', 'status'=>'0'),
	'7'=>array('name'=>'Connecticut', 'code'=>'CT', 'status'=>'0'),
	'9'=>array('name'=>'Delaware', 'code'=>'DE', 'status'=>'0'),
	'10'=>array('name'=>'District of Columbia', 'code'=>'DC', 'status'=>'0'),
	'11'=>array('name'=>'Florida', 'code'=>'FL', 'status'=>'0'),
	'12'=>array('name'=>'Georgia', 'code'=>'GA', 'status'=>'0'),
	'13'=>array('name'=>'Hawaii', 'code'=>'HI', 'status'=>'0'),
	'14'=>array('name'=>'Idaho', 'code'=>'ID', 'status'=>'0'),
	'14'=>array('name'=>'Illinois', 'code'=>'IL', 'status'=>'0'),
	'15'=>array('name'=>'Indiana', 'code'=>'IN', 'status'=>'0'),
	'16'=>array('name'=>'Iowa', 'code'=>'IA', 'status'=>'0'),
	'17'=>array('name'=>'Kansas', 'code'=>'KS', 'status'=>'0'),
	'18'=>array('name'=>'Kentucky', 'code'=>'KY', 'status'=>'0'),
	'19'=>array('name'=>'Louisiana', 'code'=>'LA', 'status'=>'0'),
	'20'=>array('name'=>'Maine', 'code'=>'ME', 'status'=>'0'),
	'21'=>array('name'=>'Maryland', 'code'=>'MD', 'status'=>'0'),
	'22'=>array('name'=>'Massachusetts', 'code'=>'MA', 'status'=>'0'),
	'23'=>array('name'=>'Michigan', 'code'=>'MI', 'status'=>'0'),
	'24'=>array('name'=>'Minnesota', 'code'=>'MN', 'status'=>'0'),
	'25'=>array('name'=>'Mississippi', 'code'=>'MS', 'status'=>'0'),
	'26'=>array('name'=>'Missouri', 'code'=>'MO', 'status'=>'0'),
	'27'=>array('name'=>'Montana', 'code'=>'MT', 'status'=>'0'),
	'28'=>array('name'=>'Nebraska', 'code'=>'NE', 'status'=>'0'),
	'29'=>array('name'=>'Nevada', 'code'=>'NV', 'status'=>'0'),
	'30'=>array('name'=>'New Hampshire', 'code'=>'NH', 'status'=>'0'),
	'31'=>array('name'=>'New Jersey', 'code'=>'NJ', 'status'=>'0'),
	'32'=>array('name'=>'New Mexico', 'code'=>'NM', 'status'=>'0'),
	'33'=>array('name'=>'New York', 'code'=>'NY', 'status'=>'0'),
	'34'=>array('name'=>'North Carolina', 'code'=>'NC', 'status'=>'0'),
	'35'=>array('name'=>'North Dakota', 'code'=>'ND', 'status'=>'0'),
	'36'=>array('name'=>'Ohio', 'code'=>'OH', 'status'=>'0'),
	'37'=>array('name'=>'Oklahoma', 'code'=>'OK', 'status'=>'0'),
	'38'=>array('name'=>'Oregon', 'code'=>'OR', 'status'=>'0'),
	'39'=>array('name'=>'Pennsylvania', 'code'=>'PA', 'status'=>'0'),
	'40'=>array('name'=>'Rhode Island', 'code'=>'RI', 'status'=>'0'),
	'41'=>array('name'=>'South Carolina', 'code'=>'SC', 'status'=>'0'),
	'42'=>array('name'=>'South Dakota', 'code'=>'SD', 'status'=>'0'),
	'43'=>array('name'=>'Tennessee', 'code'=>'TN', 'status'=>'0'),
	'44'=>array('name'=>'Texas', 'code'=>'TX', 'status'=>'0'),
	'45'=>array('name'=>'Utah', 'code'=>'UT', 'status'=>'0'),
	'46'=>array('name'=>'Vermont', 'code'=>'VT', 'status'=>'0'),
	'47'=>array('name'=>'Virginia', 'code'=>'VA', 'status'=>'0'),
	'48'=>array('name'=>'Washington', 'code'=>'WA', 'status'=>'0'),
	'49'=>array('name'=>'West Virginia', 'code'=>'WV', 'status'=>'0'),
	'50'=>array('name'=>'Wisconsin', 'code'=>'WI', 'status'=>'0'),
	'51'=>array('name'=>'Wyoming', 'code'=>'WY', 'status'=>'0')
);

/*
|--------------------------------------------------------------------------
| Index File
|--------------------------------------------------------------------------
|
| Typically this will be your index.php file, unless you've renamed it to
| something else. If you are using mod_rewrite to remove the page set this
| variable so that it is blank.
|
*/
$config['index_page'] = '';

/*
|--------------------------------------------------------------------------
| URI PROTOCOL
|--------------------------------------------------------------------------
|
| This item determines which server global should be used to retrieve the
| URI string.  The default setting of 'REQUEST_URI' works for most servers.
| If your links do not seem to work, try one of the other delicious flavors:
|
| 'REQUEST_URI'    Uses $_SERVER['REQUEST_URI']
| 'QUERY_STRING'   Uses $_SERVER['QUERY_STRING']
| 'PATH_INFO'      Uses $_SERVER['PATH_INFO']
|
| WARNING: If you set this to 'PATH_INFO', URIs will always be URL-decoded!
*/
$config['uri_protocol']	= 'REQUEST_URI';

/*
|--------------------------------------------------------------------------
| URL suffix
|--------------------------------------------------------------------------
|
| This option allows you to add a suffix to all URLs generated by CodeIgniter.
| For more information please see the user guide:
|
| https://codeigniter.com/userguide3/general/urls.html
|
| Note: This option is ignored for CLI requests.
*/
$config['url_suffix'] = '';

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| This determines which set of language files should be used. Make sure
| there is an available translation if you intend to use something other
| than english.
|
*/
$config['language']	= 'english';

/*
|--------------------------------------------------------------------------
| Default Character Set
|--------------------------------------------------------------------------
|
| This determines which character set is used by default in various methods
| that require a character set to be provided.
|
| See http://php.net/htmlspecialchars for a list of supported charsets.
|
*/
$config['charset'] = 'UTF-8';

/*
|--------------------------------------------------------------------------
| Enable/Disable System Hooks
|--------------------------------------------------------------------------
|
| If you would like to use the 'hooks' feature you must enable it by
| setting this variable to TRUE (boolean).  See the user guide for details.
|
*/
$config['enable_hooks'] = FALSE;

/*
|--------------------------------------------------------------------------
| Class Extension Prefix
|--------------------------------------------------------------------------
|
| This item allows you to set the filename/classname prefix when extending
| native libraries.  For more information please see the user guide:
|
| https://codeigniter.com/userguide3/general/core_classes.html
| https://codeigniter.com/userguide3/general/creating_libraries.html
|
*/
$config['subclass_prefix'] = 'MY_';

/*
|--------------------------------------------------------------------------
| Composer auto-loading
|--------------------------------------------------------------------------
|
| Enabling this setting will tell CodeIgniter to look for a Composer
| package auto-loader script in application/vendor/autoload.php.
|
|	$config['composer_autoload'] = TRUE;
|
| Or if you have your vendor/ directory located somewhere else, you
| can opt to set a specific path as well:
|
|	$config['composer_autoload'] = '/path/to/vendor/autoload.php';
|
| For more information about Composer, please visit http://getcomposer.org/
|
| Note: This will NOT disable or override the CodeIgniter-specific
|	autoloading (application/config/autoload.php)
*/
$config['composer_autoload'] = FCPATH . 'vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Allowed URL Characters
|--------------------------------------------------------------------------
|
| This lets you specify which characters are permitted within your URLs.
| When someone tries to submit a URL with disallowed characters they will
| get a warning message.
|
| As a security measure you are STRONGLY encouraged to restrict URLs to
| as few characters as possible.  By default only these are allowed: a-z 0-9~%.:_-
|
| Leave blank to allow all characters -- but only if you are insane.
|
| The configured value is actually a regular expression character group
| and it will be executed as: ! preg_match('/^[<permitted_uri_chars>]+$/i
|
| DO NOT CHANGE THIS UNLESS YOU FULLY UNDERSTAND THE REPERCUSSIONS!!
|
*/
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';

/*
|--------------------------------------------------------------------------
| Enable Query Strings
|--------------------------------------------------------------------------
|
| By default CodeIgniter uses search-engine friendly segment based URLs:
| example.com/who/what/where/
|
| You can optionally enable standard query string based URLs:
| example.com?who=me&what=something&where=here
|
| Options are: TRUE or FALSE (boolean)
|
| The other items let you set the query string 'words' that will
| invoke your controllers and its functions:
| example.com/index.php?c=controller&m=function
|
| Please note that some of the helpers won't work as expected when
| this feature is enabled, since CodeIgniter is designed primarily to
| use segment based URLs.
|
*/
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

/*
|--------------------------------------------------------------------------
| Allow $_GET array
|--------------------------------------------------------------------------
|
| By default CodeIgniter enables access to the $_GET array.  If for some
| reason you would like to disable it, set 'allow_get_array' to FALSE.
|
| WARNING: This feature is DEPRECATED and currently available only
|          for backwards compatibility purposes!
|
*/
$config['allow_get_array'] = TRUE;

/*
|--------------------------------------------------------------------------
| Error Logging Threshold
|--------------------------------------------------------------------------
|
| You can enable error logging by setting a threshold over zero. The
| threshold determines what gets logged. Threshold options are:
|
|	0 = Disables logging, Error logging TURNED OFF
|	1 = Error Messages (including PHP errors)
|	2 = Debug Messages
|	3 = Informational Messages
|	4 = All Messages
|
| You can also pass an array with threshold levels to show individual error types
|
| 	array(2) = Debug Messages, without Error Messages
|
| For a live site you'll usually only enable Errors (1) to be logged otherwise
| your log files will fill up very fast.
|
*/
$config['log_threshold'] = 0;

/*
|--------------------------------------------------------------------------
| Error Logging Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/logs/ directory. Use a full server path with trailing slash.
|
*/
$config['log_path'] = '';

/*
|--------------------------------------------------------------------------
| Log File Extension
|--------------------------------------------------------------------------
|
| The default filename extension for log files. The default 'php' allows for
| protecting the log files via basic scripting, when they are to be stored
| under a publicly accessible directory.
|
| Note: Leaving it blank will default to 'php'.
|
*/
$config['log_file_extension'] = '';

/*
|--------------------------------------------------------------------------
| Log File Permissions
|--------------------------------------------------------------------------
|
| The file system permissions to be applied on newly created log files.
|
| IMPORTANT: This MUST be an integer (no quotes) and you MUST use octal
|            integer notation (i.e. 0700, 0644, etc.)
*/
$config['log_file_permissions'] = 0644;

/*
|--------------------------------------------------------------------------
| Date Format for Logs
|--------------------------------------------------------------------------
|
| Each item that is logged has an associated date. You can use PHP date
| codes to set your own date formatting
|
*/
$config['log_date_format'] = 'Y-m-d H:i:s';

/*
|--------------------------------------------------------------------------
| Error Views Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/views/errors/ directory.  Use a full server path with trailing slash.
|
*/
$config['error_views_path'] = '';

/*
|--------------------------------------------------------------------------
| Cache Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/cache/ directory.  Use a full server path with trailing slash.
|
*/
$config['cache_path'] = '';

/*
|--------------------------------------------------------------------------
| Cache Include Query String
|--------------------------------------------------------------------------
|
| Whether to take the URL query string into consideration when generating
| output cache files. Valid options are:
|
|	FALSE      = Disabled
|	TRUE       = Enabled, take all query parameters into account.
|	             Please be aware that this may result in numerous cache
|	             files generated for the same page over and over again.
|	array('q') = Enabled, but only take into account the specified list
|	             of query parameters.
|
*/
$config['cache_query_string'] = FALSE;

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| If you use the Encryption class, you must set an encryption key.
| See the user guide for more info.
|
| https://codeigniter.com/userguide3/libraries/encryption.html
|
*/
$config['encryption_key'] = '';

/*
|--------------------------------------------------------------------------
| Session Variables
|--------------------------------------------------------------------------
|
| 'sess_driver'
|
|	The storage driver to use: files, database, redis, memcached
|
| 'sess_cookie_name'
|
|	The session cookie name, must contain only [0-9a-z_-] characters
|
| 'sess_samesite'
|
|	Session cookie SameSite attribute: Lax (default), Strict or None
|
| 'sess_expiration'
|
|	The number of SECONDS you want the session to last.
|	Setting to 0 (zero) means expire when the browser is closed.
|
| 'sess_save_path'
|
|	The location to save sessions to, driver dependent.
|
|	For the 'files' driver, it's a path to a writable directory.
|	WARNING: Only absolute paths are supported!
|
|	For the 'database' driver, it's a table name.
|	Please read up the manual for the format with other session drivers.
|
|	IMPORTANT: You are REQUIRED to set a valid save path!
|
| 'sess_match_ip'
|
|	Whether to match the user's IP address when reading the session data.
|
|	WARNING: If you're using the database driver, don't forget to update
|	         your session table's PRIMARY KEY when changing this setting.
|
| 'sess_time_to_update'
|
|	How many seconds between CI regenerating the session ID.
|
| 'sess_regenerate_destroy'
|
|	Whether to destroy session data associated with the old session ID
|	when auto-regenerating the session ID. When set to FALSE, the data
|	will be later deleted by the garbage collector.
|
| Other session cookie settings are shared with the rest of the application,
| except for 'cookie_prefix' and 'cookie_httponly', which are ignored here.
|
*/
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_samesite'] = 'Lax';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = NULL;
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

/*
|--------------------------------------------------------------------------
| Cookie Related Variables
|--------------------------------------------------------------------------
|
| 'cookie_prefix'   = Set a cookie name prefix if you need to avoid collisions
| 'cookie_domain'   = Set to .your-domain.com for site-wide cookies
| 'cookie_path'     = Typically will be a forward slash
| 'cookie_secure'   = Cookie will only be set if a secure HTTPS connection exists.
| 'cookie_httponly' = Cookie will only be accessible via HTTP(S) (no javascript)
| 'cookie_samesite' = Cookie's samesite attribute (Lax, Strict or None)
|
| Note: These settings (with the exception of 'cookie_prefix' and
|       'cookie_httponly') will also affect sessions.
|
*/
$config['cookie_prefix']	= 'AmeeFlow_';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;
$config['cookie_samesite'] 	= 'Lax';

/*
|--------------------------------------------------------------------------
| Standardize newlines
|--------------------------------------------------------------------------
|
| Determines whether to standardize newline characters in input data,
| meaning to replace \r\n, \r, \n occurrences with the PHP_EOL value.
|
| WARNING: This feature is DEPRECATED and currently available only
|          for backwards compatibility purposes!
|
*/
$config['standardize_newlines'] = FALSE;

/*
|--------------------------------------------------------------------------
| Global XSS Filtering
|--------------------------------------------------------------------------
|
| Determines whether the XSS filter is always active when GET, POST or
| COOKIE data is encountered
|
| WARNING: This feature is DEPRECATED and currently available only
|          for backwards compatibility purposes!
|
*/
$config['global_xss_filtering'] = FALSE;

/*
|--------------------------------------------------------------------------
| Cross Site Request Forgery
|--------------------------------------------------------------------------
| Enables a CSRF cookie token to be set. When set to TRUE, token will be
| checked on a submitted form. If you are accepting user data, it is strongly
| recommended CSRF protection be enabled.
|
| 'csrf_token_name' = The token name
| 'csrf_cookie_name' = The cookie name
| 'csrf_expire' = The number in seconds the token should expire.
| 'csrf_regenerate' = Regenerate token on every submission
| 'csrf_exclude_uris' = Array of URIs which ignore CSRF checks
*/
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

/*
|--------------------------------------------------------------------------
| Output Compression
|--------------------------------------------------------------------------
|
| Enables Gzip output compression for faster page loads.  When enabled,
| the output class will test whether your server supports Gzip.
| Even if it does, however, not all browsers support compression
| so enable only if you are reasonably sure your visitors can handle it.
|
| Only used if zlib.output_compression is turned off in your php.ini.
| Please do not use it together with httpd-level output compression.
|
| VERY IMPORTANT:  If you are getting a blank page when compression is enabled it
| means you are prematurely outputting something to your browser. It could
| even be a line of whitespace at the end of one of your scripts.  For
| compression to work, nothing can be sent before the output buffer is called
| by the output class.  Do not 'echo' any values with compression enabled.
|
*/
$config['compress_output'] = FALSE;

/*
|--------------------------------------------------------------------------
| Master Time Reference
|--------------------------------------------------------------------------
|
| Options are 'local' or any PHP supported timezone. This preference tells
| the system whether to use your server's local time as the master 'now'
| reference, or convert it to the configured one timezone. See the 'date
| helper' page of the user guide for information regarding date handling.
|
*/
$config['time_reference'] = 'local';

/*
|--------------------------------------------------------------------------
| Rewrite PHP Short Tags
|--------------------------------------------------------------------------
|
| If your PHP installation does not have short tag support enabled CI
| can rewrite the tags on-the-fly, enabling you to utilize that syntax
| in your view files.  Options are TRUE or FALSE (boolean)
|
| Note: You need to have eval() enabled for this to work.
|
*/
$config['rewrite_short_tags'] = FALSE;

/*
|--------------------------------------------------------------------------
| Reverse Proxy IPs
|--------------------------------------------------------------------------
|
| If your server is behind a reverse proxy, you must whitelist the proxy
| IP addresses from which CodeIgniter should trust headers such as
| HTTP_X_FORWARDED_FOR and HTTP_CLIENT_IP in order to properly identify
| the visitor's IP address.
|
| You can use both an array or a comma-separated list of proxy addresses,
| as well as specifying whole subnets. Here are a few examples:
|
| Comma-separated:	'10.0.1.200,192.168.5.0/24'
| Array:		array('10.0.1.200', '192.168.5.0/24')
*/
$config['proxy_ips'] = '';
