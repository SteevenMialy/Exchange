<?php

namespace app\controllers;

use app\models\Category;
use Flight;
use flight\Engine;
use Throwable;

class CategoryController
{

    protected Engine $app;



    public function __construct($app)
    {
        $this->app = $app;
    }

    public static function insertcategory()
    {
        $cat = new Category();
        $cat->setNomCategory($_POST['nomcategory']); // ← IMPORTANT
        $cat->insert(Flight::db());
    }

    public static function allcategory()
    {
        $cat = new Category();
        $cats = $cat->findAll(Flight::db());
        return $cats;
    }

    public static function modifycategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id']; // récupéré depuis le champ caché du formulaire

            // 1️⃣ Récupérer la catégorie existante
            $cat = Category::findById(Flight::db(), $id);
            if (!$cat) {
                throw new \Exception("Catégorie introuvable !");
            }

            // 2️⃣ Mettre à jour le nom
            $cat->setNomCategory($_POST['nomcategory']);

            // 3️⃣ Gérer l'image si uploadée
            if (isset($_FILES['img_path']) && $_FILES['img_path']['error'] === 0) {
                $uploadDir = "uploads/category/";
                if (!is_dir($uploadDir))
                    mkdir($uploadDir, 0777, true);

                $extension = pathinfo($_FILES['img_path']['name'], PATHINFO_EXTENSION);
                $filename = uniqid("cat_", true) . "." . $extension;
                $targetFile = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['img_path']['tmp_name'], $targetFile)) {
                    $cat->setImg($filename);
                }
            }

            // 4️⃣ Appeler la méthode update du modèle
            $cat->update(Flight::db());
        }
    }

    public static function countObjectsInCategory($id_cat)
    {
        $cat = new Category();
        return $cat->countObjects(Flight::db(), $id_cat);
    }

    public static function find($id)
    {
        return Category::findById(Flight::db(), $id);
    }
}
