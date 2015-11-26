<?php

namespace SendATruck\Controllers;

use SendATruck\DataLayer\UserRepository;
use SendATruck\DataLayer\PermissionRepository;
use SendATruck\Objects\UserPermission;
use SendATruck\Objects\User;

class Users
{

    /**
     * @var \Slim\Slim
     */
    private $app;

    /**
     * @var SendATruck\DataLayer\UserRepository
     */
    private $userRepository;

    /**
     * @var SendATruck\DataLayer\PermissionRepository
     */
    private $permissionRepository;

    public function __construct($app)
    {
        $this->app = $app;
        $this->userRepository = new UserRepository($this->app->db);
        $this->permissionRepository = new PermissionRepository($this->app->db);
    }

    public function index()
    {
        if (!$this->userHasPermission('view_users')) {
            $this->app->redirect('/');
        }
        $users = $this->userRepository->getAll();
        $this->app->render('users-list.html.twig', array('users' => $users));
    }

    public function newUser()
    {
        if (!$this->userHasPermission('edit_users')) {
            $this->app->redirect('/');
        }
        $this->app->render('users-new.html.twig');
    }

    public function newUserPost()
    {
        if (!$this->userHasPermission('edit_users')) {
            $this->app->redirect('/');
        }

        $userName = $this->app->request->post('username');
        $password = $this->app->request->post('password');

        $dupUser = $this->userRepository->getByUserName($userName);
        if ($dupUser->getUserName() == $userName) {
            $this->app->redirect('/users/' . $dupUser->getId());
        }

        $user = new User();
        $user->setUserName($userName);
        $user->setPassword($password);
        $id = $this->userRepository->add($user);
        if ($id) {
            $this->app->redirect('/users/' . $id);
        } else {
            $this->app->redirect('/users/');
        }
    }

    public function show($userId)
    {
        if (!$this->userHasPermission('view_users')) {
            $this->app->redirect('/');
        }
        $user = $this->userRepository->getById($userId);
        $permissions = $this->permissionRepository->getByUserId($userId);
        $this->app->render('users-view.html.twig',
            array('user' => $user, 'permissions' => $permissions, 'edit_user_permissions' => $this->permissionRepository->hasPermission('edit_user_permissions',
                $_SESSION['UserId'])));
    }

    public function addPermission()
    {
        if (!$this->userHasPermission('edit_user_permissions')) {
            $this->app->redirect('/');
        }
        $permissionName = $this->app->request->post('permission');
        $userId = $this->app->request()->post('userid');

        $userPermission = new UserPermission();
        $userPermission->setUserId($userId);
        $userPermission->setPermission($permissionName);

        $this->permissionRepository->add($userPermission);
        $this->app->redirect('/users/' . $userId);
    }

    public function removePermission($id)
    {
        if (!$this->userHasPermission('edit_user_permissions')) {
            $this->app->redirect('/');
        }
        $permission = $this->permissionRepository->getById($id);
        $this->permissionRepository->remove($id);
        $this->app->redirect('/users/' . $permission->getUserId());
    }

    public function userHasPermission($permission)
    {
        if (!array_key_exists('UserId', $_SESSION)) {
            return false;
        }
        if ($this->permissionRepository->hasPermission($permission, $_SESSION['UserId'])) {
            return true;
        }
        return false;
    }
}
