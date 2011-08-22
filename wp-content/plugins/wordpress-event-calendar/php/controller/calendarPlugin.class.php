<?php
/**
 * @deprecated THIS FILE IS SLATED FOR DELETION
 *
 * @abstract
 * @classDescription The calendar plugin class that has methods to find out option values
 */
class calendarPlugin
{
    private $isInstalled = true;
    private $versionNumber;

    function __construct()
    {
        $this->setIsInstalled();
    }

    /**
     * Returns $isInstalled.
     * @see calendarPlugin::$isInstalled
     */
    function setIsInstalled()
    {
        if (!get_option('wec_versionNumber'))
        {
            $this->isInstalled = false;
        }
    }

    function isInstalled()
    {
        return $this->isInstalled;
    }


    public function upToDate()
    {
        $upToDate = true;
        if (wec_checkVersion() < wec_currentVersion())
        {
            $upToDate = false;
        }
        return $upToDate;
    }

    /**
     * Returns $versionNumber.
     * @see calendarPlugin::$versionNumber
     */
    final public function getVersionNumber()
    {
        return $this->versionNumber;
    }

    /**
     * Sets $versionNumber.
     * @param object $versionNumber
     * @see calendarPlugin::$versionNumber
     */
    final private function setVersionNumber($versionNumber)
    {
        $this->versionNumber = get_option('wec_versionNumber');
    }

    function getInstalledFolderName()
    {
        return basename(dirname(dirname( __FILE__ )));
    }

    function getInstalledPath()
    {
        return '/wp-content/plugins/'.calendarPlugin::getInstalledFolderName();
    }

    function defaultTimeZoneSet()
    {
        if (!get_option('wec_default_time_zone'))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    function getDefaultTimeZoneName()
    {
       
        if (!get_option('wec_default_time_zone'))
        {
            $systemLocale = false;
        }
        else
        {
            $systemLocale = get_option('wec_default_time_zone');
        }

        return $systemLocale;

    }
}

?>
