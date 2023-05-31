<?php
namespace App\Service;

use DeviceDetector\DeviceDetector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class DeviceService
{
    /**
     * Browser accpected languages
     *
     * @var array
     */
    private $locales;

    /**
     * Request Stack
     *
     * @var \RequestStack
     */
    private $requestStack;

    /**
     * Current Request
     *
     * @var Request
     */
    private $request;

    private $deviceDetector;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->request = $this->requestStack->getCurrentRequest();

        $ua = $this->getUserAgent();

        if ($ua)
        {
            $this->deviceDetector = new DeviceDetector( $ua );
            $this->deviceDetector->parse();
        }

        $this->setLocales();
    }

    

    public function getUserAgent(): ?string
    {
        return $this->request ? $this->request->headers->get('User-Agent') : null;
    }

    /**
     * Browser INFO
     */

    public function getClient()
    {
        return $this->deviceDetector->getClient();
    }

    public function getClientType()
    {
        $client = $this->getClient();

        if (isset($client['type'])) 
        {
            return $client['type'];
        }

        return null;
    }

    public function getClientName()
    {
        $client = $this->getClient();

        if (isset($client['name'])) 
        {
            return $client['name'];
        }

        return null;
    }

    public function getClientVersion()
    {
        $client = $this->getClient();

        if (isset($client['version'])) 
        {
            return $client['version'];
        }

        return null;
    }


    /**
     * OS INFO
     */

    public function getOs()
    {
        return $this->deviceDetector->getOs();
    }

    public function getOsName()
    {
        $os = $this->getOs();

        if (isset($os['name']))
        {
            return $os['name'];
        }

        return null;
    }

    public function getOsVersion()
    {
        $os = $this->getOs();

        if (isset($os['version']))
        {
            return $os['version'];
        }

        return null;
    }


    /**
     * Device INFO
     */

    public function getDevice()
    {
        return $this->deviceDetector->getDeviceName();
    }

    public function getBrand()
    {
        return $this->deviceDetector->getBrandName();
    }

    public function getModel()
    {
        return $this->deviceDetector->getModel();
    }


    /**
     * BOTS INFO
     */

    public function isBot(): bool
    {
        return $this->deviceDetector->isBot();
    }

    public function botInfo()
    {
        return $this->deviceDetector->getBot();
    }


    /**
     * Locales
     */

    private function setLocales()
    {
        $acceptedLanguages = [];

        $languages = $this->request ? $this->request->headers->get('Accept-Language') : null;

        if ($languages)
        {
            $languages = explode(",", $languages);
    
            foreach ($languages as $language)
            {
                $language = explode(";", $language);
                $language = $language[0];
    
                if (!in_array($language, $acceptedLanguages))
                {
                    array_push($acceptedLanguages, $language);
                }
            }
        }
        
        $this->locales = $acceptedLanguages;

        return $this;
    }

    public function getLocales(bool $withRegion=false): array
    {
        $locales = $this->locales;

        if (!$withRegion)
        {
            $_locales = [];
            foreach ($locales as $key => $locale)
            {
                $locale = explode("-", $locale);
                $locale = $locale[0];

                if (!in_array($locale, $_locales))
                {
                    array_push($_locales, $locale);
                }
            }
            
            $locales = $_locales;
        }

        return $locales;
    }

    public function getPreferredLocale(bool $withRegion=false): ?string
    {
        $locales = $this->getLocales($withRegion);

        return isset($locales[0]) ? $locales[0] : null;
    }

}



// "ipNumber" => "1437130926"
// "ipVersion" => 4
// "ipAddress" => "85.168.224.174"
// "mcc" => "This parameter is unavailable in selected .BIN data file. Please upgrade."
// "mnc" => "This parameter is unavailable in selected .BIN data file. Please upgrade."
// "mobileCarrierName" => "This parameter is unavailable in selected .BIN data file. Please upgrade."
// "weatherStationName" => "This parameter is unavailable in selected .BIN data file. Please upgrade."
// "weatherStationCode" => "This parameter is unavailable in selected .BIN data file. Please upgrade."
// "iddCode" => "This parameter is unavailable in selected .BIN data file. Please upgrade."
// "areaCode" => "This parameter is unavailable in selected .BIN data file. Please upgrade."
// "latitude" => "This parameter is unavailable in selected .BIN data file. Please upgrade."
// "longitude" => "This parameter is unavailable in selected .BIN data file. Please upgrade."
// "countryName" => "France"
// "countryCode" => "FR"
// "usageType" => "This parameter is unavailable in selected .BIN data file. Please upgrade."
// "elevation" => "This parameter is unavailable in selected .BIN data file. Please upgrade."
// "netSpeed" => "This parameter is unavailable in selected .BIN data file. Please upgrade."
// "timeZone" => "This parameter is unavailable in selected .BIN data file. Please upgrade."
// "zipCode" => "This parameter is unavailable in selected .BIN data file. Please upgrade."
// "domainName" => "This parameter is unavailable in selected .BIN data file. Please upgrade."
// "isp" => "This parameter is unavailable in selected .BIN data file. Please upgrade."
// "cityName" => "This parameter is unavailable in selected .BIN data file. Please upgrade."
// "regionName" => "This 