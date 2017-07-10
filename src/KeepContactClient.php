<?php

namespace KeepContact;

/**
 * Description of Client
 *
 * @author Maxime Cazé <maximecaze@coriolis.fr>
 */
class KeepContactClient
{
    private $uri;
    private $login;
    private $password;
    
    public function __construct($uri, $login, $password) 
    {
        $this->uri = $uri;
        $this->login = $login;
        $this->password = $password;
    }
    
    /**
     * Requête HTTP de la ressource
     * @param string $action
     * @param string $phone_number
     * @param string $message
     * @param string $transmitter
     * @param array $additional_parameters
     * @param boolean $no_stop
     * @return boolean
     * @throws \Exception
     */
    private function call($action, $phone_number, $message, $transmitter, $additional_parameters, $no_stop)
    {
        try {
            // création de la requête
            $request = \Httpful\Request::post($this->uri . $action); 
            $request->addHeaders(array(
                'Content-Type' => 'application/json'
            ));
            // authentification
            $request->authenticateWith($this->login, $this->password);           
            // mise en place des paramètres
            $parameters = array(
                'phone_number' => $phone_number,
                'message' => $message,
            );
            if (!is_null($transmitter)) {
                $parameters['transmitter'] = $transmitter;
            }
            if (!empty($additional_parameters)) {
                $parameters['additional_parameters'] = $additional_parameters;
            }
            $parameters['no_stop'] = $no_stop === true ? 1 : 0;
            // passage des paramètres à la requête
            if (!empty($parameters)) {
                $request->body(json_encode($parameters));
            }
            // envoi de la requête
            $response = $request->send();
            
            if ($response->code != 200) {
                throw new \Exception($response->body->message, $response->code);
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex->getPrevious());
        }
        return true;
    }
    
    /**
     * Envoi un SMS
     * @param string $phone_number
     * @param string $message
     * @param string $transmitter
     * @param array $additional_parameters
     * @param boolean $no_stop
     * @return boolean
     * @throws \Exception
     */
    public function sendSms($phone_number, $message, $transmitter = null, $additional_parameters = array(), $no_stop = false)
    {
        try {
            return $this->call('sms', $phone_number, $message, $transmitter, $additional_parameters, $no_stop);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex->getPrevious());
        }
        return false;
    }
    
    /**
     * Envoi un SMS to CallBack
     * @param string $phone_number
     * @param string $message
     * @param string $transmitter
     * @param array $additional_parameters
     * @param boolean $no_stop
     * @return boolean
     * @throws \Exception
     */
    public function sendSmsToCallback($phone_number, $message, $transmitter = null, $additional_parameters = array(), $no_stop = false)
    {
        try {
            return $this->call('sms_to_callback', $phone_number, $message, $transmitter, $additional_parameters, $no_stop);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex->getPrevious());
        }
        return false;
    }
}

