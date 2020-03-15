
<?php

/**
 * Class:  csci303sp20
 * User: jeberry
 * Date: 2/4/2020
 * Time: 9:12 AM
 */
$pagename = "Insert Form";
require_once "header.php";

/* ***********************************************************************
* SET INITIAL VARIABLES
* ***********************************************************************
*/
$showform = 1; //true flag to show form
$errmsg = 0; //false flag to track errors
$errtxtarea = "";  //create var for text area error
$erruname = "";
$errpwd="";
$errpwd2="";
$erremail="";
$errathlete="";
$errfood="";
$errcolor="";

/* ***********************************************************************
* PROCESS THE FORM UPON SUBMIT
* ***********************************************************************
*/
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    /* ***********************************************************************
    * SANITIZE USER DATA
    * Use for ALL fields where the data is typed in - not for select or radio, etc
    * Use strtolower()  for emails, usernames and other case-sensitive info
    * Use trim() for ALL user-typed data -- even those not required EXCEPT pwd
    * CAUTION:  Radio buttons are a bit different.
    *    see https://www.htmlcenter.com/blog/empty-and-isset-in-php/
    *
    * WHAT IF YOU HAVE A RADIO BUTTON?
    * if(isset($_POST['someradio'] && $_POST['someradio'] !="")
    * {
    *      $someradio = $_POST['someradio'];
    * }
    * ***********************************************************************
    */
    $txtarea = trim($_POST['txtarea']);
    $uname = strtolower(trim($_POST['uname']));


    /* ***********************************************************************
    * CHECK EMPTY FIELDS
    * Check for empty data for every REQUIRED  field
    * Do not do for things like apartment number, middle initial, etc.
    * CAUTION:  Radio buttons with 0 as a value = use isset() not empty()
    *    see https://www.htmlcenter.com/blog/empty-and-isset-in-php/
    *
    * NOTE:  For any error, we set the $errmsg variable to TRUE to display message.
    * ***********************************************************************
    */

    if (empty($uname)) {
        $erruname = "<span class='error'>The username area is required.</span>";
        $errmsg = 1;
    }
    if (empty($email)) {
        $erremail = "<span class='error'>The email area is required.</span>";
        $errmsg = 1;
    }
    if (empty($pwd)) {
        $errpwd = "<span class='error'>Please enter a password.</span>";
        $errmsg = 1;
    }
    if (empty($pwd2)) {
        $errpwd2 = "<span class='error'>The confirmation password area is required.</span>";
        $errmsg = 1;
    }
    if (empty($athlete)) {
        $errathlete = "<span class='error'> Please enter an athlete.</span>";
        $errmsg =1;
    }
    if (empty($color)) {
        $errcolor = "<span class='error'> You need to select a color'</span>";
        $errmsg =1;
    }
    if (empty($food)) {
        $errfood = "<span class='error'> You need to insert a favorite food'</span>";
        $errmsg =1;
    }

    /* ***********************************************************************
    * CHECK MATCHING FIELDS
    * Check to see if important fields match
    * Usually used for passwords and sometimes emails.  We'll do passwords.
    * ***********************************************************************
    */
    if ($pwd != $pwd2) {
        $errmsg = 1;
        $pwd2 = "<span class='error'>Passwords must match.</span>";
    }

    /* ***********************************************************************
    *  VALIDATE EMAILs or URLs
    * ***********************************************************************
    */
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errmsg = 1;
        $erremail = "<span class='error'> You must enter a valid email address.</span>";
    }

    /**************************
     * CHECKING PASSWORD LENGTH
     * ********************/

    if (strlen(pwd) < 8 || strlen($pwd) > 72) {
        $errsomevar = " <span class='error'>Password needs 8 to 11 characters.</span>";
        $errmsg = 1;
    }
    /* ***********************************************************************
     * CHECK EXISTING DATA
     * Check data to avoid duplicates
     * Usually used with emails and usernames - We'll do usernames
     * USE A FUNCTION FOR THIS
     * ***********************************************************************
     */


    /* ***********************************************************************
     * CONTROL CODE
     * This section is used to control whether we enter the block of code to
     * insert the data into the database or not.  If not, display
     * the errors.
     * ***********************************************************************
     */
    if ($errmsg == 1) {
        echo "<p class='error'>Please fix any errors and resubmit</p>";
    } else {
        $showform = 0;
        echo "<p class='success'>Thank you for the information.</p>";

        /* ***********************************************************************
        * HASH SENSITIVE DATA
        * Used for passwords and other sensitive data
        * If checked for matching fields, do NOT hash and insert both to the DB
        * ***********************************************************************
        */
        $hashedpwd = password_hash($pwd, PASSWORD_BCRYPT);
        /* ***********************************************************************
       * INSERT INTO THE DATABASE
       * NOT ALL data comes from the form - Watch for this!
       *    For example, input dates are not entered from the form
       * ***********************************************************************
       */
        try {
            $sql = "INSERT INTO xusers (uname, email, pwd, inputdate, athlete, food)
                VALUES (:uname, :email, :pwd, :inputdate, :athlete, :food) ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':uname', $uname);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue('pwd', $hashedpwd);
            $stmt->bindValue(':inputdate', $currenttime);
            $stmt->bindValue(':athlete', $athlete);
            $stmt->bindValue('food', $food);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        // else errormsg
    }//submit

}
/* ***********************************************************************
* DISPLAY FORM
* ***********************************************************************
*/


?>



<if ($showform == 1) {
    ?>

    <form name="insert" id="insert" action="<?php echo $currentfile;?>" method="post">
        <br>
        <label for="uname">UserName</label>
        <input type="text" name="uname" id="uname">

        <?php
        if (isset($erruname)) {
            echo $erruname . "<br>";
        }
        ?>

        <br>
        <label for="email">Email</label>
        <input type="email" name="email" id="email">

        <?php
        if (isset($erremail)) {
            echo $erremail . "<br>";
        }
        ?>

        <br>
        <label for="pwd"> Password </label>
        <input type="password"
               name ="pwd"
               id="pwd"
               size="30"
               minlength="8"
               maxlength="72"
               paceholder="required password (8-72 characters)."
               value="<?php if (isset($pwd)) {
                   echo $pwd;
               }
               ?>">
    <?php
        if (isset($errpwd)) {
        echo $errpwd . "<br>";
        }
        ?>

        <br>
        <label for="pwd2"> Confirm your password</label>
        <input type="password" name="pwd2" id="pwd2">

        <?php
        if (isset($errpwd2)) {
            echo $errpwd2 . "<br>";
        }
        ?>

        <br>
        <label for="athlete">Who is your favorite athlete</label>
        <input type="athlete" name="athlete" id="athlete">

        <?php
        if (isset($errathlete)) {
            echo $errathlete . "<br>";
        }
        ?>

         <br>
         <label for="food"> What is your favorite food</label>
         <input type="food" name="food" id="food">

        <?php
        if (isset($errfood)) {
            echo $errfood . "<br>";
        }
        ?>

         <br>
         <label for="color"> What is your favorite color</label>
         <input type="color" name="color" id="color">

        <?php
        if (isset($errcolor)) {
            echo $errcolor . "<br>";
        }
        ?>

        <br>
        <label for="submit">Submit:  </label>
        <input type="submit" name="submit" id="submit" value="submit">



    </form>


    <?php
//end showform
require_once "footer.php";
?>

