<?php

/**
 * Common utility functions
 * @author Saurabh aka JSX
 * @version 0.1
 */
class Utils
{
    /**
     * Redirect user
     * @param string $page Default = null -> to redirect to the same page.
     * @param string $message
     * @param string $status Eg: success, failure etc
     * @param string $context Eg: signup, account_activation etc
     */
    public static function redirect($page = null, $message = null, $status = 'success', $context = null)
    {
        if (!$page)
        {
            $page = basename($_SERVER['PHP_SELF']);
        }
        self::set_message($message, $status, $context);
        header("Location: $page");
        die;
    }
    
    /**
     * Set message in $_SESSION['message']
     * @param string $message
     * @param string $type Eg: success, failure etc
     * @param string $context Eg: signup, account_activation etc
     */
    public static function set_message($message, $type=null, $context=null)
    {
        $_SESSION['message']['text'] = $message;
        $_SESSION['message']['type'] = $type;
        $_SESSION['message']['context'] = $context;
        $_SESSION['message']['set_page'] = $_SERVER['PHP_SELF']; // for debuggin
    }
    
    
    /**
     * Displays the message in $_SESSION['message']
     * 
     * If a wrapper is specified, the message[text] will be wrapped inside that element.
     * If message['type'] is absent, the css class 'message' will be applied to the wrapping element,
     * else the message['type'] itself will be applied as css class.
     * 
     * @param string $context Eg: signup, account_activation etc
     * @param string $wrapper Eg: div, span, p etc
     */
    public static function show_message($context, $wrapper='')
    {
        $css_class = (isset($_SESSION['message']['type']))?$_SESSION['message']['type']:'message';
       
        if (isset($_SESSION['message']) && $_SESSION['message']['context'] == $context)
        {
            if ($wrapper == '')
            {
                echo $_SESSION['message']['text'];
            }
            else
            {
                echo "<", $wrapper, " class='", $css_class, "' >", $_SESSION['message']['text'], "</", $wrapper, ">";
            }
            unset($_SESSION['message']);
        }
    }
	
	/**
     * Get time elapsed since a timestamp/date
     * @param timestamp | a valid date format $old_time
     * @param type $convert_to_timestamp optional default true If true, the passed value will be converted to timestamp
     * @return string Eg: 2 seconds
     */
	public static function get_time_since($old_time, $convert_to_timestamp = true)
    {
        if ($convert_to_timestamp)
        {
            $stamp = time() - strtotime($old_time);
        }
        else
        {
            $stamp = time() - $old_time;
        }
        
        $seconds = gmdate('s', $stamp);
        $minutes = gmdate('i', $stamp);
        $hours = gmdate('H', $stamp);
        $days = gmdate('d', $stamp);
        $months = gmdate('n', $stamp);
        $years = gmdate('Y', $stamp);
        
        if ($stamp < 60)
        {
            $time_string = (int)$seconds." seconds ";
        }
        elseif ($stamp < 60*60)
        {
            $time_string = (int)$minutes." minutes ";
        }
        elseif ($stamp < 60*60*24)
        {
            $time_string = (int)$hours." hours ";
        }
        elseif ($stamp < 60*60*24*30)
        {
            $time_string = (int)$days." days ";
        }
        elseif ($stamp < 60*60*24*30*365)
        {
            $time_string =  (int)$months." months ";
        }
        elseif ($stamp >= 60*60*24*365)
        {
            $time_string = (int)$years." years ";
        }

        return trim($time_string, " ");
    }
    
	
	
	/**
	 * Trim the given string at the specified length
	 * @param string $string String to be trimmed
	 * @param number $length Length at which the string to be trimmed
	 * @param string $tail An optional string to be appended after the trimmed string. Default: .. (two dots)
	 * 
	 */
	public static function trim_text($string, $length = null, $tail = "..")
	{
	    $tail = (strlen($string) > $length) ? $tail : null;
	    $trimmed_string = isset($length) ? substr($string, 0, $length).$tail : $string;
	    return $trimmed_string;
	}
    
}

?>
