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

                case 'str': // trim string

                $var = trim ( $var );

                break;

                case 'nohtml': // trim string, no HTML allowed

                $var = htmlentities ( trim ( $var ), ENT_QUOTES );

                break;

                case 'plain': // trim string, no HTML allowed, plain text

                $var =  htmlentities ( trim ( $var ) , ENT_NOQUOTES )  ;

                break;

                case 'upper_word': // trim string, upper case words

                $var = ucwords ( strtolower ( trim ( $var ) ) );

                break;

                case 'ucfirst': // trim string, upper case first word

                $var = ucfirst ( strtolower ( trim ( $var ) ) );

                break;
                case 'lower': // trim string, lower case words

                $var = strtolower ( trim ( $var ) );

                break;
                case 'urle': // trim string, url encoded

                $var = urlencode ( trim ( $var ) );

                break;

                case 'trim_urle': // trim string, url decoded

                $var = urldecode ( trim ( $var ) );

                break;



                case 'telephone': // True/False for a telephone number

                $size = strlen ($var) ;

                for ($x=0;$x<$size;$x++)

                {

                        if ( ! ( ( ctype_digit($var[$x] ) || ($var[$x]=='+') || ($var[$x]=='*') || ($var[$x]=='p')) ) )

                        {

                                return false;

                        }

                }

                return true;

                break;

                case 'sql':
                // True/False if the given string is SQL injection safe

                $var = trim($var);
                // return mysqli_real_escape_string($var);

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
