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

    function __call($methodName, $args)
    {
        $findType = 'findAll';
        $field = '';
        $condition = array();

        if (strpos($methodName, 'findAllBy') === 0) {
            $field = uncamelize(str_replace('findAllBy', '', $methodName));
        } elseif (strpos($methodName, 'findBy') === 0) {
            $field = uncamelize(str_replace('findBy', '', $methodName));
            $findType = 'findBy';
        }

        $conditions = array($field => array_shift($args));
        array_unshift($args, $conditions);

        return call_user_func_array(array($this, $findType), $args);
    }

    /**
     * Validate by property validates in model
     *
     * @return bool Validate status
     */
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

    /**
     * Find is the multifunctional workhorse of all model data-retrieval functions
     *
     * @param string $type Find type (all|first|count)
     * @param array $params Array find params (find conditions, limit, ...)
     * @return array Result array
     */
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

    /**
     * Find all by <FieldName>
     *
     * @param array $conditions Find conditions
     * @param array $fields Field list want to retrieve
     * @param array $order List order fields,
     * @param int $limit Limit number rows
     * @param int $offset Offset row start
     * @return array Result array
     */
    public function findAll($conditions = array(), $fields = array(), $order = array(), $limit = null, $offset = null)
    {
        $field = key($conditions);
        $params["conditions"] = array(
            $field => $conditions[$field]
        );

        if (count($fields) > 0) {
            $params["fields"] = $fields;
        }

        if (count($order) > 0) {
            $params["order"] = $order;
        }

        if ($limit !== null && is_numeric($limit)) {
            $params["limit"] = $limit;
        }

        if ($offset !== null && is_numeric($offset)) {
            $params["offset"] = $offset;
        }

        return $this->find('all', $params);
    }

    public function findBy($conditions = array(), $fields = array(), $order = array())
    {
        $field = key($conditions);
        $params["conditions"] = array(
            $field => $conditions[$field]
        );

        if (count($fields) > 0) {
            $params["fields"] = $fields;
        }

        if (count($order) > 0) {
            $params["order"] = $order;
        }

        return $this->find('first', $params);
    }
}
