<?php

namespace App\Models;

use App\Core\Db;

class Model extends Db
{
    protected $table;

    private $db;

    public function findAll()
    {
        $query = $this->req('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    public function findBy(array $elements)
    {
        $keys = [];
        $values = [];

        foreach ($elements as $key => $value){
            $keys[] = "$key = ?";
            $values[] = $value;
        }
        $keys_list = implode(' AND ', $keys);

        return $this->req('SELECT * FROM ' . $this->table . ' WHERE ' . $keys_list,
        $values)->fetchAll();
    }

    public function findById(int $id)
    {
        return $this->req("SELECT * FROM {$this->table} WHERE id = $id")->fetch();
    }

    public function create()
    {
        $keys = [];
        $inter = [];
        $values = [];

        foreach($this as $key => $value){
            if ($value !== null && $key != 'db' && $key != 'table'){
                $keys[] = $key;
                $inter[] = "?";
                $values[] = $value;
            }
        }

        $keys_list = implode(', ', $keys);
        $inter_list = implode(', ', $inter);


        return $this->req('INSERT INTO ' . $this->table . ' (' . $keys_list . ') VALUES (' . $inter_list . ')', $values);
    }

    public function update()
    {
        $keys = [];
        $values = [];

        // On boucle pour éclater le tableau
        foreach($this as $key => $value){
            // UPDATE annonces SET titre = ?, description = ?, actif = ? WHERE id= ?
            if($value !== null && $key != 'db' && $key != 'table'){
                $keys[] = "$key = ?";
                $values[] = $value;
            }
        }
        $values[] = $this->id;

        // On transforme le tableau "champs" en une chaine de caractères
        $keys_list = implode(', ', $keys);

        // On exécute la requête
        return $this->req('UPDATE '.$this->table.' SET '. $keys_list.' WHERE id = ?', $values);
    }

    public function delete(int $id){
        return $this->req("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function req(string $sql, array $attributes = null)
    {
        $this->db = Db::getInstance();

        if ($attributes !== null){
            $query = $this->db->prepare($sql);
            $query->execute($attributes);
            return $query;
        }else{
            return $this->db->query($sql);
        }
    }

    public function hydrate($data): Model
    {
        foreach ($data as $key => $value){
            $setter = 'set' . ucfirst($key);

            if (method_exists($this, $setter)){
                $this->$setter($value);
            }
        }
        return $this;
    }



}