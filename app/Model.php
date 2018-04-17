<?php

namespace App;

/**
* Class Model for all src/models
*/
abstract class Model
{
	public $originalData = [];

    private $errors = [];

	public abstract static function metadata();
	
	public abstract static function getManager();

    public function isValid() 
    {
        foreach($this->metadata()["columns"] as $name => $definition) {
            if (isset($definition["constraints"])) {
                foreach($definition["constraints"] as $type => $details) {

                    if ($type == "required" && !$this->{'get' . ucfirst($definition["property"])}()) {
                        $this->errors[] = $details["message"];
                    }
                    if ($type == "length" && isset($details["min"]) && strlen(trim($this->{'get' . ucfirst($definition["property"])}())) < $details["min"]) {
                        $this->errors[] = $details["minMessage"];
                    }
                                    
                    if ($type == "length" && isset($details["max"]) && strlen(trim($this->{'get' . ucfirst($definition["property"])}())) > $details["max"]) {
                        $this->errors[] = $details["maxMessage"];
                    }

                }
            }
        }
        return count($this->errors) == 0;
    }

    public function hydrate($result)
    {
        if(empty($result)) {
            return NULL;
        }

        foreach($result as $column => $value) {
            $this->originalData[$column] = $value;
            $this->hydrateProperty($column, $value);
        }
        return $this;
    }

    private function hydrateProperty($column, $value)
    {
        switch($this::metadata()["columns"][$column]["type"]) {
            case "integer":
                $this->{'set' . ucfirst($this::metadata()["columns"][$column]["property"])}($value);
                break;
            case "string":
                $this->{'set' . ucfirst($this::metadata()["columns"][$column]["property"])}($value);
                break;
            case "datetime":
                $datetime = \DateTime::createFromFormat("Y-m-d H:i:s", $value);
                $this->{'set' . ucfirst($this::metadata()["columns"][$column]["property"])}($datetime);
                break;
        }
    }

	public function getSQLValueByColumn($column)
	{
		$value = $this->{'get' . ucfirst($this::metadata()["columns"][$column]["property"])}();
		if ($value instanceof \DateTime) {
			return $value->format("Y-m-d H:i:s");
		}
		return $value;
	}

    public function setPrimaryKey($value)
    {
        $this->hydrateProperty($this::metadata()["primaryKey"], $value);
    }

    public function getPrimaryKey()
    {
        $primaryKeyColumn = $this::metadata()["primaryKey"];
        $property = $this::metadata()["columns"][$primaryKeyColumn]["property"];
        return $this->{'get'. ucfirst($property)}();
    }

    public function getErrors()
    {
        return $this->errors;
    }
}