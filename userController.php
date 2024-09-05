<?php
include_once 'User.php';

class UserController {
    private $user;

    public function __construct($db) {
        $this->user = new User($db);
    }

    public function create($name, $email, $password, $room) {
        $this->user->name = $name;
        $this->user->email = $email;
        $this->user->password = password_hash($password, PASSWORD_DEFAULT);
        $this->user->room = $room;
        return $this->user->create();
    }

    public function update($id, $name, $email, $room) {
        $this->user->id = $id;
        $this->user->name = $name;
        $this->user->email = $email;
        $this->user->room = $room;
        return $this->user->update();
    }

    public function delete($id) {
        $this->user->id = $id;
        return $this->user->delete();
    }

    public function read($id) {
        $this->user->id = $id;
        return $this->user->readSingle();
    }

    public function readAll() {
        return $this->user->read();
    }

    public function authenticate($username, $password) {
        return $this->user->authenticate($username, $password);
    }
}
