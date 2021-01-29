<?php

namespace Entity;

use Exception;

class User {
    private ?int $id = null;
    private ?string $name = null;
    private ?string $lastname = null;
    private ?string $email = null;
    private ?string $created = null;
    private ?string $logintimestamp = null;
    private ?string $prevlogintimestamp = null;
    private ?string $password = null;
    private ?string $updated = null;
    private ?bool $superuser = false;
    private array $inmutablesProperties = ['id', 'created'];
    private array $invisbleProperties = ['password', 'inmutablesProperties', 'invisbleProperties'];

    public function getId() : ?int {
        return $this->id;
    }

    public function getName() : ?string {
        return $this->name;
    }

    public function getLastName() : ?string {
        return $this->lastname;
    }

    public function getEmail() : ?string {
        return $this->email;
    }

    public function getCreated() : ?string {
        return $this->created;
    }

    public function getLoginTimeStamp() : ?string {
        return $this->logintimestamp;
    }
    public function getPrevLoginTimeStamp() : ?string {
        return $this->prevlogintimestamp;
    }

    public function getPassword() : ?string {
        return $this->password;
    }

    public function getUpdated() : ?string {
        return $this->updated;
    }

    public function getAsJson() : string {
        return json_encode($this->getAsArray());
    }

    public function isSuperUser() : bool {
        if(is_null($this->superuser))
            return false;
        return $this->superuser;
    }

    public function getAsArray() : array {
        $vars = get_object_vars($this);
        foreach($this->invisbleProperties as $invProp){
            unset($vars[$invProp]);
        }
        return $vars;
    }

    public function fillFromArray(array $data) : bool {
        foreach($data as $property => $value) {
            if( in_array($property, $this->inmutablesProperties)){
                continue;
            }
            if(!property_exists($this, $property)){
                return false;
            }
            $this->$property = $value;
        }
        return false;
    }

    // id puede ser nulo
    public function isValid() : bool {
        if(!empty($this->password)
                && !empty($this->name)
                && !empty($this->lastname)
                && !empty($this->email)
                && !empty($this->password)){
            return true;
        }
        return false;
    }
}
