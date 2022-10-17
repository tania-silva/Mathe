<?php

/**
 * Sanitize only one variable .
 * Returns the variable sanitized according to the desired type or true/false
 * for certain data types if the variable does not correspond to the given data type.
 *
 * NOTE: True/False is returned only for telephone, pin, id_card data types
 *
 * @param mixed The variable itself
 * @param string A string containing the desired variable type
 * @return The sanitized variable or true/false
 */


function sanitizeOne($var, $type)
{
        switch ( $type ) {
                  case 'int': // integer
							$var = (int) $var;
                        break;
                  case 'sql':
						//
						$var = trim($var);
						$var = cssencode($var) ;	// no-XSS
						// $var=mysql_real_escape_string($var); // no SQLinjection
					return $var;
                    break;
                }

        return $var;
}


/**
 * Sanitize an array.
 *
 * sanitize($_POST, array('id'=>'int', 'name' => 'str'));
 * sanitize($customArray, array('id'=>'int', 'name' => 'str'));
 *
 * @param array $data
 * @param array $whatToKeep
 */


function sanitize( &$data, $whatToKeep )
{
        $data = array_intersect_key( $data, $whatToKeep );

        foreach ($data as $key => $value)
        {
                $data[$key] = sanitizeOne( $data[$key] , $whatToKeep[$key] );
        }

}
function sanitizeAll(&$data){
        foreach ($data as $key => $value)	$data[$key] = sanitizeOne( $data[$key] , 'sql' );
}

/*

	XSS -

*/
function cssencode($str) {
    $purifier = new HTMLPurifier();
	return $purifier->purify($str);

}

sanitizeAll($_POST);
sanitizeAll($_GET);
