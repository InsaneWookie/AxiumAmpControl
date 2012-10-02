<?php

require_once("php_serial.class.php");

/**
 * Description of CAxiumControl
 *
 * @author Rowan
 */
class CAxiumControl 
{
    
    protected $comPort = "/dev/cu.usbserial-FTFQSY6U";
    
    private $serialHandle = null;
    
    //Commands
    const CMD_STANDBY = '01';
    const CMD_MUTE = '02';
    const CMD_VOLUME = '04';
    
    //zone
    const ZONE_ALL = 'FF';
    
    //Data
    const DATA_STANDBY_A_OFF = '00';
    const DATA_STANDBY_A_ON = '01';
    const DATA_STANDBY_B_OFF ='02';
    const DATA_STANDBY_B_ON = '03';
    
    const DATA_MUTE = '00';
    const DATA_UNMUTE = '01';
    
    
    const VOLUME_MAX = 160; //0xA0
    
    public function __construct($comPort)
    {
        //set up comport
        $result = true;
        $this->comPort = $comPort;
        
        $this->serialHandle = new phpSerial();
        $result &= $this->serialHandle->deviceSet($this->comPort);

        if($this->serialHandle->getOS() != 'windows')
        {
/*
            $this->serialHandle->confBaudRate(9600);
            $this->serialHandle->confParity('none');
            $this->serialHandle->confCharacterLength(8);
            $this->serialHandle->confStopBits(1);
            $this->serialHandle->confFlowControl('none');
        */
        }
        
        $result &= $this->serialHandle->deviceOpen('r+b');
        
        if($result === false)
        {
            echo "error opening device";
        }
    }
    
   // function __destruct() 
    //{
    //    $this->serialHandle->deviceClose();
    //    $this->serialHandle = null;
    //}
    
    public function sendMessage($message)
    {
       $this->serialHandle->sendMessage($message . "\r\n");
    }
    
    /***
     * converts a zone number into a 2 digit ascii number (ie 0 padded)
     */
    public static function convertZone($zone)
    {
       if($zone < 10)
        {
            return '0' . $zone;
        }
        
        return (string)$zone;
    }


    public function setVolume($zone, $percent)
    {
       $percent = ($percent > 100) ? 100 : $percent;
       $percent = ($percent < 0) ? 0 : $percent;
       
        //convert percent 0-100 to volume 0-160
       
       $volume = (int)(($percent/100) * self::VOLUME_MAX);
       
       $message = self::CMD_VOLUME . self::convertZone($zone) . $volume;
       
       $this->sendMessage($message);
        
    }
    
    public function setMute($zone, $isMuted)
    {
       $zone = self::convertZone($zone);
       
       $data = ($isMuted) ? self::DATA_MUTE : self::DATA_UNMUTE;
       
       $message = self::CMD_MUTE . $zone . $data;
       $this->sendMessage($message);
    }
    
     
    
    public function standByAll()
    {
        $this->sendMessage(self::CMD_STANDBY . self::ZONE_ALL . self::DATA_STANDBY_A_OFF );
        $this->sendMessage(self::CMD_STANDBY . self::ZONE_ALL . self::DATA_STANDBY_B_OFF );
    }
    
    public function awakeAll()
    {
        $this->sendMessage(self::CMD_STANDBY . self::ZONE_ALL . self::DATA_STANDBY_A_ON );
        $this->sendMessage(self::CMD_STANDBY . self::ZONE_ALL . self::DATA_STANDBY_B_ON );
        
    }
    
}

?>
