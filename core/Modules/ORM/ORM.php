<?php
namespace Core\Modules\ORM;

use Core\Database;

class ORM extends Database {

    public $sql_query='';

    public $table_name = '';

    public $data = array();

    function __construct() {
        //$this->dba=new Database();
    }

    public function findAll($select='', $break = false, $breakModel=array()) {
        if(Database::$db_type=='mysqli') {
            if($this->table_name=='') {
                $this->sql_query = "SELECT ".($select=='' ? '*' : $select)." FROM ".get_called_class().$this->sql_query;
            }
            else {
                $this->sql_query = "SELECT ".($select=='' ? '*' : $select)." FROM ".$this->table_name.$this->sql_query;
            }
            //echo $this->sql_query;
            $s = $this->sql_query;
            $this->sql_query = '';
            $d = $this->data;
            $this->data = array();
            //return Database::pdo_select($s, $d);

            $results = array();
            foreach (Database::pdo_select($s, $d) as $row) {
                $copy = clone($this);
                foreach ($row as $key => $value) {
                    $copy->$key=$value;
                }
                unset($copy->table_name);
                unset($copy->sql_query);
                unset($copy->data);
                $copy->haldleOneToOneRelation($copy, false, $breakModel);
                $results[] = $copy;
            }
            return $results;
        }
    }
    public function find($select='', $break=false, $breakModel=array()) {
        if(Database::$db_type=='mysqli') {
            if($this->table_name=='') {
                $this->sql_query = "SELECT ".($select=='' ? '*' : $select)." FROM ".get_called_class().$this->sql_query;
            }
            else {
                $this->sql_query = "SELECT ".($select=='' ? '*' : $select)." FROM ".$this->table_name.$this->sql_query;
            }
            //echo $this->sql_query;
            $s = $this->sql_query;
            $this->sql_query = '';
            $d = $this->data;
            $this->data = array();
            //return Database::pdo_selectOne($s, $d);
            foreach (Database::pdo_selectOne($s, $d) as $key => $value) {
                $this->$key=$value;
            }
            unset($this->table_name);
            unset($this->sql_query);
            unset($this->data);
            $this->haldleOneToOneRelation($this, false, $breakModel);
            return $this;
        }
    }
    public function where($field, $data) {
        if(Database::$db_type=='mysqli') {
            $this->sql_query .= " WHERE $field=?";
            $this->data[] = $data;
        }
        return $this;
    }
    public function w_and($field, $data) {
        if(Database::$db_type=='mysqli') {
            $this->sql_query .= " AND $field=?";
            $this->data[] = $data;
        }
        return $this;
    }
    public function w_or($field, $data) {
        if(Database::$db_type=='mysqli') {
            $this->sql_query .= " OR $field=?";
            $this->data[] = $data;
        }
        return $this;
    }
    public function innerJoin($table_name, $join_coloumn1, $join_coloumn2) {
        if(Database::$db_type=='mysqli') {
            $this->sql_query .= " LEFT JOIN ".$table_name." ON ".($table_name=='' ? get_called_class().'.'.$join_coloumn1 : $this->table_name.'.'.$join_coloumn1).' = '.$table_name.'.'.$join_coloumn2;
        }
        return $this;
    }
    public function rightJoin($table_name, $join_coloumn1, $join_coloumn2) {
        if(Database::$db_type=='mysqli') {
            $this->sql_query .= " RIGHT JOIN ".$table_name." ON ".($table_name=='' ? get_called_class().'.'.$join_coloumn1 : $this->table_name.'.'.$join_coloumn1).' = '.$table_name.'.'.$join_coloumn2;
        }
        return $this;
    }
    public function save($data) {
        if(Database::$db_type=='mysqli') {
            if($this->table_name=='') {
                $this->sql_query = "INSERT INTO ".get_called_class()." (";
            }
            else {
                $this->sql_query = "INSERT INTO ".$this->table_name." (";
            }
            $i=0;
            foreach($data as $k=>$v) {
                if(gettype($v)!='object' && gettype($v)!='array') {
                  if($i==0) $this->sql_query .= $k;
                      else if($i>0) $this->sql_query .= ",".$k;
                  $i++;
                }
            }
            $this->sql_query = $this->sql_query.") VALUES(";
            return $this->insertHaldleOneToOneRelation($data);
            // $i=0;
            // foreach($data as $k=>$v) {
            //     if(gettype($v)=='object') {
            //         $model = new $this->$k;
            //         $model->save($v);
            //     } else {
            //         if($i==0) $this->sql_query .= "'".$v."'";
            //             else if($i>0) $this->sql_query .= ",'".$v."'";
            //         $i++;
            //     }
            // }
            // $this->sql_query .= ")";
            // //echo $this->sql_query;
            // $s = $this->sql_query;
            // $this->sql_query = '';
            // $d = $this->data;
            // $this->data = array();
            // return Database::pdo_insert($s, $d);
        }
    }
    public function sync($data) {
        if(Database::$db_type=='mysqli') {
            if($this->table_name=='') {
                $this->sql_query = "UPDATE ".get_called_class()." ";
            }
            else {
                $this->sql_query = "UPDATE ".$this->table_name." ";
            }
            $i=0;
            $tmp_sql="";
            foreach($data as $k=>$v) {
                if($i==0 && $k!='id') $this->sql_query .= "SET ".$k."='".$v."'";
                    else if($i>0 && $k!='id') $this->sql_query .= ", ".$k."='".$v."'";
                      else if ($k=='id') {
                          $tmp_sql .= " WHERE id=".$v;
                          continue;
                      }
                $i++;
            }
            $this->sql_query = $this->sql_query.$tmp_sql;
            $s = $this->sql_query;
            $this->sql_query = '';
            $d = $this->data;
            $this->data = array();
            return Database::pdo_update($s, $d);
        }
    }
    public function delete($data) {
        if(Database::$db_type=='mysqli') {
            if($this->table_name=='') {
                $this->sql_query = "DELETE FROM ".get_called_class()." ";
            }
            else {
                $this->sql_query = "DELETE FROM ".$this->table_name." ";
            }
            $this->sql_query = $this->sql_query." WHERE id=".$data;
            $s = $this->sql_query;
            $this->sql_query = '';
            $d = $this->data;
            $this->data = array();
            return Database::pdo_delete($s, $d);
        }
    }
    public function haldleOneToOneRelation($data, $break, $breakModel) {
        foreach (get_class_methods($data) as $method) {
            if (strpos($method, "map") === 0) {
                $relationMetaData = call_user_func_array(array($data, $method), array());
                $val = $relationMetaData->mapFrom;
                $prop = $relationMetaData->property;
                $modelName = $data->$prop;
                $model = new $modelName;
                if($relationMetaData->relation=='OneToOne' && $relationMetaData->fetchType=='eager' && !$break) {
                  if(!in_array($modelName, $breakModel)) $data->$prop=$model->where($relationMetaData->mapTo, $data->$val)->find('', false, $breakModel);
                } else if($relationMetaData->relation=='OneToMany' && $relationMetaData->fetchType=='eager' && !$break) {
                  if(!in_array($modelName, $breakModel)) $data->$prop=$model->where($relationMetaData->mapTo, $data->$val)->findAll('', false, $breakModel);
                } else if($relationMetaData->relation=='ManyToMany' && $relationMetaData->fetchType=='eager' && !$break) {
                  $valMT = $relationMetaData->mapFromMT;
                  $sql = "SELECT * FROM ".$relationMetaData->table." WHERE ".$relationMetaData->mapTo."='".$data->$val."'";
                  $manyData = Database::pdo_select($sql, array());
                  $res = array();
                  foreach($manyData as $mdK => $mdV) {
                    $model = new $modelName;
                    if(!in_array($modelName, $breakModel)) $res[] = $model->WHERE($relationMetaData->mapToET, $mdV->$valMT)->find('', false, $breakModel);
                  }
                  $data->$prop = $res;
                } else if($relationMetaData->relation=='ManyToOne' && $relationMetaData->fetchType=='eager' && !$break) {
                  if(!in_array($modelName, $breakModel)) $data->$prop=$model->where($relationMetaData->mapTo, $data->$val)->find('', false, $breakModel);
                }

                else if($relationMetaData->relation=='OneToOne' && $relationMetaData->fetchType=='break') {
                  $breakModel[] = get_class($this);
                  if(!in_array($modelName, $breakModel)) $data->$prop=$model->where($relationMetaData->mapTo, $data->$val)->find('', true, $breakModel);
                } else if($relationMetaData->relation=='OneToMany' && $relationMetaData->fetchType=='break') {
                  $breakModel[] = get_class($this);;
                  if(!in_array($modelName, $breakModel)) $data->$prop=$model->where($relationMetaData->mapTo, $data->$val)->findAll('', true, $breakModel);
                } else if($relationMetaData->relation=='ManyToMany' && $relationMetaData->fetchType=='break') {
                  $breakModel[] = get_class($this);
                  $valMT = $relationMetaData->mapFromMT;
                  $sql = "SELECT * FROM ".$relationMetaData->table." WHERE ".$relationMetaData->mapTo."='".$data->$val."'";
                  $manyData = Database::pdo_select($sql, array());
                  $res = array();
                  foreach($manyData as $mdK => $mdV) {
                    $model = new $modelName;
                    if(!in_array($modelName, $breakModel)) $res[] = $model->WHERE($relationMetaData->mapToET, $mdV->$valMT)->find('', true, $breakModel);
                  }
                  $data->$prop = $res;
                } else if($relationMetaData->relation=='ManyToOne' && $relationMetaData->fetchType=='break') {
                  $breakModel[] = get_class($this);
                  if(!in_array($modelName, $breakModel)) $data->$prop=$model->where($relationMetaData->mapTo, $data->$val)->find('', true, $breakModel);
                }
            }
        }
        return $data;
    }
    public function insertHaldleOneToOneRelation($data) {
      $i=0;
      foreach($data as $k=>$v) {
          if(gettype($v)=='object') {
            foreach (get_class_methods($this) as $method) {
              if (strpos($method, "map") === 0) {
                $relationMetaData = call_user_func_array(array($this, $method), array());
                $val = $relationMetaData->mapFrom;
                $mapTo = $relationMetaData->mapTo;
                $prop = $relationMetaData->property;
                $modelName = $this->$prop;
                $model = new $modelName;
                if($relationMetaData->relation=='OneToOne' && $k == $prop  && $relationMetaData->fetchType=='eager' && !$break) {
                  $childId = $model->save($v);
                  $model = $model->where('id', $childId)->find();
                  $v = $model->$mapTo;
                }
              }
            }
          } else if(gettype($v)!='object' && gettype($v)!='array') {
              if($i==0) $this->sql_query .= "'".$v."'";
                  else if($i>0) $this->sql_query .= ",'".$v."'";
              $i++;
            }
      }
      $this->sql_query .= ")";
      $s = $this->sql_query;
      $this->sql_query = '';
      $d = $this->data;
      $this->data = array();
      $id = Database::pdo_insert($s, $d);
      foreach($data as $k=>$v) {
        if(gettype($v)=='array') {
          foreach($v as $arrK=>$arrV) {
            foreach (get_class_methods($this) as $method)
            if (strpos($method, "map") === 0) {
                $relationMetaData = call_user_func_array(array($this, $method), array());
                $val = $relationMetaData->mapFrom;
                $mapTo = $relationMetaData->mapTo;
                $prop = $relationMetaData->property;
                $modelName = $this->$prop;
                $model = new $modelName;

                if($relationMetaData->relation=='OneToMany'  && $k == $prop  && $relationMetaData->fetchType=='eager' && !$break) {
                  $arrV->$mapTo = $id;
                  $model->save($arrV);
                }
                if($relationMetaData->relation=='ManyToMany'  && $k == $prop  && $relationMetaData->fetchType=='eager' && !$break) {
                  $secondId=$model->save($arrV);
                  $sql = "INSERT INTO ".$relationMetaData->table." (".$relationMetaData->mapTo.", ".$relationMetaData->mapFromMT.") VALUES('".$id."','".$secondId."')";
                  echo $sql;
                  Database::pdo_insert($sql, array());
                }
              }
            }
          }
        }
      return $id;
    }
}
?>
