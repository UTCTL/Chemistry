<?php
function wec_addScripts()
{
	wp_enqueue_script('post');
    wp_enqueue_script('scriptaculous');
    wp_enqueue_script('sack');
	wp_enqueue_script('CalendarPluginYUI', '/'.PLUGINDIR.INSTALLED_FOLDER_NAME.'/js/wec.min.js');
    wp_enqueue_style('wec_CalendarView', '/'.PLUGINDIR.INSTALLED_FOLDER_NAME.'/css/wec.min.css');
}

function wec_print_scripts(){
	//nothing here. 
}
function wec_currentVersion()
{
    return WEC_VERSION;
}
function wec_checkVersion()
{
    return get_option('wec_versionNumber');
}
function wec_currentURL()
{
    return substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/")+1);
}

/** 
 *
 * @return null
 * @param object $versionNumber
 */
function wec_updateVersion($versionNumber)
{
    update_option('wec_versionNumber', $value = $versionNumber);
}


if (!function_exists('wp_timezone_choice'))
{

    /**
     * Gives a nicely formatted list of timezone strings // temporary! Not in final
     *
     * @param string $selectedzone - which zone should be the selected one
     *
     */
    function wp_timezone_choice($selectedzone)
    {
        static $mo_loaded = false;

        $continents = array ('Africa', 'America', 'Antarctica', 'Arctic', 'Asia', 'Atlantic', 'Australia', 'Europe', 'Indian', 'Pacific', 'Etc');

        // Load translations for continents and cities
        if (!$mo_loaded)
        {
            $locale = get_locale();
            $mofile = WP_LANG_DIR."/continents-cities-$locale.mo";
            load_textdomain('continents-cities', $mofile);
            $mo_loaded = true;
        }

        $all = timezone_identifiers_list();

        $i = 0;
        foreach ($all as $zone)
        {
            $zone = explode('/', $zone);
            if (!in_array($zone[0], $continents))
            continue ;
            if ($zone[0] == 'Etc' && in_array($zone[1], array ('UCT', 'GMT', 'GMT0', 'GMT+0', 'GMT-0', 'Greenwich', 'Universal', 'Zulu')))
            continue ;
            $zonen[$i]['continent'] = isset ($zone[0])?$zone[0]:'';
            $zonen[$i]['city'] = isset ($zone[1])?$zone[1]:'';
            $zonen[$i]['subcity'] = isset ($zone[2])?$zone[2]:'';
            $i++;
        }

        usort($zonen, create_function(
        '$a, $b', '
		$t = create_function(\'$s\', \'return translate(str_replace("_", " ", $s), "continents-cities");\');
		$a_continent = $t($a["continent"]);
		$b_continent = $t($b["continent"]);
		$a_city = $t($a["city"]);
		$b_city = $t($b["city"]);
		$a_subcity = $t($a["subcity"]);
		$b_subcity = $t($b["subcity"]);
		if ( $a_continent == $b_continent && $a_city == $b_city )
			return strnatcasecmp($a_subcity, $b_subcity);
		elseif ( $a_continent == $b_continent )
			return strnatcasecmp($a_city, $b_city);
		else
			return strnatcasecmp($a_continent, $b_continent);
		'));

        $structure = '';
        $pad = '&nbsp;&nbsp;&nbsp;';

        if ( empty($selectedzone))
        $structure .= '<option selected="selected" value="">'.__('Select a city')."</option>\n";
        foreach ($zonen as $zone)
        {
            extract($zone);
            if ( empty($selectcontinent) && ! empty($city))
            {
                $selectcontinent = $continent;
                $structure .= '<optgroup label="'.esc_attr(translate($continent, "continents-cities")).'">'."\n"; // continent
            } elseif (! empty($selectcontinent) && $selectcontinent != $continent)
            {
                $structure .= "</optgroup>\n";
                $selectcontinent = '';
                if (! empty($city))
                {
                    $selectcontinent = $continent;
                    $structure .= '<optgroup label="'.esc_attr(translate($continent, "continents-cities")).'">'."\n"; // continent
                }
            }

            if (! empty($city))
            {
                $display = str_replace('_', ' ', $city);
                $display = translate($display, "continents-cities");
                if (! empty($subcity))
                {
                    $display_subcity = str_replace('_', ' ', $subcity);
                    $display_subcity = translate($display_subcity, "continents-cities");
                    $city = $city.'/'.$subcity;
                    $display = $display.'/'.$display_subcity;
                }
                if ($continent == 'Etc')
                    $display = strtr($display, '+-', '-+');
                $structure .= "\t<option ".((($continent.'/'.$city) == $selectedzone)?'selected="selected"':'')." value=\"".($continent.'/'.$city)."\">$pad".$display."</option>\n"; //Timezone
        } else
        {
            $structure .= "<option ".(($continent == $selectedzone)?'selected="selected"':'')." value=\"".$continent."\">".translate($continent, "continents-cities")."</option>\n"; //Timezone
    }
}


//==================================================
//	Provides backwards support for pre-2.8
//==================================================
if (! empty($selectcontinent))
$structure .= "</optgroup>\n";
return $structure;
}

function esc_attr($text)
{
    $safe_text = wp_check_invalid_utf8($text);
$safe_text = _wp_specialchars($safe_text, ENT_QUOTES);
return apply_filters('attribute_escape', $safe_text, $text);
}


/**
 * Converts a number of special characters into their HTML entities.
 *
 * Specifically deals with: &, <, >, ", and '.
 *
 * $quote_style can be set to ENT_COMPAT to encode " to
 * &quot;, or ENT_QUOTES to do both. Default is ENT_NOQUOTES where no quotes are encoded.
 *
 * @since 1.2.2
 *
 * @param string $string The text which is to be encoded.
 * @param mixed $quote_style Optional. Converts double quotes if set to ENT_COMPAT, both single and double if set to ENT_QUOTES or none if set to ENT_NOQUOTES. Also compatible with old values; converting single quotes if set to 'single', double if set to 'double' or both if otherwise set. Default is ENT_NOQUOTES.
 * @param string $charset Optional. The character encoding of the string. Default is false.
 * @param boolean $double_encode Optional. Whether or not to encode existing html entities. Default is false.
 * @return string The encoded text with HTML entities.
 */
function _wp_specialchars($string, $quote_style = ENT_NOQUOTES, $charset = false, $double_encode = false)
{
    $string = (string)$string;

if (0 === strlen($string))
{
    return '';
}

// Don't bother if there are no specialchars - saves some processing
if (!preg_match('/[&<>"\']/', $string))
{
    return $string;
}

// Account for the previous behaviour of the function when the $quote_style is not an accepted value
if ( empty($quote_style))
{
    $quote_style = ENT_NOQUOTES;
} elseif (!in_array($quote_style, array (0, 2, 3, 'single', 'double'), true))
{
    $quote_style = ENT_QUOTES;
}

// Store the site charset as a static to avoid multiple calls to wp_load_alloptions()
if (!$charset)
{
    static $_charset;
if (! isset ($_charset))
{
    $alloptions = wp_load_alloptions();
$_charset = isset ($alloptions['blog_charset'])?$alloptions['blog_charset']:'';
}
$charset = $_charset;
}
if (in_array($charset, array ('utf8', 'utf-8', 'UTF8')))
{
    $charset = 'UTF-8';
}

$_quote_style = $quote_style;

if ($quote_style === 'double')
{
    $quote_style = ENT_COMPAT;
$_quote_style = ENT_COMPAT;
} elseif ($quote_style === 'single')
{
    $quote_style = ENT_NOQUOTES;
}

// Handle double encoding ourselves
if (!$double_encode)
{
    $string = wp_specialchars_decode($string, $_quote_style);
$string = preg_replace('/&(#?x?[0-9a-z]+);/i', '|wp_entity|$1|/wp_entity|', $string);
}

$string = @htmlspecialchars($string, $quote_style, $charset);

// Handle double encoding ourselves
if (!$double_encode)
{
    $string = str_replace( array ('|wp_entity|', '|/wp_entity|'), array ('&', ';'), $string);
}

// Backwards compatibility
if ('single' === $_quote_style)
{
    $string = str_replace("'", '&#039;', $string);
}

return $string;
}

}



?>
