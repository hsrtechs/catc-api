<?php   namespace hsrtech\catc;

use \Curl\Curl;

/**
 * Class Wrapper
 * @package hsrtech\catc
 */
class Wrapper extends Curl
{
    /**
     * @var mixed|string
     */
    private $_params = [],
            $_base_link = "https://panel.cloudatcost.com/api",
            $_result = NULL,
            $_api_version = 'v1';

    /**
     * @array List of the commands
     */
    const ACTIONS = [
            'servers'   =>  'listservers.php',
            'templates' =>  'listtemplates.php',
            'tasks'     =>  'listtasks.php',
            'power'     =>  'powerop.php',
            'rename'    =>  'renameserver.php',
            'rdns'      =>  'rdns.php',
            'console'   =>  'console.php',
            'runmode'   =>  'runmode.php',
            'build'     =>  'cloudpro/build.php',
            'delete'    =>  'cloudpro/delete.php',
            'resources' =>  'cloudpro/resources.php',
        ];

    /**
     * Wrapper constructor.
     * @param array $api_params
     * @throws \ErrorException
     * @throws \Exception
     * @internal param array $extra_params
     */
    public function __construct(array $api_params = [])
    {
        parent::__construct();
        if(empty($api_params['email']) || empty($api_params['api_key']))
        {
            throw new \Exception('User Email and API key is Required');
        }

        $this->_params = $api_params;
        return true;
    }

    /**
     * Set the link to the api if the link is different then CloutAtCost
     * @param $link
     */
    public function setLink($link){
        $this->_base_link = (!isset($link)) ? $this->_base_link: $link;
    }

    /**
     * Set the API version if the version is other then v1
     * @param $API_VERSION
     */
    public function selAPIVersion($API_VERSION){
        $this->_api_version = (!isset($API_VERSION)) ? $this->_api_version : $API_VERSION;
    }

    /**
     * Retrieve the list of the Servers from the external website
     * @return mixed|string
     */
    public function getServers()
    {
        $this->request(self::ACTIONS['servers'],'GET');
        return $this->result();
    }

    /**
     * Get the List of templates
     * @return mixed|string
     */
    public function getTemplates(){
        $this->request(self::ACTIONS['templates'],'GET');
        return $this->result();
    }

    /**
     * Get the list of Tasks Performed
     * @return mixed|string
     */
    public function getTasks()
    {
        $this->request(self::ACTIONS['tasks'],'GET');
        return $this->result();
    }

    /**
     * @param $Server_ID
     * @return mixed|string
     * @throws \Exception
     */
    public function powerOnServer($Server_ID)
    {
        if(!is_numeric($Server_ID)) return('Invalid Server ID');
        return $this->powerop($Server_ID,'poweron');
    }


    /**
     * @param $Server_ID
     * @return mixed
     * @throws \Exception
     */
    public function powerOffServer($Server_ID)
    {
        if(!is_numeric($Server_ID)) return('Invalid Server ID');
        return $this->powerop($Server_ID,'poweroff');
    }

    /**
     * @param $Server_ID
     * @return mixed|string
     * @throws \Exception
     */
    public function rebootServer($Server_ID)
    {
        if(!is_numeric($Server_ID)) return('Invalid Server ID');
        return $this->powerop($Server_ID,'reset');
    }

    /**
     * @param $Server_ID
     * @param $action
     * @return mixed|string
     * @throws \Exception
     */
    private function powerop($Server_ID,$action)
    {
        $this->_params['sid'] = $Server_ID;
        $this->_params['action'] = $action;
        $this->request(self::ACTIONS['power']);
        return (!empty($this->result()->result)) ? $this->result()->result : $this->result();
    }

    /**
     * @param $Server_ID
     * @param $action
     * @return mixed|string
     * @throws \Exception
     */
    public function runMode($Server_ID,$action)
    {
        if(!is_numeric($Server_ID)) return('Invalid Server ID');

        $options = ['normal','safe'];
        if(!in_array($action,$options)) return("Invalid Run Mode");

        $this->_params['sid'] = $Server_ID;
        $this->_params['mode'] = $action;
        $this->request(self::ACTIONS['runmode']);
        return (!empty($this->result()->result)) ? $this->result()->result : $this->result();
    }

