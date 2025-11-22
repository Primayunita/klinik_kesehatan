<?php

class UserModel {

    public static function find($user, $pass) {
        global $db;

        $sql = "SELECT * FROM users 
                WHERE username = :u 
                AND password = crypt(:p, password)";

        $stmt = $db->prepare($sql);
        $stmt->execute(['u'=> $user, 'p'=> $pass]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
