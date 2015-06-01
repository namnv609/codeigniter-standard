<?php

if (!defined('BASEPATH'))
    exit('Restricted access');

class MY_Model extends CI_Model
{
    public $validates = array();
    public $tableName = "";
    public $primaryKey = "id";

    public function __construct()
    {
        parent::__construct();
    }

    public function validation()
    {
        $validation_rules = array();
        $validates = $this->validates;
        $columnMap = array();

        if (method_exists($this, 'columnMap')) {
            $columnMap = $this->columnMap();
        }

        foreach ($validates as $field => $validate) {
            $mapField = $field;

            if (isset($columnMap[$field])) {
                $mapField = $columnMap[$field];
            }

            $validation_rules[] = array(
                'field' => $mapField,
                'label' => $validate['label'],
                'rules' => implode("|", $validate['rules'])
            );
        }

        $this->form_validation->set_rules($validation_rules);
        return $this->form_validation->run();
    }

    public function find($type, $params = array())
    {
        $fields = "*";
        $result = array();

        if (isset($params["fields"]) && is_array($params["fields"])) {
            $fields = implode(",", $params["fields"]);
        }

        $query = $this->db->select($fields)
                          ->from($this->tableName);

        if (isset($params["order"])) {
            $query = $query->order_by(implode(",", $params["order"]));
        }

        if (isset($params["group"])) {
            $query = $query->group_by($params["group"]);
        }

        if (isset($params["limit"])) {
            $offset = 0;

            if (isset($params["offset"])) {
                $offset = $params["offset"];
            }

            $query = $query->limit($params["limit"], $offset);
        }

        if (isset($params["conditions"])) {
            $andWhereConditions = array();
            $orWhereConditions = array();

            if (isset($params["conditions"]["OR"])) {
                $query = $query->or_where($params["conditions"]["OR"]);
                unset($params["conditions"]["OR"]);
            }

            if (isset($params["conditions"]["IN"])) {
                $whereInConditions = $params["conditions"]["IN"];
                $whereInField = key($whereInConditions);

                $query = $query->where_in($whereInField, $whereInConditions[$whereInField]);
                unset($params["conditions"]["IN"]);
            }

            if (isset($params["conditions"]["NOT IN"])) {
                $whereNotInConditions = $params["conditions"]["NOT IN"];
                $whereNotInField = key($whereNotInConditions);

                $query = $query->where_not_in($whereNotInField, $whereNotInConditions[$whereNotInField]);
                unset($params["conditions"]["NOT IN"]);
            }

            $query = $query->where($params["conditions"]);
        }

        if (isset($params["joins"])) {
            foreach ($params["joins"] as $join) {
                $alias = $join["table"];
                $joinType = "inner";

                if (isset($join["alias"])) {
                    $alias = $join["alias"];
                }

                if (isset($join["type"])) {
                    $joinType = $join["type"];
                }

                $query = $query->join(
                    $join["table"] . " AS " . $alias,
                    implode(",", $join["conditions"]),
                    strtoupper($joinType)
                );
            }
        }

        $query = $query->get();

        switch($type) {
            case "first":
                $result = $query->row_array();
                break;
            case "count":
                $result = $query->num_rows();
                break;
            default:
                $result = $query->result_array();
        }

        return $result;
    }
}