    /**
     * @param $Server_ID
     * @param $name
     * @return mixed|string
     * @throws \Exception
     */
    public function renameServer($Server_ID,$name)
    {
        if(!is_numeric($Server_ID)) return('Invalid Server ID');
        $this->_params['sid'] = $Server_ID;
        $this->_params['name'] = $name;
        $this->request(self::ACTIONS['rename']);
        return (!empty($this->result()->result)) ? $this->result()->result : $this->result();
    }

    /**
     * @param $Server_ID
     * @param $RDNS
     * @return mixed|string
     * @throws \Exception
     */
    public function setRDNS($Server_ID,$RDNS)
    {
        if(!is_numeric($Server_ID)) return('Invalid Server ID');
        $this->_params['sid'] = $Server_ID;
        $this->_params['hostname'] = $RDNS;
        $this->request(self::ACTIONS['rdns']);
        return (!empty($this->result()->result)) ? $this->result()->result : $this->result();
    }

    /**
     * @param $Server_ID
     * @return mixed|string
     * @throws \Exception
     */
    public function getConsole($Server_ID)
    {
        if(!is_numeric($Server_ID)) return('Invalid Server ID');
        $this->_params['sid'] = $Server_ID;
        $this->request(self::ACTIONS['console']);
        return (!empty($this->result()->console)) ? $this->result()->console : $this->result();
    }

    /**
     * @param $params
     * @return mixed|string
     * @throws \Exception
     */
    public function buildServer($params)
    {
        if(empty($params['cpu']) || empty($params['ram']) || empty($params['storage']) || empty($params['os'])) return ("Incomplete Data Provided.");
        if(!is_numeric($params['cpu']) || !is_numeric($params['ram']) || !is_numeric($params['storage']) || !is_numeric($params['os'])) return ("Invalid Data Provided.");
        $this->_params['cpu'] = $params['cpu'];
        $this->_params['ram'] = $params['ram'];
        $this->_params['storage'] = $params['storage'];
        $this->_params['os'] = $params['os'];
        $this->request(self::ACTIONS['build']);
        return (!empty($this->result()->result)) ? $this->result()->result : $this->result();
    }

    /**
     * @param $Server_ID
     * @return mixed|string
     * @throws \Exception
     */
    public function deleteServer($Server_ID)
    {
        if(!is_numeric($Server_ID)) return('Invalid Server ID');
        $this->_params['sid'] = $Server_ID;
        $this->request(self::ACTIONS['delete']);
        return (!empty($this->result()->result)) ? $this->result()->result : $this->result();
    }

    /**
     * @return mixed|string
     * @throws \Exception
     */
    public function resources()
    {
        $this->request(self::ACTIONS['resources']);
        return $this->result();
    }



    /**
     * @return mixed|string
     */
    public function result()
    {
        return $this->_result;
    }

    /**
     * @return mixed
     */
    public function getEmail(){
        return $this->_params['email'];
    }

    /**
     * @return the api key
     */
    public function getkey(){
        return $this->_params;
    }

    /**
     * @param $link
     * @param string $type
     * @return bool
     * @throws \Exception
     */
    private function request($link = NULL , $type = 'POST')
    {
        if($type === "GET")
        {
            try
            {
                if($type === 'GET')
                {
                    $this->get($this->_base_link.'/'.$this->_api_version.'/'.$link, $this->_params);
                }
                else if($type === 'POST')
                {
                    $this->post($this->_base_link.'/'.$this->_api_version.'/'.$link, $this->_params);
                }
                else throw new \Exception("Invalid Request");

                $curl = json_decode($this->response);

                if($curl->status === "OK")
                {
                    if(isset($curl->data)) $this->_result = $curl->data;
                    return true;
                }else
                {
                    $this->_result = $curl;
                    return false;
                }
            }catch(\Exception $e)
            {
                return ($e->getMessage());
            }
        }
        return false;

    }

}