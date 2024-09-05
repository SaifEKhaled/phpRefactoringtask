<?php
include_once 'room.php';

class RoomController {
    private $room;

    public function __construct($db) {
        $this->room = new Room($db);
    }

    public function create($name) {
        $this->room->name = $name;
        return $this->room->create();
    }

    public function update($id, $name) {
        $this->room->id = $id;
        $this->room->name = $name;
        return $this->room->update();
    }

    public function delete($id) {
        $this->room->id = $id;
        return $this->room->delete();
    }

    public function read() {
        return $this->room->read();
    }
}
?>
