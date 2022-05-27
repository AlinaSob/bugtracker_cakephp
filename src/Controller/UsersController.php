<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Route\Route;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

class UsersController extends AppController
{
    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__('Username or password is incorrect'));
            }
        }
    }

    public function logout()
    {
        $this->Auth->logout();
        $this->redirect(Router::url(['controller' => 'Users', 'action' => 'login']));
    }
}