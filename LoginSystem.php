<?php
include ("db_config.php");
include ("config.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
class LoginSystem
{

    public $lastname;
    public $firstname;
    public $city;
    public $adress;
    public $email;
    public $username;
    public $password;
    public $password_ver;
    public $code;
    public $phone;

    public function __construct($post_data) {
        foreach ($post_data as $data)
        {
            $data = trim($data);
        }
        $this->lastname = !empty($post_data['lastname']) ? $post_data['lastname'] : null;
        $this->firstname = !empty($post_data['firstname']) ? $post_data['firstname'] : null;
        $this->city = !empty($post_data['city']) ? $post_data['city'] : null;
        $this->adress = !empty($post_data['adress']) ? $post_data['adress'] : null;
        $this->phone = !empty($post_data['phone']) ? $post_data['phone'] : null;
        $this->email = !empty($post_data['email']) ? $post_data['email'] : null;
        $this->username = !empty($post_data['username']) ? $post_data['username'] : null;
        $this->password = !empty($post_data['password']) ? $post_data['password'] : null;
        $this->password_ver = !empty($post_data['password_ver']) ? $post_data['password_ver'] : null;
        $this->code = !empty($post_data['captcha']) ? $post_data['captcha'] : null;
    }
    function registerUser()
    {
        $type = 1;
        global $connection;
        $password_new = SALT1 . $this->password . SALT2;
        $passMD5 = MD5($password_new);
        $code = $this->createCode(40);

        $stmt = $connection->prepare("INSERT INTO users (username,password,firstname,lastname,email,
                   lastTime_loggedin, lastTime_loggedin_new, code,registration_expires, city, adress, phone) 
                   VALUES (?,?,?,?,?,now(),now(),?,DATE_ADD(now(),INTERVAL 1 DAY),?,?,?)");
        $stmt -> bind_param('sssssssss',$this->username,$passMD5,$this->firstname,$this->lastname,
        $this->email,$code,$this->city,$this->adress, $this->phone);
        $stmt ->execute();
        $stmt -> close();
        $this->sendData($code,$this->username,$type);
    }
    function createCode(int $length): string
    {
        $down = 97;
        $up = 122;
        $i = 0;
        $code = "";
        $div = mt_rand(3, 9);

        while ($i < $length) {
            if ($i % $div == 0)
                $character = strtoupper(chr(mt_rand($down, $up)));
            else
                $character = chr(mt_rand($down, $up)); // mt_rand(97,122) chr(98)
            $code .= $character; // $code = $code.$character; //
            $i++;
        }
        return $code;
    }
    function existsUser(): bool
    {
        global $connection;

        $sql = "SELECT id_user FROM users
            WHERE username = '$this->username'";// AND registration_expires>now()

        $result = mysqli_query($connection, $sql) or die(mysqli_error($connection));

        if (mysqli_num_rows($result) > 0)
            return true;
        else
            return false;
    }
    function checkEmail()
    {

        global $connection;

        $sql = "SELECT id_user FROM users
            WHERE email = '$this->email'";

        $result = mysqli_query($connection, $sql) or die(mysqli_error($connection));

        //if (mysqli_num_rows($result) > 0)

        if (mysqli_num_rows($result)>0)
        {
            return true;
        }
        else
        {
            return false;
        }

    }
    function validate()
    {
        $firstname_error = (empty($this->firstname)) ? 1 : 0;
        $lastname_error = (empty($this->lastname)) ? 1: 0;
        $city_error = (empty($this->city)) ? 1:0;
        $adress_error = (empty($this->adress)) ? 1:0;
        $phone_error = (empty($this->phone)) ? 1:0;
        $email_error = (empty($this->email)) ? 1:0;
        $username_error = (empty($this->username)) ? 1:0;
        $password_error = (empty($this->password)) ? 1:0;
        $password_ver_error = (empty($this->password_ver)) ? 1:0;
        if ($password_error == 0 && $password_ver_error == 0 && $this->password != $this->password_ver)
        {
            $password_match = 1;
        }
        else
        {
            $password_match = 0;
        }

        if (empty($this->code))
            $captcha_error = 1;
        else {
            $captcha_error = 0;
            if ($this->code != $_SESSION["code"])
            {
                $captcha_error = 2;
            }
        }
        $_SESSION['InputLastname'] = $this->lastname;
        $_SESSION['InputFirstName'] = $this->firstname;
        $_SESSION['InputCity'] = $this->city;
        $_SESSION['InputAdress'] = $this->adress;
        $_SESSION['InputPhone'] = $this->phone;
        $_SESSION['InputEmail'] = $this->email;
        $_SESSION['InputUsername'] = $this->username;

        if ($firstname_error == 1 or $lastname_error == 1 or $city_error == 1 or $adress_error == 1 or $phone_error == 1
            or $email_error == 1 or $username_error == 1 or $password_error == 1 or $password_ver_error == 1
            or $captcha_error == 1 or $captcha_error==2 or $password_match==1) {
            Header("Location: register.php?firstname_error=" . $firstname_error . "&lastname_error=" . $lastname_error .
                "&city_error=" . $city_error . "&adress_error=" . $adress_error . "&phone_error=" . $phone_error .
                "&email_error=" . $email_error . "&username_error=" . $username_error . "&password_error=" . $password_error .
                "&password_ver_error=" . $password_ver_error . "&captcha_error=" . $captcha_error .
                "&password_match=" . $password_match);

        }
        else
        {

            return true;
        }
    }
    function sendData(string $code,string $username, string $type)
    {
        $header = "From: WEBMASTER <webmaster@elhozom.hu>\n";
        $header .= "X-Sender: webmaster@elhozom.hu\n";
        $header .= "X-Mailer: PHP/" . phpversion();
        $header .= "X-Priority: 1\n";
        $header .= "Reply-To:webmaster@elhozom.hu\r\n" .
            $header .= "Content-Type: text/html; charset=UTF-8\n";

        $message = "Üdvözöljük, :\n\n $username \n, elhozom.hu-n.";
        if ($type==1){
        $message .= "\n\n Kattintson a linkre hogy aktiválja a felhasználói fiókát: " . SITE . "/activate.php?code=$code";
        }
        else
        {
            $message .= "\n\n Kattintson a linkre hogy újra betudja állítani a felhasználói jelszavát: http://localhost/Ehesvagyok/recovery_form.php?code=$code";
        }
        $to = $this->email;
        if ($type==1)
        {
            $subject = "Regisztráció";
        }
        else
        {
            $subject = "Jelszó visszaállitás";
        }


        mail($to, $subject, $message, $header);
        session_unset();
        if ($type==1){
        Header("Location: register.php?succes=1");
        }
        //mail($to,$subject,$message);

        /*

        1 is urgent, 3 is normal

        https://github.com/Synchro/PHPMailer



        */
    }
    function PasswordRecovery()
    {
        $type = 2;
        global $connection;
        $stmt = $connection -> prepare("Select username from users WHERE email = ?");
        $stmt -> bind_param("s",$this->email);
        $stmt -> execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $username = $result[0]['username'];
       // $_SESSION['email'] = $this->email;
        $stmt->close();
        $new_pass_code = $this->createCode(40);
        $stmt = $connection -> prepare("UPDATE users SET code_password= ?, new_password_expires = DATE_ADD(now(),INTERVAL 1 DAY)  WHERE email = ?");
        $stmt -> bind_param("ss",$new_pass_code,$this->email);
        $stmt -> execute();
        $stmt ->close();
        $this->sendData($new_pass_code,$username,$type);
        Header("Location: password_recovery.php?succes=1");
    }
    function checkPassandUser()
    {
        session_start();
        global $connection;
        $pw1 = SALT1 . $this->password . SALT2;
        $pw = MD5($pw1);

        $sql = "SELECT * FROM users
            WHERE username = '$this->username' AND password = '$pw' AND active = 1";
        echo $this->username . "<br>";
        echo $pw ."<br>";
        $result = mysqli_query($connection, $sql) or die(mysqli_error($connection));
        $row = mysqli_fetch_all($result);

        if ($row)
        {
            $_SESSION['username'] = $this->username;
            return true;
        }
        else
            return false;
    }

}