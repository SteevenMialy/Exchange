<?php

namespace app\controllers;

use app\models\Categorie;

class CategorieController
{
    private $categorieModel;

    public function __construct($db)
    {
        $this->categorieModel = new Categorie($db);
    }

    public function save()
    {
        if (isset($_POST['nomcategory'])) {
            $nomcategory = $_POST['nomcategory'];

            if ($this->categorieModel->create($nomcategory)) {
                echo "Catégorie ajoutée avec succès";
            } else {
                echo "Erreur lors de l'ajout";
            }
        }
    }

    public function getAllCategories()
    {
        $categories = $this->categorieModel->getAllCategorie();
        return $categories;
    }

    public function getCategorieById($id)
    {
        $categorie = $this->categorieModel->getCategorieById($id);
        return $categorie;
    }

    public function update()
    {
        if (isset($_POST['id'], $_POST['nomcategory'])) {
            $id = $_POST['id'];
            $nomcategory = $_POST['nomcategory'];

            if ($this->categorieModel->update($id, $nomcategory)) {
                echo "Catégorie mise à jour avec succès";
            } else {
                echo "Erreur lors de la mise à jour";
            }
        }
    }

    public function delete()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];

            if ($this->categorieModel->delete($id)) {
                echo "Catégorie supprimée avec succès";
            } else {
                echo "Erreur lors de la suppression";
            }
        }
    }
}
