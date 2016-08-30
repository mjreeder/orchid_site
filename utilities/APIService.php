<?php


class APIService
{
    public static function sanitizeParam($param)
    {
        if($param === 'null') {
            $param = null;
        }

        return $param;
    }

    public static function buildParams($request, $requiredParamNames = array(), $optionalParamNames = array())
    {
        $request = (array) $request;
        $params = array();
        $missingParams = array();

        if($requiredParamNames) {
            foreach ($requiredParamNames as $paramName) {
                if (isset($request[$paramName])) {
                    $params[$paramName] = $request[$paramName];
                } else {
                    $missingParams[] = $paramName;
                }
            }
        }

        if($optionalParamNames) {
            foreach ($optionalParamNames as $paramName) {
                if (isset($request[$paramName])) {
                    $params[$paramName] = $request[$paramName];
                }
            }
        }

        if(count($missingParams) > 0) {
            $message = "Missing parameters: [" . implode(", ", $missingParams) . "].";
            return self::responseFail($message);
        }

        return $params;
    }

    public static function buildFiles($files, $requiredFileNames = array(), $optionalFileNames = array())
    {
        $files = (array) $files;
        $params = array();
        $missingFiles = array();

        if($requiredFileNames) {
            foreach ($requiredFileNames as $paramName) {
                if (isset($files[$paramName])) {
                    $params[$paramName] = $files[$paramName];
                } else {
                    $missingFiles[] = $paramName;
                }
            }
        }

        if($optionalFileNames) {
            foreach ($optionalFileNames as $paramName) {
                if (isset($files[$paramName])) {
                    $params[$paramName] = $files[$paramName];
                }
            }
        }

        if(count($missingFiles) > 0) {
            $message = "Missing files: [" . implode(", ", $missingFiles) . "].";
            return self::responseFail($message);
        }

        return $params;
    }

    public static function authenticateRequest(&$requestParams)
    {
        $params = APIService::buildParams($requestParams, array(
            "sessionId",
            "sessionToken",
        ));

        $error = null;

        if( AuthService::authenticate($params['sessionId'], $params['sessionToken'], $error) == false ) {
            self::responseFail($error, 401);
        }
    }

    public static function responseSuccess($data, $code = 200)
    {
        header('Content-Type: application/json');
        http_response_code($code);
        die(json_encode($data));
    }

    public static function responseFail($message, $code = 400)
    {
        header('Content-Type: application/json');
        http_response_code($code);

        $response = array(
            "status" => "fail",
            "message" => $message
        );

        die(json_encode( (object) $response ));
    }

    public static function responseError($message, $code = 500)
    {
        header('Content-Type: application/javascript');
        http_response_code($code);

        $response = array(
            "status" => "error",
            "message" => $message
        );

        die(json_encode( (object) $response ));
    }

    public static function safeObject($object, $removeProperties = array())
    {
        $copy = array();
        foreach($object as $key => $value) {
            // Object
            if(is_object($value)) {
                if(method_exists($value, 'safeObject')) {
                    $copy[$key] = $value->safeObject();
                } else {
                    $copy[$key] = self::safeObject($value);
                }
            }

            // Array
            if(is_array($value)) {
                foreach($value as $key2 => $value2) {
                    if(method_exists($value, 'safeObject')) {
                        $copy[$key][$key2] = $value2->safeObject();
                    } else {
                        $copy[$key][$key2] = self::safeObject($value2);
                    }
                }
            }

            // Primitive
            $copy[$key] = $value;
        }

        foreach($removeProperties as $property) {
            unset($copy[$property]);
        }

        return (object) $copy;
    }

    public static function parsePutAndDelete()
    {
        global $_POST;

        /* PUT data comes in on the stdin stream */
        $putdata = fopen("php://input", "r");

        /* Open a file for writing */
        // $fp = fopen("myputfile.ext", "w");

        $raw_data = '';

        /* Read the data 1 KB at a time
           and write to the file */
        while ($chunk = fread($putdata, 1024))
            $raw_data .= $chunk;

        /* Close the streams */
        fclose($putdata);

        // Fetch content and determine boundary
        $boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));

        if(empty($boundary)){
            parse_str($raw_data,$data);
            $GLOBALS[ '_POST' ] = $data;
            return;
        }

        // Fetch each part
        $parts = array_slice(explode($boundary, $raw_data), 1);
        $data = array();

        foreach ($parts as $part) {
            // If this is the last part, break
            if ($part == "--\r\n") break;

            // Separate content from headers
            $part = ltrim($part, "\r\n");
            list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);

            // Parse the headers list
            $raw_headers = explode("\r\n", $raw_headers);
            $headers = array();
            foreach ($raw_headers as $header) {
                list($name, $value) = explode(':', $header);
                $headers[strtolower($name)] = ltrim($value, ' ');
            }

            // Parse the Content-Disposition to get the field name, etc.
            if (isset($headers['content-disposition'])) {
                $filename = null;
                $tmp_name = null;
                preg_match(
                    '/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/',
                    $headers['content-disposition'],
                    $matches
                );
                list(, $type, $name) = $matches;

                //Parse File
                if( isset($matches[4]) )
                {
                    //if labeled the same as previous, skip
                    if( isset( $_FILES[ $matches[ 2 ] ] ) )
                    {
                        continue;
                    }

                    //get filename
                    $filename = $matches[4];

                    //get tmp name
                    $filename_parts = pathinfo( $filename );
                    $tmp_name = tempnam( ini_get('upload_tmp_dir'), $filename_parts['filename']);

                    //populate $_FILES with information, size may be off in multibyte situation
                    $_FILES[ $matches[ 2 ] ] = array(
                        'error'=>0,
                        'name'=>$filename,
                        'tmp_name'=>$tmp_name,
                        'size'=>strlen( $body ),
                        'type'=>$value
                    );

                    //place in temporary directory
                    file_put_contents($tmp_name, $body);
                }
                //Parse Field
                else
                {
                    $data[$name] = substr($body, 0, strlen($body) - 2);
                }
            }

        }
        $GLOBALS[ '_POST' ] = $data;
        return;
    }
}