<?php

namespace App;

/**
* Class Model for all src/models
*/
abstract class Model
{
	public $originalData = [];

	public abstract static function metadata();
	
	public abstract static function getManager();

    public function hydrate($result)
    {
        if(empty($result)) {
            throw new ModelException("Aucun résultat n'a été trouvé !");
        }
        $this->originalData = $result;
        foreach($result as $column => $value) {
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
}