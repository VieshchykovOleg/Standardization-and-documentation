<?php
namespace controllers;

use core\Controller;
use core\Core;
use core\View;
use models\Users;

class ProfileController extends Controller
{
    protected $view;

    public function __construct()
    {
        parent::__construct();
        $this->view = new View();
    }

    public function actionIndex()
    {
        // Перевіряємо, чи був відправлений POST-запит
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Отримуємо дані з форми
            $userId = $_SESSION['user']['id'];
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];

            // Викликаємо метод для оновлення профілю користувача
            Users::update($userId, $firstName, $lastName);

            // Додаємо повідомлення успіху в сесію
            $_SESSION['success_message'] = 'Профіль успішно оновлено.';

            // Перенаправляємо користувача на сторінку профілю
            $core = Core::get();
            $core->redirect("/users/profile");
        }

        // Отримуємо дані користувача для відображення у формі
        $user = Users::getUserById($_SESSION['user']['id']);

        // Рендеримо шаблон сторінки профілю
        $this->view->render('users/profile', [
            'user' => $user
        ]);
    }
}
